<?php
namespace App\Controller;
use App\Controller\AppController;

class TipoOperacionesController extends AppController {
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
          case 'add': $tmp_permiso = (bool) in_array('admin_tipoOperacion_add', $this->Auth->user('privilegios')); break;
          case 'edit': $tmp_permiso = (bool) in_array('admin_tipoOperacion_edit', $this->Auth->user('privilegios')); break;
          case 'delete': $tmp_permiso = (bool) in_array('admin_tipoOperacion_delete', $this->Auth->user('privilegios')); break;
      }

      return $tmp_permiso || parent::isAuthorized($user);
  }

  public function index()
  {
    $tipo_operaciones = $this->TipoOperaciones->find('all')
        ->order(['nombre' => 'ASC']);

        // Cuando se realiza una busqueda a traves de un Select2
        if ($this->request->query('q')) {
            $q = $this->request->query('q');
            $values = explode(' ', strtoupper($q));
            foreach ($values as $value) {
                $tipo_operaciones = $tipo_operaciones->where([
                    'OR' => [
                        'TipoOperaciones.nombre LIKE' => "%{$value}%",
                    ]
                ]);
            }
        }

    $this->set([
      'tipo_operaciones' => $tipo_operaciones,
      '_serialize' => ['tipo_operaciones'],
    ]);
  }

  public function add()
  {
    $status = 'success';
    $errors = Null;
    $tipo_operacion = $this->TipoOperaciones->newEntity();
    if ($this->request->is('post')) {
      $tipo_operacion = $this->TipoOperaciones->patchEntity($tipo_operacion, $this->request->data);
      if ($this->TipoOperaciones->save($tipo_operacion)) {
        $status = 'success';
      } else {
        $errors = $tipo_operacion->errors();
        $status = 'error';
      }
    }
    $this->set(compact('tipo_operacion', 'status', 'errors'));
    $this->set('_serialize', ['tipo_operacion', 'status', 'errors']);
  }

  public function edit($id = NULL)
  {
      $status = 'success';
      $errors = [];
      $tipoOperacion = $this->TipoOperaciones->get($id);
      if ($this->request->is(['patch', 'post', 'put'])) {
          $tipoOperacion = $this->TipoOperaciones->patchEntity($tipoOperacion, $this->request->data);
          if ($this->TipoOperaciones->save($tipoOperacion)) {
            $status = 'success';
          } else {
            $status = 'error';
            $errors = $tipoOperacion->errors();
          }
      }
      $this->set(compact('tipoOperacion', 'status', 'errors'));
      $this->set('_serialize', ['tipoOperacion', 'status', 'errors']);
  }

  public function delete($id = NULL)
  {
      $status = 'success';
      $this->request->allowMethod(['post', 'delete']);
      $tipoOperacion = $this->TipoOperaciones->get($id);
      if ($this->TipoOperaciones->delete($tipoOperacion)) {
        $status = 'success';
      } else {
        $status = 'error';
      }
      $this->set(compact('status'));
      $this->set('_serialize', ['status']);
  }

  // API
  public function obtenerPorNombre()
  {
    if ($this->request->query('nombre')) {
      $tipo_operacion = $this->TipoOperaciones->find('all')
      ->where([
        'nombre' => $this->request->query('nombre')
      ])
      ->first();
    } else {
      $tipo_operacion = null;
    }

    $this->set([
      'tipo_operacion' => $tipo_operacion,
      '_serialize' => ['tipo_operacion']
    ]);
  }
}

?>
