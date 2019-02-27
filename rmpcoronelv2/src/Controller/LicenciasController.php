<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\i18n\Time;

class LicenciasController extends AppController {

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * Metodo utilizado para verificar el nivel de autorizacion de un usuario
     *
     * @param int|null $user uid de un Usuario a consultar
     * @return bool que indica si el usuario a sido autorizado (true) o no (false)
     */
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['index', 'obtenerPorNombre'])) {
            return true;
        }

        $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool) in_array('cuotas_licencia_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('cuotas_licencia_edit', $this->Auth->user('privilegios')); break;
            case 'delete':
            case 'activate':
            case 'deactivate': $tmp_permiso = (bool) in_array('cuotas_licencia_delete', $this->Auth->user('privilegios')); break;
        }

        return $tmp_permiso || parent::isAuthorized($user);
    }

    public function index() {
        if ($this->request->is(['get'])) {
            $licenciasYear = $this->Licencias
            ->find('all')
            ->select('fecha_promulgacion');

            if ($licenciasYear->count() == 0) {
                $firstYear = date('Y');
                $lastYear = $firstYear;
            } else {
                $firstYear = $licenciasYear->cleanCopy()->order('fecha_promulgacion ASC')->first()->toArray()['fecha_promulgacion']->format('Y');
                $lastYear = $licenciasYear->order('fecha_promulgacion DESC')->first()->toArray()['fecha_promulgacion']->format('Y');
            }

            $years = range($lastYear, $firstYear);

            $this->set(['years' => $years]);
        }

        if ($this->request->is(['ajax', 'get'])) {
            $licencias = $this->Licencias->find('all');

            if ($this->request->query('estado')) {
                $licencias = $licencias
                ->contain(['Estados'])
                ->where([
                    'Estados.nombre' => strtoupper($this->request->query('estado'))
                ]);
            }

            if ($this->request->query('year')) {
                $licencias = $licencias
                ->where([
                    'YEAR(fecha_promulgacion) IN' => explode(',', $this->request->query('year'))
                ]);
            }

            if ($this->request->query('especie') && $this->request->query('especie') != 'undefined') {
                $licencias = $licencias
                ->where([
                    'especie_id' => $this->request->query('especie')
                ]);
            }

            if ($this->request->query('zona_pesca') && $this->request->query('zona_pesca') != 'undefined') {
              $zona_pesca_id = $this->request->query('zona_pesca');
              $licencias = $licencias
              ->innerJoinWith('MacroZonas.ZonasPesca', function($q) use ($zona_pesca_id) {
                return $q->where([
                           'ZonasPesca.id' => $zona_pesca_id
                         ]);
              });
            }

            // Cuando se realiza una busqueda a traves de un Select2
            if ($this->request->query('q')) {
                $q = $this->request->query('q');
                $values = explode(' ', strtoupper($q));
                $licencias = $licencias->contain(['TiposLicencia']);
                foreach ($values as $value) {
                    $licencias = $licencias->where([
                        'OR' => [
                            'CAST(YEAR(fecha_promulgacion) AS VARCHAR) LIKE' => "%{$value}%",
                            'Licencias.codigo_resolucion LIKE' => "%{$value}%",
                            'UPPER(TiposLicencia.nombre) LIKE' => "%{$value}%"
                        ]
                    ]);
                }
            }

            // Muestra la cantidad disponible
            $cantidadDisponible = false;
            if ($this->request->query('cantidad_disponible')) {
              $cantidadDisponible = true;
            }

            // Filtra y solo muestra las licencias con cantidad_disponible > 0
            $disponible = false;
            if ($this->request->query('disponible')) {
                $disponible = true;
            }

            $obtenerNombreEspecie = false;
            if ($this->request->query('nombre_especie')) {
              $licencias = $licencias
              ->contain(['Especies']);
              $obtenerNombreEspecie = true;
            }

            /// Agrupar licencias por especie
            $agruparPorEspecie = false;
            if ($this->request->query('agruparPorEspecie')) {
              $licencias = $licencias
                  ->contain(['Especies']);
              $agruparPorEspecie = true;
            }

            $reducer = function ($output, $value) use ($cantidadDisponible, $obtenerNombreEspecie, $agruparPorEspecie, $disponible) {
              if(!array_key_exists($value->id, $output)) {
                // Si la cantidad disponible es menor o igual a 0 no se muestra
                if ($disponible && $value->cantidad_disponible <= 0) {
                  return $output;
                }
                $value['vencido'] = $value->is_expired;
                if ($cantidadDisponible) {
                  $value['cantidad_disponible'] = $value->cantidad_disponible;
                }
                if ($obtenerNombreEspecie) {
                  $value['nombre_especie'] = $value->especie->nombre;
                }
                if ($agruparPorEspecie) {
                  $output[$value->especie->id]['nombre_especie'] = $value->especie->nombre;
                  $output[$value->especie->id]['licencias'][] = $value;
                } else {
                  $output[$value->id] = $value;
                }
              }
              return $output;
            };

            $licencias = $licencias->reduce($reducer, []);

            if ($this->request->query('reload')) {
                $this->set([
                    'data' => array_values($licencias),
                    '_serialize' => ['data']
                ]);
            } else {
                $this->set([
                    'licencias' => array_values($licencias),
                    '_serialize' => ['licencias']
                ]);
            }
        }
    }

    public function obtenerPorNombre()
    {
      if ($this->request->query('nombre')) {
        $values = explode('-', $this->request->query('nombre'));
        $year_licencia = $values[0];
        $codigo_resolucion_licencia = $values[1];
        $licencia = $this->Licencias->find('all')
            ->contain(['Especies'])
            ->where([
              'YEAR(fecha_promulgacion)' => $year_licencia,
              'codigo_resolucion' => $codigo_resolucion_licencia
            ])
            ->first();
      } else {
        $licencia = null;
      }

      $this->set([
        'licencia' => $licencia,
        '_serialize' => ['licencia']
      ]);
    }

    public function add()
    {
        $status = 'success';
        $file_status = 'pending';
        $licencia = $this->Licencias->newEntity();
        if ($this->request->is('post')) {
          if ($this->request->data['tipo_licencia_id'] == 3) {// PEP
              $this->request->data['unidades'] = [$this->request->data['unidades'][0]];
          }
          $licencia = $this->Licencias->patchEntity($licencia, $this->request->data);

          // Si se carga un archivo adjunto
          if (!empty($this->request->data['adjunto_file'])) {
            $adjunto = $this->request->data['adjunto_file'];
            $display_name = $licencia->fecha_promulgacion->format('Y').'_'.$licencia->codigo_resolucion;
            $file_name = 'licencia_'.$display_name.'.pdf';
            $licencia->set('adjunto', $file_name);
          }
          $licencia->set('estado_id', '1');  // ACTIVO
          $licencia->set('usuario_uid', $this->Auth->user('uid'));
          if ($this->Licencias->save($licencia)) {
            // Si la entidad se guarda exitosamente
            // se guarda el archivo en el servidor
            if (!empty($this->request->data['adjunto_file'])) {
              if (move_uploaded_file(
                $adjunto['tmp_name'],
                Configure::read('file_upload_folder').$licencia->adjunto)) {
                $file_status = 'success';
              } else {
                $file_status = 'error';
              }
            }
            $status = 'success';
          } else {
              $status = 'error';
          }
        }

        $monedas = $this->Licencias->UnidadesCosto->find('all');

        $this->set([
            'licencia' => $licencia,
            'status' => $status,
            'file_status' => $file_status,
            'monedas' => $monedas,
            'errors' => $licencia->errors(),
            '_serialize' => ['licencia', 'status', 'errors']
        ]);
    }

    public function edit($id = null)
    {
        $status = 'success';
        $file_status = 'pending';
        $licencia = $this->Licencias->get($id, [
            'contain' => [
                'TiposLicencia', 'ModificaLicencias',
                'Auxiliares', 'Especies', 'MacroZonas',
                'Unidades', 'Numeraciones', 'UnidadesCosto']
        ]);
        if ($this->request->is('post')) {
            if ($this->request->data['tipo_licencia_id'] == 3) {// PEP
                $this->request->data['unidades'] = [$this->request->data['unidades'][0]];
            }
            $licencia = $this->Licencias->patchEntity($licencia, $this->request->data);
            $licencia->set('usuario_uid', $this->Auth->user('uid'));

            // Si se carga un archivo adjunto
            if (!empty($this->request->data['adjunto_file'])) {
              $prev_adjunto = $licencia->adjunto;
              $adjunto = $this->request->data['adjunto_file'];
              $display_name = $licencia->fecha_promulgacion->format('Y').'_'.$licencia->codigo_resolucion;
              $file_name = 'licencia_'.$display_name.'.pdf';
              $licencia->set('adjunto', $file_name);
            }

            if ($this->Licencias->save($licencia)) {
                if (count($licencia->numeraciones) > 0) {
                    $numeracionesIds = [];
                    foreach($licencia->numeraciones as $n) {
                        $numeracionesIds[] = $n->id;
                    }

                    $query = $this->Licencias
                    ->Numeraciones->find('all')
                    ->where([
                        'licencia_id' => $licencia->id,
                        'id NOT IN' => $numeracionesIds
                    ])
                    ->toArray();
                    foreach ($query as $deleteNumeracion) {
                        $this->Licencias->Numeraciones->delete($deleteNumeracion);
                    }
                }

                // Si la entidad se guarda exitosamente
                // se elimina el anterior y
                // se guarda el nuevo archivo en el servidor
                if (!empty($this->request->data['adjunto_file'])) {
                  if ($prev_adjunto) {
                    unlink(Configure::read('file_upload_folder').$prev_adjunto);
                  }
                  if (move_uploaded_file(
                      $adjunto['tmp_name'],
                      Configure::read('file_upload_folder').$licencia->adjunto)) {
                    $file_status = 'success';
                  } else {
                    $file_status = 'error';
                  }
                }
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        if ($licencia->tipo_licencia_id == 4) { // RAE carga la nave
            $licencia['nave'] = $this->Licencias->get($id, [
                'contain' => ['Naves']
            ])->nave;
        }

        $monedas = $this->Licencias->UnidadesCosto->find('all');

        $this->set([
            'licencia' => $licencia,
            'status' => $status,
            'file_status' => $file_status,
            'errors' => $licencia->errors(),
            'monedas' => $monedas,
            '_serialize' => ['licencia', 'status', 'errors']
        ]);
    }

    public function activate($id = null)
    {
        $status = 'success';
        $licencia = $this->Licencias->get($id);
        if ($this->request->is('post')) {
            $licencia->set('usuario_uid', $this->Auth->user('uid'));
            $licencia->set('estado_id', 1);
            if ($this->Licencias->save($licencia)) {
                $status = 'success';
                $licencia['cantidad_disponible'] = $licencia->cantidad_disponible;
            } else {
                $status = 'error';
            }
        }
        $this->set([
            'licencia' => $licencia,
            'status' => $status,
            'errors' => $licencia->errors(),
            '_serialize' => ['licencia', 'status', 'errors']
        ]);
    }

    public function deactivate($id = null)
    {
        $status = 'success';
        $licencia = $this->Licencias->get($id);
        if ($this->request->is('post')) {
            $licencia->set('usuario_uid', $this->Auth->user('uid'));
            $licencia->set('estado_id', '2');
            if ($this->Licencias->save($licencia)) {
                $status = 'success';
                $licencia['cantidad_disponible'] = $licencia->cantidad_disponible;
            } else {
                $status = 'error';
            }
        }
        $this->set([
            'licencia' => $licencia,
            'status' => $status,
            'errors' => $licencia->errors(),
            '_serialize' => ['licencia', 'status', 'errors']
        ]);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $licencia = $this->Licencias->get($id);
        if ($this->Licencias->delete($licencia)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set([
            'status' => $status,
            '_serialize' => ['status']
        ]);
    }
}
?>
