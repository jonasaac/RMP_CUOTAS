<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tratamientos Controller
 *
 * @property \App\Model\Table\TratamientosTable $Tratamientos
 */
class TratamientosController extends AppController
{
  public function isAuthorized($user = null)
  {
      if (in_array($this->request->action, ['index', 'listar'])) {
          return true;
      }

      $tmp_permiso = false;
      switch ($this->request->action) {
          case 'add': $tmp_permiso = (bool) in_array('admin_tratamiento_add', $this->Auth->user('privilegios')); break;
          case 'edit': $tmp_permiso = (bool) in_array('admin_tratamiento_edit', $this->Auth->user('privilegios')); break;
          case 'delete': $tmp_permiso = (bool) in_array('admin_tratamiento_delete', $this->Auth->user('privilegios')); break;
      }
      return $tmp_permiso || parent::isAuthorized($user);
  }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Estados']
        ];
        $this->set('tratamientos', $this->paginate($this->Tratamientos));
        $this->set('_serialize', ['tratamientos']);
    }

    public function listar($estado = 'ACTIVO')
    {
        $tratamientos = $this->Tratamientos->find('all', [
            'contain' => ['Estados']
        ])->where(['Estados.nombre' => $estado]);

        $this->set([
            'tratamientos' => $tratamientos,
            '_serialize' => ['tratamientos'],
        ]);
    }
    /**
     * View method
     *
     * @param string|null $id Tratamiento id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tratamiento = $this->Tratamientos->get($id, [
            'contain' => ['Estados', 'ControlesCalidad']
        ]);
        $this->set('tratamiento', $tratamiento);
        $this->set('_serialize', ['tratamiento']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $status = 'success';
        $tratamiento = $this->Tratamientos->newEntity();
        if ($this->request->is('post')) {
            $tratamiento = $this->Tratamientos->patchEntity($tratamiento, $this->request->data);
            if ($this->Tratamientos->save($tratamiento)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->Tratamientos->Estados->find('list', ['limit' => 200]);
        $this->set(compact('tratamiento', 'estados', 'status'));
        $this->set('_serialize', ['tratamiento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tratamiento id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $tratamiento = $this->Tratamientos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tratamiento = $this->Tratamientos->patchEntity($tratamiento, $this->request->data);
            if ($this->Tratamientos->save($tratamiento)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->Tratamientos->Estados->find('list', ['limit' => 200]);
        $this->set(compact('tratamiento', 'estados', 'status'));
        $this->set('_serialize', ['tratamiento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tratamiento id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tratamiento = $this->Tratamientos->get($id);
        if ($this->Tratamientos->delete($tratamiento)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('status'));
    }
}
