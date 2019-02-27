<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class DecretosController extends AppController {
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
      if (in_array($this->request->action, ['index'])) {
          return true;
      }

      $tmp_permiso = false;
      switch ($this->request->action) {
          case 'add': $tmp_permiso = (bool) in_array('cuotas_decreto_add', $this->Auth->user('privilegios')); break;
          case 'edit': $tmp_permiso = (bool) in_array('cuotas_decreto_edit', $this->Auth->user('privilegios')); break;
          case 'delete': $tmp_permiso = (bool) in_array('cuotas_decreto_delete', $this->Auth->user('privilegios')); break;
      }

      return $tmp_permiso || parent::isAuthorized($user);
  }

  public function index()
  {
    if ($this->request->is(['get'])) {
        $decretosYear = $this->Decretos
        ->find('all')
        ->select('fecha_promulgacion')
        ->order(['fecha_promulgacion ASC']);

        if ($decretosYear->count() == 0) {
            $firstYear = date('Y');
        } else {
            $firstYear = $decretosYear->first()->toArray()['fecha_promulgacion']->format('Y');
        }

        $years = range(date('Y'), $firstYear);

        $this->set(['years' => $years]);
    }

    if ($this->request->is(['ajax', 'get'])) {
        $decretos = $this->Decretos->find('all');

        if ($this->request->query('estado')) {
            $decretos = $decretos
            ->contain(['Estados'])
            ->where([
                'Estados.nombre' => strtoupper($this->request->query('estado'))
            ]);
        }

        if ($this->request->query('year')) {
            $decretos = $decretos
            ->where([
                'OR' => [
                  'YEAR(fecha_promulgacion)' => $this->request->query('year'),
                  'YEAR(fecha_inicio_vigencia)' => $this->request->query('year'),
                  ]
            ]);
        }

        if ($this->request->query('especie') && $this->request->query('especie') != 'undefined') {
            $decretos = $decretos
            ->where([
                'especie_id' => $this->request->query('especie')
            ]);
        }

        if ($this->request->query('reload')) {
            $this->set([
                'data' => $decretos,
                '_serialize' => ['data']
            ]);
        } else {
            $this->set([
                'decretos' => $decretos,
                '_serialize' => ['decretos']
            ]);
        }
    }
  }

  public function add()
  {
    $status = 'success';
    $file_status = 'pending';
    $decreto = $this->Decretos->newEntity();
    if ($this->request->is('post')) {
        $decreto = $this->Decretos->patchEntity($decreto, $this->request->data, ['associated' => ['Periodos.Unidades']]);

        // Si se carga un archivo adjunto
        if (!empty($this->request->data['adjunto_file'])) {
          $adjunto = $this->request->data['adjunto_file'];
          $display_name = $decreto->fecha_promulgacion->format('Y').'_'.$decreto->codigo_resolucion;
          $file_name = 'decreto_'.$display_name.'.pdf';
          $decreto->set('adjunto', $file_name);
        }
        $decreto->set('estado_id', '1');  // ACTIVO
        $decreto->set('usuario_uid', $this->Auth->user('uid'));
        if ($this->Decretos->save($decreto)) {
          // Si la entidad se guarda exitosamente
          // se guarda el archivo en el servidor
          if (!empty($this->request->data['adjunto_file'])) {
            if (move_uploaded_file(
              $adjunto['tmp_name'],
              Configure::read('file_upload_folder').$decreto->adjunto)) {
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

    $this->set([
        'decreto' => $decreto,
        'status' => $status,
        'file_status' => $file_status,
        'errors' => $decreto->errors(),
        '_serialize' => ['decreto', 'status', 'errors']
    ]);
  }

  public function edit($id = Null)
  {
    $status = 'success';
    $file_status = 'pending';
    $decreto = $this->Decretos->get($id, [
        'contain' => [
          'Especies', 'Periodos',
          'Periodos.MacroZonas', 'Periodos.Unidades']
    ]);
    if ($this->request->is('post')) {
        $decreto = $this->Decretos->patchEntity($decreto, $this->request->data, ['associated' => ['Periodos.Unidades']]);
        $decreto->set('usuario_uid', $this->Auth->user('uid'));

        // Si se carga un archivo adjunto
        if (!empty($this->request->data['adjunto_file'])) {
          $prev_adjunto = $decreto->adjunto;
          $adjunto = $this->request->data['adjunto_file'];
          $display_name = $decreto->fecha_promulgacion->format('Y').'_'.$decreto->codigo_resolucion;
          $file_name = 'licencia_'.$display_name.'.pdf';
          $decreto->set('adjunto', $file_name);
        }
        if ($this->Decretos->save($decreto)) {
            if (count($decreto->periodos) > 0) {
                $periodosIds = [];
                foreach($decreto->periodos as $n) {
                    $periodosIds[] = $n->id;
                }

                $query = $this->Decretos
                ->Periodos->find('all')
                ->where([
                    'decreto_id' => $decreto->id,
                    'id NOT IN' => $periodosIds
                ])
                ->toArray();
                foreach ($query as $deletePeriodo) {
                    $this->Decretos->Periodos->delete($deletePeriodo);
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
                  Configure::read('file_upload_folder').$decreto->adjunto)) {
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

    $this->set([
        'decreto' => $decreto,
        'status' => $status,
        'file_status' => $file_status,
        'errors' => $decreto->errors(),
        '_serialize' => ['decreto', 'status', 'errors']
    ]);
  }

  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);

    $decreto = $this->Decretos->get($id);
    if ($this->Decretos->delete($decreto)) {
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
