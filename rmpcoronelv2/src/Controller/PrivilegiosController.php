<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Privilegios Controller
 *
 * @property \App\Model\Table\PrivilegiosTable $Privilegios
 */
class PrivilegiosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('privilegios', $this->paginate($this->Privilegios));
        $this->set('_serialize', ['privilegios']);
    }

    /**
     * View method
     *
     * @param string|null $id Privilegio id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $privilegio = $this->Privilegios->get($id, [
            'contain' => ['Grupos']
        ]);
        $this->set('privilegio', $privilegio);
        $this->set('_serialize', ['privilegio']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $privilegio = $this->Privilegios->newEntity();
        if ($this->request->is('post')) {
            $privilegio = $this->Privilegios->patchEntity($privilegio, $this->request->data);
            if ($this->Privilegios->save($privilegio)) {
                $this->Flash->success(__('The privilegio has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The privilegio could not be saved. Please, try again.'));
            }
        }
        $grupos = $this->Privilegios->Grupos->find('list', ['limit' => 200]);
        $this->set(compact('privilegio', 'grupos'));
        $this->set('_serialize', ['privilegio']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Privilegio id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $privilegio = $this->Privilegios->get($id, [
            'contain' => ['Grupos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $privilegio = $this->Privilegios->patchEntity($privilegio, $this->request->data);
            if ($this->Privilegios->save($privilegio)) {
                $this->Flash->success(__('The privilegio has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The privilegio could not be saved. Please, try again.'));
            }
        }
        $grupos = $this->Privilegios->Grupos->find('list', ['limit' => 200]);
        $this->set(compact('privilegio', 'grupos'));
        $this->set('_serialize', ['privilegio']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Privilegio id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $privilegio = $this->Privilegios->get($id);
        if ($this->Privilegios->delete($privilegio)) {
            $this->Flash->success(__('The privilegio has been deleted.'));
        } else {
            $this->Flash->error(__('The privilegio could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
