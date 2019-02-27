<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Areas Controller
 *
 * @property \App\Model\Table\AreasTable $Areas
 */
class AreasController extends AppController
{

  /**
   * Metodo utilizado para verificar si un usuario está autorizado a acceder
   * a un modulo o no
   *
   * @param string|null $user con el nombre del usuario a consultar
   * @return bool true si está autorizado false en otro caso.
   **/
  public function isAuthorized($user = null) {
    // Cualquier usuario está autorizado para acceder al logout del sistema
    // Privilegios por acción
    $tmp_permiso = false;
    switch ($this->request->action) {
        case 'index':
        case 'listar':
        $search = 'admin_usuario';
        $matches = array_filter($this->Auth->user('privilegios'), function ($var) use ($search) {
          return preg_match("/$search/i", $var);
        });
        $tmp_permiso = (bool)$matches;
        break;
        case 'add': $tmp_permiso = (bool)in_array('admin_usuario_add', $this->Auth->user('privilegios')); break;
        case 'edit': $tmp_permiso = (bool)in_array('admin_usuario_edit', $this->Auth->user('privilegios')); break;
        case 'delete': $tmp_permiso = (bool)in_array('admin_usuario_delete', $this->Auth->user('privilegios')); break;
    }

    return $tmp_permiso || parent::isAuthorized($user);
  }

    /**
     * Metodo usado para cargar la vista principal de las areas
     *
     * @return void
     */
    public function index()
    {}

    /**
     * Metodo utilizado para listar las areas del sistema
     *
     * @param string|'ACTIVO' $estado nombre del Estado por el cual se consulta
     * @return void
     */
    public function listar($estado = 'ACTIVO')
    {
      $areas = $this->Areas->find('all')
          ->contain(['Estados', 'Recursos'])
          ->where(['Estados.nombre' => $estado]);

      $this->set(compact(['areas']));
      $this->set('_serialize', ['areas']);
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add()
    {
        $status = 'success';
        $area = $this->Areas->newEntity();
        if ($this->request->is('post')) {
            $area = $this->Areas->patchEntity($area, $this->request->data);
            if ($this->Areas->save($area)) {
              $status = 'success';
            } else {
              $status = 'error';
            }
        }
        $estados = $this->Areas->Estados->find('list', ['limit' => 200]);
        $recursos = $this->Areas->Recursos->find('list', ['limit' => 200]);
        $this->set(compact('area', 'estados', 'recursos', 'status'));
        $this->set('_serialize', ['area']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return void
     */
    public function edit($id = null)
    {
      $status = 'success';
      $area = $this->Areas->get($id, [
          'contain' => ['Estados', 'Recursos']
      ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
          $area = $this->Areas->patchEntity($area, $this->request->data);
          if ($this->Areas->save($area)) {
            $status = 'success';
          } else {
            $status = 'error';
          }
      }
      $estados = $this->Areas->Estados->find('list', ['limit' => 200]);
      $recursos = $this->Areas->Recursos->find('list', ['limit' => 200]);
      $this->set(compact('area', 'estados', 'recursos', 'status'));
      $this->set('_serialize', ['area']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $area = $this->Areas->get($id);
        if ($this->Areas->delete($area)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
      $this->set(compact(['status']));
    }
}
