<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Calibres Controller
 *
 * @property \App\Model\Table\CalibresTable $Calibres
 */
class CalibresController extends AppController
{

  /**
   * Metodo utilizado para verificar el nivel de autorizacion de un usuario
   *
   * @param int|null $user uid de un Usuario a consultar
   * @return bool que indica si el usuario a sido autorizado (true) o no (false)
   */
  public function isAuthorized($user = null)
  {
      if (in_array($this->request->action, ['index', 'listar']))
          return true;

      // Permisos por acción
      $tmp_permiso = false;
      switch ($this->request->action) {
          case 'add': $tmp_permiso = (bool)in_array('admin_calibre_add', $this->Auth->user('privilegios')); break;
          case 'edit': $tmp_permiso = (bool)in_array('admin_calibre_edit', $this->Auth->user('privilegios')); break;
          case 'delete': $tmp_permiso = (bool)in_array('admin_calibre_delete', $this->Auth->user('privilegios')); break;
      }
      return $tmp_permiso || parent::isAuthorized($user);
  }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

      /**
       * Metodo utilizado para listar los calibres, que luego serán mostradas
       * en las datatables
       *
       * @param string|null $estado nombre del estado de los calibres a consultar
       * @return void
       */
      public function listar($estado = 'ACTIVO')
      {
          $calibres = $this->Calibres->find('all')
              ->contain(['Estados'])
              ->where(['Estados.nombre' => $estado]);

          $this->set([
              'calibres' => $calibres,
              '_serialize' => ['calibres']
          ]);
      }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $calibre = $this->Calibres->newEntity();
        $status = 'success';
        if ($this->request->is('post')) {
            $calibre = $this->Calibres->patchEntity($calibre, $this->request->data);
            $calibre->set('estado_id', 1);
            if ($this->Calibres->save($calibre)) {
              $status = 'success';
            } else {
              $status = 'error';
            }
        }
        $this->set(compact('calibre', 'status'));
        $this->set('_serialize', ['calibre']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Calibre id.
     * @return void
     */
    public function edit($id = null)
    {
        $calibre = $this->Calibres->get($id, [
            'contain' => []
        ]);
        $status = 'success';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $calibre = $this->Calibres->patchEntity($calibre, $this->request->data);
            if ($this->Calibres->save($calibre)) {
        $status = 'success';
            } else {
        $status = 'error';
            }
        }
        $estados = $this->Calibres->Estados->find('list');
        $this->set(compact('calibre', 'status', 'estados'));
        $this->set('_serialize', ['calibre']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Calibre id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $calibre = $this->Calibres->get($id);
        if ($this->Calibres->delete($calibre)) {
          $status = 'success';
        } else {
          $status = 'error';
        }
        $this->set(compact('status'));
    }
}
