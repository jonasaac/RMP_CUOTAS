<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GuiaEncabezados Controller
 *
 * @property \App\Model\Table\GuiaEncabezadosTable $GuiaEncabezados
 */
class GuiaEncabezadosController extends AppController
{
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['index', 'listar']))
            return true;

        switch ($this->request->action) {
            case 'add': return (bool)in_array('rmp_guia_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('rmp_guia_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('rmp_guia_delete', $this->Auth->user('privilegios')); break;
            case 'lock': return (bool)in_array('rmp_guia_lock', $this->Auth->user('privilegios')); break;
            case 'unlock': return (bool)in_array('rmp_guia_unlock', $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return void
     */
     public function index()
     {
         $guiasFirstDate = $this->loadModel('GuiaEncabezados')->find('all')
            ->select('fecha_salida')->order(['fecha_salida ASC']);

         if( $guiasFirstDate->isEmpty() )
             $firstYear = date('Y');
         else
             $firstYear = $guiasFirstDate->first()->toArray()['fecha_salida']->format('Y');

         $years = range(date('Y'), $firstYear);
         $years = array_combine($years, $years);
         $recursos = $this->loadModel('Recursos')->find('list')
            ->where(['Recursos.id IN' => $this->Auth->user('recursos_ids')]);

         $this->set(compact('years', 'recursos'));
         $this->set('_serialize', ['years', 'divisions']);
     }

    public function listar($year = null, $estado = 'ABIERTO')
    {
      $recursosIds = $this->Auth->user('recursos_ids');
      $areasIds = $this->Auth->user('areas_ids');

      // Se determina el orden que deben tener los datos
      $orderColumnId = $this->request->data('order.0.column');
      $orderColumnName = $this->request->data('columns.'.$orderColumnId.'.name');

      // Se seleccionan los origenes que tienen un area en común con el usuario
      $areas_origenes_ids = array_keys($this->GuiaEncabezados->OrigenRecintos->find('list')
          ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          })->toArray());

      // Se seleccionan los destinos que tienen un area en común con el usuario
      $areas_destinos_ids = array_keys($this->GuiaEncabezados->DestinoRecintos->find('list')
          ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          })->toArray());

      $guias = $this->GuiaEncabezados->find('all', [
        'contain' => ['Choferes', 'Camiones', 'OrigenRecintos', 'DestinoRecintos', 'Estados']
        ])
      ->where([
        'Estados.nombre' => $estado,
        'GuiaEncabezados.recurso_id IN' => $recursosIds,
        'OR' => [
          'OrigenRecintos.id IN' => $areas_origenes_ids,
          'DestinoRecintos.id IN' => $areas_destinos_ids
        ]
      ]);
      /*->offset($this->request->data('start'))
      ->limit($this->request->data('length'))*/

      if ($year) {
        $guias = $guias->where(function ($exp, $q) use ($year) {
          $ym = $q->func()->year([
            'fecha_salida' => 'literal',
            ]);
            return $exp->eq($ym, $year);
        });
      }

      $totaldata = $guias->count();

      $searchString = $this->request->data('search.value');
      if ( !empty($searchString) ) {
        $array_search = explode(' ', $searchString);

        $guias_array = [];
        foreach ($array_search AS $search) {
          if (empty($search))
            continue;
          $tmp_guias = $guias->cleanCopy();
          $tmp_guias->where([
            'OR' => [
              // IDs
              'CAST(GuiaEncabezados.id AS VARCHAR) LIKE'    => '%'.$search.'%',
              // NroGuias
              'CAST(GuiaEncabezados.nro_guia AS VARCHAR) LIKE'    => '%'.$search.'%',
              // Origen
              'OrigenRecintos.nombre LIKE'       => '%'.$search.'%',
              // Destino
              'DestinoRecintos.nombre LIKE'       => '%'.$search.'%',
              // Fecha
              'dbo.ConvertirFecha(GuiaEncabezados.fecha_salida) LIKE' => '%'.$search.'%',
              // Fecha
              'dbo.ConvertirFecha(GuiaEncabezados.fecha_recepcion) LIKE' => '%'.$search.'%',
              // Camiones
              'Camiones.patente LIKE'              => '%'.$search.'%',
              // Choferes
              'Choferes.nombre_razon_social LIKE' => '%'.$search.'%',
              'Choferes.nombre LIKE'              => '%'.$search.'%',
              'Choferes.apellido_paterno LIKE'    => '%'.$search.'%',
              'Choferes.apellido_materno LIKE'    => '%'.$search.'%'
            ]
          ]);

          $tmp_guias_array = $tmp_guias->toArray();
          if (empty($guias_array)) {
            $guias_array = $tmp_guias_array;
          } else {
            $guias_array = array_uintersect($tmp_guias_array, $guias_array, "comparacion_ids");
          }
        }
      } else {
          $guias_array = $guias->toArray();
      }

      $totalfiltered = count($guias_array);
      $guias_array = array_slice($guias_array, $this->request->data('start'), $this->request->data('length'));

      $this->set([
        'guias'         => $guias_array,
        'draw'          => $this->request->data('draw'),
        'totaldata'     => $totaldata,
        'totalfiltered' => $totalfiltered,
        '_serialize' => ['guias']
      ]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($recursoId)
    {
        $areasIds = $this->Auth->user('areas_ids');
        $status = 'success';
        $guiaEncabezado = $this->GuiaEncabezados->newEntity();
        if ($this->request->is('post')) {
          $this->request->data['fecha_salida'] = $this->request->data('fecha_salida_date').' '.$this->request->data('fecha_salida_time');
          if (!empty($this->request->data('fecha_recepcion_date'))) {
            $this->request->data['fecha_recepcion'] = $this->request->data('fecha_recepcion_date').' '.$this->request->data('fecha_recepcion_time');
          }
            if( $this->request->data['virtual'] ) {
                $this->request->data['fecha_recepcion'] = $this->request->data['fecha_salida'];
                $this->request->data['nro_guia'] = $this->request->data['codigo_descarga'].'-'.$this->request->data['descarga_encabezado_id'];
            }
            $guiaEncabezado = $this->GuiaEncabezados->patchEntity($guiaEncabezado, $this->request->data, [
                'associated' => ['GuiaDetalles', 'GuiaDetalles.Unidades']
            ]);
            $guiaEncabezado->set('estado_id', '3');
            $guiaEncabezado->set('recurso_id', $recursoId);
            $guiaEncabezado->set('division_id', '1');
            $guiaEncabezado->set('usuario_uid', $this->Auth->user('uid'));
            if ($this->GuiaEncabezados->save($guiaEncabezado)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $recurso = $this->loadModel('Recursos')->get($recursoId, [
          'contain' => ['UnidadesPrincipales']
        ]);

        $plantas = $this->GuiaEncabezados->OrigenRecintos->find('list')
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })
            ->matching('Plantas');
        $plantas = $plantas->toArray();
        asort($plantas, SORT_STRING);
        $pontones = $this->GuiaEncabezados->OrigenRecintos->find('all')
            ->contain(['Pontones.Puertos'])
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })
            ->matching('Pontones')
            ->reduce(function ($output, $value) {
              if(!array_key_exists($value->id, $output)) {
                $output[$value->id] = $value->ponton->puerto->nombre.' - '.$value->nombre;
              }
              return $output;
            }, []);
        asort($pontones, SORT_STRING);

        $origenes = [
            'Plantas' => $plantas,
            'Pontones' => $pontones
        ];

        $destinos = [
            'Plantas' => $plantas
        ];
        $camiones = $this->GuiaEncabezados->Camiones->find('list')
            ->where(['Camiones.estado_id' => '1'])
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            });
        $camiones = $camiones->toArray();
        asort($camiones, SORT_STRING);
        $choferes = $this->GuiaEncabezados->Choferes->find('list')
            ->where(['Choferes.estado_id' => '1'])
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            });
        $choferes = $choferes->toArray();
        asort($choferes, SORT_STRING);
        $movimientos = $this->GuiaEncabezados->Movimientos->find('list')
            ->order(['nombre' => 'ASC']);

        $this->set(compact('guiaEncabezado', 'choferes', 'camiones', 'origenes', 'destinos', 'movimientos', 'status', 'recurso'));
        $this->set('_serialize', ['guiaEncabezado']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Guia Encabezado id.
     * @return void
     */
    public function edit($id = null)
    {
        $areasIds = $this->Auth->user('areas_ids');
        $status = 'success';
        $guiaEncabezado = $this->GuiaEncabezados->get($id, [
            'contain' => ['GuiaDetalles',
                          'GuiaDetalles.DescargaDetalles',
                          'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas.Naves',
                          'GuiaDetalles.Especies',
                          'GuiaDetalles.Unidades']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
          $this->request->data['fecha_salida'] = $this->request->data('fecha_salida_date').' '.$this->request->data('fecha_salida_time');
          if (!empty($this->request->data('fecha_recepcion_date'))) {
            $this->request->data['fecha_recepcion'] = $this->request->data('fecha_recepcion_date').' '.$this->request->data('fecha_recepcion_time');
          }
            if( $this->request->data['virtual'] ) {
                $this->request->data['fecha_recepcion'] = $this->request->data['fecha_salida'];
            }

            $guiaEncabezado = $this->GuiaEncabezados->patchEntity($guiaEncabezado, $this->request->data, [
                'associated' => ['GuiaDetalles', 'GuiaDetalles.Unidades', 'GuiaDetalles.Unidades._joinData']
            ]);
            $guiaEncabezado->set('usuario_uid', $this->Auth->user('uid'));
            if ($this->GuiaEncabezados->save($guiaEncabezado)) {
                $detallesIds = [];
                foreach($guiaEncabezado->guia_detalles as $d) {
                    $detallesIds[] = $d->id;
                }

                $query = $this->GuiaEncabezados
                              ->GuiaDetalles->find('all')
                              ->where([
                                  'guia_encabezado_id' => $guiaEncabezado->id,
                                  'id NOT IN' => $detallesIds
                              ])
                              ->toArray();

                foreach ($query as $deleteDetalle) {
                    $this->GuiaEncabezados->GuiaDetalles->delete($deleteDetalle);
                }

                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $recurso = $this->loadModel('Recursos')->get($guiaEncabezado->recurso_id, [
          'contain' => ['UnidadesPrincipales']
        ]);

        $plantas = $this->GuiaEncabezados->OrigenRecintos->find('list')
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })
            ->matching('Plantas');
        $plantas = $plantas->toArray();
        asort($plantas, SORT_STRING);
        $pontones = $this->GuiaEncabezados->OrigenRecintos->find('all')
            ->contain(['Pontones.Puertos'])
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            })
            ->matching('Pontones')
            ->reduce(function ($output, $value) {
              if(!array_key_exists($value->id, $output)) {
                $output[$value->id] = $value->ponton->puerto->nombre.' - '.$value->nombre;
              }
              return $output;
            }, []);
        asort($pontones, SORT_STRING);

        $origenes = [
            'Plantas' => $plantas,
            'Pontones' => $pontones,
        ];

        $destinos = [
            'Plantas' => $plantas
        ];
        $camiones = $this->GuiaEncabezados->Camiones->find('list')
            ->where(['Camiones.estado_id' => '1'])
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            });
        $camiones = $camiones->toArray();
        asort($camiones, SORT_STRING);
        $choferes = $this->GuiaEncabezados->Choferes->find('list')
            ->where(['Choferes.estado_id' => '1'])
            ->innerJoinWith('Areas', function($q) use ($areasIds) {
              return $q->where(['Areas.id IN' => $areasIds]);
            });
        $choferes = $choferes->toArray();
        asort($choferes, SORT_STRING);
        $movimientos = $this->GuiaEncabezados->Movimientos->find('list')->order(['nombre' => 'ASC']);

        $this->set(compact('guiaEncabezado', 'choferes', 'camiones', 'descargas', 'origenes', 'destinos', 'movimientos', 'status', 'recurso'));
        $this->set('_serialize', ['guiaEncabezado']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Guia Encabezado id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $guiaEncabezado = $this->GuiaEncabezados->get($id);
        if ($this->GuiaEncabezados->delete($guiaEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }

    public function lock($id = null) {
        $this->request->allowMethod(['post']);

        $guiaEncabezado = $this->GuiaEncabezados->get($id, ['contain' => []]);
        $guiaEncabezado->set('estado_id', '4');
        $this->GuiaEncabezados->touch($guiaEncabezado, 'Model.lock');
        if ($this->GuiaEncabezados->save($guiaEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('guiaEncabezado', 'status'));
    }

    public function unlock($id = null) {
        $this->request->allowMethod(['post']);

        $guiaEncabezado = $this->GuiaEncabezados->get($id);
        $guiaEncabezado->set('estado_id', '3');
        if ($this->GuiaEncabezados->save($guiaEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('guiaEncabezado', 'status'));
        $this->render('lock');
    }
}
