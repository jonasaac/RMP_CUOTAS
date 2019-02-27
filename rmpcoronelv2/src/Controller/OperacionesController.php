<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;

class OperacionesController extends AppController {
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
      if (in_array($this->request->action, ['index', 'comprobarNuevaOperacion', 'obtenerTotalPorEspecie'])) {
          return true;
      }

      $tmp_permiso = false;
      switch ($this->request->action) {
          case 'add':
          case 'carga_masiva':
          case 'nuevo_traspaso': $tmp_permiso = (bool) in_array('cuotas_operacion_add', $this->Auth->user('privilegios')); break;
          case 'edit': $tmp_permiso = (bool) in_array('cuotas_licencia_edit', $this->Auth->user('privilegios')); break;
          case 'delete': $tmp_permiso = (bool) in_array('cuotas_licencia_delete', $this->Auth->user('privilegios')); break;
          case 'upload_file': $tmp_permiso = (bool) (
                    in_array('cuotas_licencia_add', $this->Auth->user('privilegios')) ||
                    in_array('cuotas_licencia_edit', $this->Auth->user('privilegios'))
                ); break;
      }

      return $tmp_permiso || parent::isAuthorized($user);
  }

  public function index()
  {
    if (!$this->request->is(['ajax'])) {
        $operacionesYear = $this->Operaciones
        ->find('all')
        ->select('fecha_inicio');

        if ($operacionesYear->count() == 0) {
            $firstYear = date('Y');
            $lastYear = $firstYear;
        } else {
            $firstYear = $operacionesYear->cleanCopy()->order('fecha_inicio ASC')->first()->toArray()['fecha_inicio']->format('Y');
            $lastYear = $operacionesYear->order('fecha_inicio DESC')->first()->toArray()['fecha_inicio']->format('Y');
        }

        $years = range($lastYear, $firstYear);

        $especies = $this->Operaciones->find('all', [
          'contain' => ['Licencias', 'Licencias.Especies'],
          'group' => ['Especies.id', 'Especies.nombre']
        ])
        ->select(['Especies.id', 'Especies.nombre']);

        $this->set([
          'years' => $years,
          'especies' => $especies
        ]);
    }

    /**
     * Genera un listado en json para mostrar por datatable.
     * Genera un filtro que lista por pagina para mostar en datatable.
     */
    else if ($this->request->is(['ajax', 'post']) && !empty($this->request->query('year'))) {

        // Se determina el orden que deben tener los datos
        $orderColumnId = $this->request->data('order.0.column');
        $orderColumnName = $this->request->data('columns.'.$orderColumnId.'.name');

        // Datos seleccionados
        $startResponse = $this->request->data('start')?:0;
        // se asigna 100 al nro de resultados por defecto
        $lengthResponse = $this->request->data('length')?:10;

        $operaciones = $this->Operaciones->find('all')
        ->contain([
            'Licencias' => function ($q) {
                return $q->select(['id', 'especie_id', 'fecha_promulgacion', 'codigo_resolucion', 'tipo_licencia_id']);
            },
            'Licencias.Especies',
            'MacroZonas',
            'TipoOperaciones',
            'Auxiliares' => function ($q) {
                return $q->select(['id', 'rut', 'verificador', 'nombre', 'apellido_paterno', 'apellido_materno', 'nombre_razon_social']);
            }
        ]);

        if ($this->request->query('year')) {
            $operaciones = $operaciones
            ->where([
                'YEAR(fecha_inicio)' => $this->request->query('year')
            ]);
        }

        if ($this->request->query('especie') && $this->request->query('especie') != 'undefined') {
            $operaciones = $operaciones
            ->where([
                'Licencias.especie_id' => $this->request->query('especie')
            ]);
        }

        // Si se pide que ordene la tabla
        if ($orderColumnId) {
            $orderColumns = [];
            foreach ($this->request->data('order') as $order) {
                $columnName = $this->request->data("columns.{$order['column']}.name");
                if($columnName == "sort") continue;
                $orderColumns[$columnName] = $order['dir'];
            }

            $operaciones->order( $orderColumns );
        }

        $totalData = $operaciones->count();
        // Si se realiza una busqueda
        $searchString = $this->request->data('search.value');
        if ( !empty($searchString) ) {
            $array_search = explode(' ', $searchString);

            $operaciones_array = [];
            foreach ($array_search as $search) {
                if (empty($search)) {
                    continue;
                }
                $tmp_operaciones = $operaciones->cleanCopy();
                $tmp_operaciones->where([
                    'OR' => [
                        'CAST(Operaciones.id AS VARCHAR) LIKE' => "%{$search}%",
                        //especies
                        //licencia
                        //fecha_promulgacion
                        'dbo.ConvertirFecha(Operaciones.fecha_promulgacion) LIKE' => "%{$search}%",
                        //fecha_inicio
                        'dbo.ConvertirFecha(Operaciones.fecha_inicio) LIKE' => "%{$search}%",
                        //fecha_termino
                        'dbo.ConvertirFecha(Operaciones.fecha_termino) LIKE' => "%{$search}%",
                        'MacroZonas.nombre LIKE' => "%{$search}%",
                        'CAST(Operaciones.cantidad AS VARCHAR) LIKE' => "%{$search}%",
                        'TipoOperaciones.nombre LIKE' => "%{$search}%",
                        'Operaciones.resolucion LIKE' => "%{$search}%"
                    ]
                ]);
                $tmp_operaciones_array = $tmp_operaciones->toArray();

                if (empty($operaciones_array)) {
                    $operaciones_array = $tmp_operaciones_array;
                } else {
                    $operaciones_array = array_uintersect($tmp_operaciones_array, $mareas_array, "comparacion_ids");
                }
            }
            $totalfiltered = count($operaciones_array);
            $operaciones_array = array_slice(
            $operaciones_array,
            $startResponse,
            $lengthResponse);
        } else {
            $totalfiltered = $totalData;
            $operaciones = $operaciones->offset($startResponse)->limit($lengthResponse);
            $operaciones_array = $operaciones->toArray();
        }



        $this->set([
            'operaciones' => $operaciones_array,
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalfiltered,
            'draw' => $this->request->data('draw'),
            '_serialize' => [
                'operaciones',
                'recordsTotal',
                'recordsFiltered',
                'draw'
            ]
        ]);
    } else {
        throw new NotFoundException('Página no encontrada.');
    }
  }

  public function carga_masiva()
  { }

  public function generarExcel($year = NULL)
  {
      require_once(ROOT . DS . 'vendor' . DS  . 'phpoffice' . DS . 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel.php');
      $objPHPExcel = new \PHPExcel();

      $operaciones = $this->Operaciones->find('all')
          ->contain([
              'Licencias.Especies',
              'Licencias',
              'MacroZonas',
              'TipoOperaciones',
              'Auxiliares'
          ])
          ->where(['YEAR(Operaciones.fecha_operacion)' => $year]);

      if ($this->request->query('especie')) {
          $operaciones = $operaciones->where([
              'Especies.id' => $this->request->query('especie')
          ]);
      }

      $year = $year;

      $this->set(compact(
          'objPHPExcel',
          'operaciones',
          'year'
      ));
      $this->render('excel');
  }

  public function add()
  {
      $status = 'success';
      $operacion = $this->Operaciones->newEntity();
      if ($this->request->is('post')) {
        $operacion = $this->Operaciones->patchEntity($operacion, $this->request->data);

        // Si se carga un archivo adjunto
        if (!empty($this->request->data['adjunto_file'])) {
            $adjunto = $this->request->data['adjunto_file'];
            $display_name = $operacion->fecha_promulgacion->format('Ymd').'_'.$operacion->licencia_id;
            $file_name = 'operacion_'.$display_name.'.pdf';
            $operacion->set('adjunto', $file_name);
        }

        $operacion->set('fecha_operacion', new \DateTime());
        $operacion->set('estado_id', '1');  // ACTIVO
        $operacion->set('usuario_uid', $this->Auth->user('uid'));
        if ($this->Operaciones->save($operacion)) {
            if (!empty($this->request->data['adjunto_file'])) {
                if (move_uploaded_file(
                  $adjunto['tmp_name'],
                  Configure::read('file_upload_folder').$operacion->adjunto)) {
                  $file_status = 'success';
                } else {
                  $file_status = 'error';
                }
            }
            $status = 'success';
            $operacion = $this->Operaciones->get($operacion->id, [
              'contain' => [
                  'Licencias',
                  'Licencias.Especies',
                  'MacroZonas',
                  'TipoOperaciones'
              ]
            ]);
        } else {
            $status = 'error';
        }
      }

      $this->set([
          'operacion' => $operacion,
          'status' => $status,
          'errors' => $operacion->errors(),
          '_serialize' => ['operacion', 'status', 'errors']
      ]);
  }

  /**
   * Formulario que permite subir un archivo adjunto a las operaciones
   */
  public function upload_file($id = NULL)
  {
    $status = 'success';
    $operacion = $this->Operaciones->get($id);
    if ($this->request->is('post')) {
      $operacion = $this->Operaciones->patchEntity($operacion, $this->request->data);
      $adjunto = $this->request->data['adjunto_file'];
      $display_name = $operacion->fecha_promulgacion->format('Ymd').'_'.$operacion->licencia_id;
      $file_name = 'operacion_'.$display_name.'.pdf';
      $operacion->set('adjunto', $file_name);

      if ($this->Operaciones->save($operacion)) {
        if (move_uploaded_file(
          $adjunto['tmp_name'],
          Configure::read('file_upload_folder').$operacion->adjunto)) {
          $file_status = 'success';
        } else {
          $file_status = 'error';
        }
        $status = 'success';
      } else {
        $status = 'error';
      }
    }

    $this->set([
      'operacion' => $operacion,
      'status' => $status,
      'errors' => $operacion->errors(),
      '_serialize' => ['operacion', 'status', 'errors']
    ]);
  }

  public function nuevo_traspaso()
  {
    $status = 'success';
    $operaciones = [];
    $errors = [];

    if($this->request->is(['post'])) {
      $operacion = $this->Operaciones->newEntity();
      $operaciones[] = $this->Operaciones->patchEntity($operacion, $this->request->data['operaciones']['0']);
      $operaciones[0]->set('fecha_operacion', new \DateTime());
      $operaciones[0]->set('unidad_id', 1); // TONELADAS
      $operaciones[0]->set('resolucion', $this->request->data['resolucion']);
      $operaciones[0]->set('auxiliar_id', $this->request->data['auxiliar_id']);
      $operaciones[0]->set('cantidad', $this->request->data['cantidad']);
      $operaciones[0]->set('observaciones', $this->request->data['observaciones']);
      $operaciones[0]->set('estado_id', '1');  // ACTIVO
      $operaciones[0]->set('usuario_uid', $this->Auth->user('uid'));

      $operaciones[] = $this->Operaciones->patchEntity($operacion, $this->request->data['operaciones']['1']);
      $operaciones[1]->set('fecha_operacion', new \DateTime());
      $operaciones[1]->set('unidad_id', 1); // TONELADAS
      $operaciones[1]->set('resolucion', $this->request->data['resolucion']);
      $operaciones[1]->set('auxiliar_id', $this->request->data['auxiliar_id']);
      $operaciones[1]->set('cantidad', $this->request->data['cantidad']);
      $operaciones[1]->set('observaciones', $this->request->data['observaciones']);
      $operaciones[1]->set('estado_id', '1');  // ACTIVO
      $operaciones[1]->set('usuario_uid', $this->Auth->user('uid'));


      if (!empty($this->request->data['adjunto_file'])) {
        $adjunto = $this->request->data['adjunto_file'];
        $display_name0 = $operaciones[0]->fecha_promulgacion->format('Ymd').'_'.$operaciones[0]->licencia_id;
        $file_name0 = 'operacion_'.$display_name0.'.pdf';
        $operaciones[0]->set('adjunto', $file_name0);
        $display_name1 = $operaciones[1]->fecha_promulgacion->format('Ymd').'_'.$operaciones[1]->licencia_id;
        $file_name1 = 'operacion_'.$display_name1.'.pdf';
        $operaciones[1]->set('adjunto', $file_name1);
      }

      if ($this->Operaciones->saveMany($operaciones)) {
        if (!empty($this->request->data['adjunto_file'])) {
          if (move_uploaded_file(
            $adjunto['tmp_name'],
            Configure::read('file_upload_folder').$operaciones[0]->adjunto) &&
            move_uploaded_file(
              $adjunto['tmp_name'],
              Configure::read('file_upload_folder').$operaciones[1]->adjunto)) {
            $file_status = 'success';
          } else {
            $file_status = 'error';
          }
        }
        $status = 'success';
      } else {
        $status = 'error';
        $errors = [$operaciones[0]->errors(), $operaciones[1]->errors()];
      }
    }

    $this->set([
      'operaciones' => $operaciones,
      'status' => $status,
      'errors' => $errors,
      '_serialize' => ['operaciones', 'status', 'errors']
    ]);
  }

  public function edit($id = NULL)
  {
      $status = 'success';
      $operacion = $this->Operaciones->get($id);
      if ($this->request->is('post')) {
        $operacion = $this->Operaciones->patchEntity($operacion, $this->request->data);
        $operacion->set('usuario_uid', $this->Auth->user('uid'));
        if ($this->Operaciones->save($operacion)) {
            $status = 'success';
            $operacion = $this->Operaciones->get($operacion->id, [
              'contain' => [
                'Licencias',
                'MacroZonas',
                'TipoOperaciones',
                'Licencias.Especies',
                'Auxiliares']
            ]);
        } else {
            $status = 'error';
        }
      }

      $this->set([
          'operacion' => $operacion,
          'status' => $status,
          'errors' => $operacion->errors(),
          '_serialize' => ['operacion', 'status', 'errors']
      ]);
  }

  public function delete($id = null)
  {
      $this->request->allowMethod(['post', 'delete']);

      $operacion = $this->Operaciones->get($id);
      if ($this->Operaciones->delete($operacion)) {
          $status = 'success';
      } else {
          $status = 'error';
      }

      $this->set([
          'status' => $status,
          '_serialize' => ['status']
      ]);
  }

  /*** Funciones API ***/
  public function obtenerTotalPorEspecie()
  {
    $operaciones = $this->Operaciones->find('all')
      ->contain(['MacroZonas', 'Licencias', 'TipoOperaciones']);

    /** Definicion de los parametros de la consulta **/
    $obtener_por_macro_zona = False;
    if ($this->request->query('macro_zonas')) {
      $obtener_por_macro_zona = True;
    }

    $especie_id = null;
    if ($this->request->query('especie')) {
      $especie_id = $this->request->query('especie');
    }
    /** FIN Definicion de los parametros de la consulta **/

    if (!empty($especie_id)) {
      $operaciones = $operaciones->where([
        'Licencias.especie_id' => $especie_id,
      ]);
    }

    //$operaciones = $operaciones->distinct();

    $operaciones = $operaciones->reduce(function ($final, $operacion) use ($obtener_por_macro_zona) {
      if ($obtener_por_macro_zona) {
        $final[$operacion->macro_zona_id]['macro_zona'] = $operacion->macro_zona;
        if (!isset($final[$operacion->macro_zona_id]['total'])) {
          $final[$operacion->macro_zona_id]['total'] = 0;
        } else {
          $final[$operacion->macro_zona_id]['total'] += $operacion->cantidad;
        }
        $final[$operacion->macro_zona_id]['operaciones'][] = $operacion;
        unset($operacion['macro_zona']);
        unset($operacion['licencia']);
      } else {
        $final[] = $operacion;
      }
      return $final;
    }, []);

    $this->set([
      'operaciones' => $operaciones,
      '_serialize' => ['operaciones']
    ]);
  }

  public function comprobarNuevaOperacion()
  {
      $operacion = (object) array();
      if ($this->request->query('nombreLicencia')) {
          $values = explode('-', $this->request->query('nombreLicencia'));
          $tmp_licencia = TableRegistry::get('Licencias')->find('all')
            ->contain(['Especies'])
            ->where([
                'Licencias.codigo_resolucion' => $values[1],
                'YEAR(Licencias.fecha_promulgacion)' => $values[0],
                'Especies.nombre' => $this->request->query('nombreEspecie')
            ]);
          if ($tmp_licencia->count() > 0) {
              $operacion->licencia = $tmp_licencia->first();
          } else {
              $operacion->licencia = null;
          }
      }
      if ($this->request->query('nombreMacroZona')) {
          $tmp_macro_zona = TableRegistry::get('MacroZonas')->find('all')
            ->where([
                'Macrozonas.nombre' => $this->request->query('nombreMacroZona')
            ]);

          if ($tmp_macro_zona->count() > 0) {
            $operacion->macro_zona = $tmp_macro_zona->first();
          } else {
            $operacion->macro_zona = null;
          }

      }
      if ($this->request->query('nombreTipoOperacion')) {
          $tmp_tipo_operacion = TableRegistry::get('TipoOperaciones')->find('all')
            ->where([
                'TipoOperaciones.nombre' => $this->request->query('nombreTipoOperacion')
            ]);

          if ($tmp_tipo_operacion->count() > 0) {
            $operacion->tipo_operacion = $tmp_tipo_operacion->first();
        } else {
            $operacion->tipo_operacion = null;
        }
      }
      if ($this->request->query('rutAuxiliar')) {
          $values = explode('-', $this->request->query('rutAuxiliar'));
          $rut = str_replace('.', '', $values[0]);
          $verificador = $values[1];
          $tmp_auxiliar = TableRegistry::get('Auxiliares')->find('all')
            ->where([
                'Auxiliares.rut' => $rut,
                'Auxiliares.verificador' => $verificador
            ]);

          if ($tmp_auxiliar->count() > 0) {
            $operacion->auxiliar = $tmp_auxiliar->first();
        } else {
            $operacion->auxiliar = null;
        }
      }
      $this->set([
          'operacion' => $operacion,
          '_serialize' => ['operacion']
      ]);
  }
}
?>
