<?php
namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;

/**
 * DescargaEncabezados Controller
 *
 * @property \App\Model\Table\DescargaEncabezadosTable $DescargaEncabezados
 */
class DescargaEncabezadosController extends AppController
{

    /**
     * Metodo utilizado para verificar el nivel de autorizacion de un usuario
     *
     * @param int|null $user uid de un Usuario a consultar
     * @return bool que indica si el usuario a sido autorizado (true) o no (false)
     */
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['listar']))
            return true;

        switch ($this->request->action) {
            case 'add': return (bool)in_array('rmp_descarga_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('rmp_descarga_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('rmp_descarga_delete', $this->Auth->user('privilegios')); break;
            case 'lock': return (bool)in_array('rmp_descarga_lock', $this->Auth->user('privilegios')); break;
            case 'unlock': return (bool)in_array('rmp_descarga_unlock', $this->Auth->user('privilegios')); break;
            case 'listarDisponibles': return (bool)array_in_array(['rmp_guia_add', 'rmp_guia_edit'], $this->Auth->user('privilegios')); break;
            case 'listarDisponiblesFolios': return (bool)array_in_array(['produccion_folio_add', 'produccion_folio_edit'], $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Metodo utilizado para listar las Descargas, que luego serán mostradas
     * en las datatables
     *
     * @param int|null $recalada Marea id
     * @param string|null $estado nombre del estado de las descargas a consultar
     * @return void
     */
    public function listar($recalada = null, $estado = 'ABIERTO')
    {
        $descargas = $this->DescargaEncabezados->find('all', [
            'contain' => ['Estados', 'TipoDescargas', 'Movimientos','DescargaDetalles', 'DescargaDetalles.Unidades', 'DescargaDetalles.Destinatarios', 'DescargaDetalles.Especies']
        ])->where(['Estados.nombre' => $estado]);

        if ($recalada)
            $descargas = $descargas->where([
                'recalada_id' => $recalada
            ]);

        $this->set([
            'descargas' => $descargas,
            '_serialize' => ['descargas']
        ]);
    }

    /**
     * Metodo utilizado para listar las DescargasDisponibles con saldo pendiente
     * por asignar a Guias
     *
     * @return void
     */
    public function listarDisponibles($recursoId)
    {
        $areasIds = $this->Auth->user('areas_ids');

        // Se seleccionan las naves que tienen un area en común con el usuario
        $areas_naves_ids = array_keys($this->loadModel('Naves')->find('list')
            ->innerJoinWith('Areas', function ($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })->toArray());

        // Se selecciones los puertos
        $areas_recintos_ids = array_keys($this->loadModel('Puertos')->find('list')
            ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })->toArray());

        $descargas = $this->loadModel('DescargasDisponibles')->find('all', [
            'contain' => ['DescargaDetalles',
                          'DescargaDetalles.Unidades',
                          'DescargaDetalles.Destinatarios' => function ($q) {
                              return $q->select(['id', 'nombre_razon_social', 'nombre', 'apellido_paterno', 'apellido_materno']);
                          },
                          'DescargaDetalles.Especies' => function ($q) {
                              return $q->select(['id', 'nombre']);
                          },
                          'Recaladas.Mareas',
                          'Recaladas.Mareas.Naves' => function ($q) {
                              return $q->select(['id', 'nombre']);
                          },
                          'Recaladas.Mareas.Puertos.Recintos']
        ])
            ->where([
                'Mareas.recurso_id' => $recursoId,
                'OR' => [
                  'Naves.id IN' => $areas_naves_ids,
                  'Recintos.id IN' => $areas_recintos_ids
                ]
            ]);

        if ($this->request->query('disponible') == true) {
            $descargas = $descargas->reduce(function ($descargas, $descarga) {
                $disponible = false;
                foreach($descarga->descarga_detalles as $detalle) {
                    if ($detalle->unidades[0]->_joinData->cantidad_disponible > 0) {
                        $disponible = true;
                        break;
                    }
                }
                if ($disponible) {
                    $descargas[] = $descarga;
                }
                return $descargas;
            }, []);
        }

        $this->set([
            'descargas' => $descargas,
            '_serialize' => ['descargas']
        ]);

        $this->render('listar');
    }

    /**
     * Metodo utilizado para listar las DescargasDisponibles con saldo pendiente
     * por asignar a Folios
     *
     * @return void
     */
    public function listarDisponiblesFolios()
    {
      set_time_limit(3000);
        $areasIds = $this->Auth->user('areas_ids');

        // Se seleccionan las naves que tienen un area en común con el usuario
        $areas_naves_ids = array_keys($this->loadModel('Naves')->find('list')
            ->innerJoinWith('Areas', function ($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })->toArray());

        // Se selecciones los puertos
        $areas_recintos_ids = array_keys($this->loadModel('Puertos')->find('list')
            ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })->toArray());

        $descargas = $this->loadModel('DescargasDisponiblesFolios')->find('all', [
            'contain' => ['DescargaDetalles', 'DescargaDetalles.Unidades',
                          'DescargaDetalles.Destinatarios',
                          'DescargaDetalles.Especies',
                          'Recaladas.Mareas',
                          'Recaladas.Mareas.Naves',
                          'Recaladas.Mareas.Puertos.Recintos']
        ])
            ->where([
                'Mareas.recurso_id' => 2, // XXX: Por ahora solo para langostinos
                'OR' => [
                  'Naves.id IN' => $areas_naves_ids,
                  'Recintos.id IN' => $areas_recintos_ids
                ]
            ]);

        $this->set([
            'descargas' => $descargas,
            '_serialize' => ['descargas']
        ]);

        $this->render('listar');
    }

    /**
    * Add method
    *
    * @return void
    */
    public function add($recursoId)
    {
      $areasIds = $this->Auth->user('areas_ids');
      if ( empty($recursoId) ) {
        // XXX: Debe arrojar un error cuando el recurso no es pasado correctamente
        //$recursoId = $this->request->Session()->read('recurso.id');
      }

      // Se carga la informacion del recurso
      $recurso = $this->loadModel('Recursos')->get($recursoId);
      $this->set('recurso', $recurso);

      $status = 'success';
      $descargaEncabezado = $this->DescargaEncabezados->newEntity();
      if ($this->request->is('post')) {
        if ($this->request->data['tipo_descarga_id'] == 1 && !empty($this->request->data['fecha_primer_lance_time'])) {
          $this->request->data['fecha_primer_lance'] = $this->request->data('fecha_primer_lance_date').' '.$this->request->data('fecha_primer_lance_time');
        } else if ($this->request->data['tipo_descarga_id'] == 2) {
          $this->request->data['fecha_pesca'] = $this->request->data('fecha_pesca_date').' '.$this->request->data('fecha_pesca_time');
        }
        $this->request->data['inicio_desembarque'] = $this->request->data('inicio_desembarque_date').' '.$this->request->data('inicio_desembarque_time');
        $this->request->data['termino_desembarque'] = $this->request->data('termino_desembarque_date').' '.$this->request->data('termino_desembarque_time');
        $descargaEncabezado = $this->DescargaEncabezados->patchEntity($descargaEncabezado, $this->request->data, [
          'associated' => ['DescargaDetalles', 'DescargaDetalles.Unidades']
        ]);
        $descargaEncabezado->set('estado_id', '3');
        $descargaEncabezado->set('usuario_uid', $this->Auth->user('uid'));
        if ($this->DescargaEncabezados->save($descargaEncabezado)) {
          $status = 'success';
        } else {
          $status = 'error';
        }
      }

      $unidades = $this->loadModel('Recursos')->get($recursoId, [
        'contain' => ['Unidades']
      ])->unidades;

      $tipoDescargas = $this->DescargaEncabezados->tipoDescargas->find('list');
      $destinatarios = $this->DescargaEncabezados->DescargaDetalles->Destinatarios->find('list')
          ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          });
      $destinatarios = $destinatarios->toArray();
      asort($destinatarios);
      $tcss = $this->DescargaEncabezados->DescargaDetalles->TCSs->find('list')
          ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          });
      $tcss = $tcss->toArray();
      asort($tcss);
      $movimientos = $this->DescargaEncabezados->Movimientos->find('list');

      $camanchaca_id = Configure::read('camanchaca_id');
      $this->set(compact('descargaEncabezado', 'status', 'movimientos', 'destinatarios', 'tcss', 'especies', 'tipoDescargas', 'unidades', 'camanchaca_id'));
      $this->set('_serialize', ['descargaEncabezado']);
    }

    /**
     * Edit method
     *
     * @param string|null $id DescargaEncabezado id.
     * @return void
     */
    public function edit($recursoId, $id = null)
    {
      $areasIds = $this->Auth->user('areas_ids');

      if ( empty($recursoId) ) {
        // XXX: deberia tirar error si no está bien el recurso
        #$recursoId = $this->request->Session()->read('recurso.id');
      }

      // Se carga la informacion del recurso
      $recurso = $this->loadModel('Recursos')->get($recursoId);
      $this->set('recurso', $recurso);

        $status = 'success';
        $descargaEncabezado = $this->DescargaEncabezados->get($id, [
            'contain' => [
              'DescargaDetalles',
              'DescargaDetalles.Unidades',
              'DescargaDetalles.Especies',
              'DescargaDetalles.ZonasPesca',
              'DescargaDetalles.Licencias',
              'Recaladas.Mareas.Naves'
            ]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
          if ($this->request->data['tipo_descarga_id'] == 1 && !empty($this->request->data['fecha_primer_lance_time'])) {
            $this->request->data['fecha_primer_lance'] = $this->request->data('fecha_primer_lance_date').' '.$this->request->data('fecha_primer_lance_time');
          } else if ($this->request->data['tipo_descarga_id'] == 2) {
            $this->request->data['fecha_pesca'] = $this->request->data('fecha_pesca_date').' '.$this->request->data('fecha_pesca_time');
          }
          $this->request->data['inicio_desembarque'] = $this->request->data('inicio_desembarque_date').' '.$this->request->data('inicio_desembarque_time');
          $this->request->data['termino_desembarque'] = $this->request->data('termino_desembarque_date').' '.$this->request->data('termino_desembarque_time');
            $descargaEncabezado = $this->DescargaEncabezados->patchEntity($descargaEncabezado, $this->request->data, [
                'associated' => ['DescargaDetalles', 'DescargaDetalles.Unidades', 'DescargaDetalles.Unidades._joinData']
            ]);
            $descargaEncabezado->set('usuario_uid', $this->Auth->user('uid'));
            if ($this->DescargaEncabezados->save($descargaEncabezado)) {
                $detallesIds = [];
                foreach($descargaEncabezado->descarga_detalles as $d) {
                    $detallesIds[] = $d->id;
                }

                $query = $this->DescargaEncabezados
                              ->DescargaDetalles->find('all')
                              ->where([
                                  'descarga_encabezado_id' => $descargaEncabezado->id,
                                  'id NOT IN' => $detallesIds
                              ])
                              ->toArray();
                foreach ($query as $deleteDetalle) {
                    $this->DescargaEncabezados->DescargaDetalles->delete($deleteDetalle);
                }

                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $unidades = $this->loadModel('Recursos')->get($recursoId, [
          'contain' => ['Unidades']
        ])->unidades;

        $tipoDescargas = $this->DescargaEncabezados->tipoDescargas->find('list');
        $destinatarios = $this->DescargaEncabezados->DescargaDetalles->Destinatarios->find('list')
        ->innerJoinWith('Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        });
        $destinatarios = $destinatarios->toArray();
        asort($destinatarios);

        // TCS
        $tcss = $this->DescargaEncabezados->DescargaDetalles->TCSs->find('list')
        ->innerJoinWith('Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        });
        $tcss = $tcss->toArray();
        asort($tcss);

        $especies = $this->DescargaEncabezados->DescargaDetalles->Especies->find('list');
        $especies = $especies->toArray();
        asort($especies, SORT_STRING);
        $movimientos = $this->DescargaEncabezados->Movimientos->find('list');

        // Se le pasa el id de la camanchaca para tener datos por defecto
        $camanchaca_id = Configure::read('camanchaca_id');
        $this->set(compact('descargaEncabezado', 'status', 'movimientos', 'destinatarios', 'tcss', 'especies', 'tipoDescargas', 'unidades', 'camanchaca_id'));
        $this->set('_serialize', ['descargaEncabezado']);
    }

    /**
     * Delete method
     *
     * @param string|null $id DescargaEncabezado id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $descargaEncabezado = $this->DescargaEncabezados->get($id);
        if ($this->DescargaEncabezados->delete($descargaEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('status'));
    }

    /**
     * Metodo utilizado para manejar el cierre de una descarga
     *
     * @param int|null $id DescargaEncabezado $id
     * @return void
     **/
    public function lock($id = null) {
        //$this->request->allowMethod(['post']);

        $descargaEncabezado = $this->DescargaEncabezados->get($id, ['contain' => [
            'DescargaDetalles'
        ]]);

        if ($descargaEncabezado->guias_abiertas) {
            $status = 'error';
        } else {
            $descargaEncabezado->set('estado_id', '4');
            $this->DescargaEncabezados->touch($descargaEncabezado, 'Model.lock');
            if ($this->DescargaEncabezados->save($descargaEncabezado)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('descargaEncabezado', 'status'));
    }

    /**
     * Metodo utilizado para manejar el re-apertura de una descarga
     *
     * @param int|null $id DescargaEncabezado $id
     * @return void
     **/
    public function unlock($id = null) {
        //$this->request->allowMethod(['post']);

        $descargaEncabezado = $this->DescargaEncabezados->get($id);
        $descargaEncabezado->set('estado_id', '3');
        if ($this->DescargaEncabezados->save($descargaEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('descargaEncabezado', 'status'));
        $this->render('lock');
    }
}
