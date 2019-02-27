<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GruposUsuarios Controller
 *
 * @property \App\Model\Table\GruposUsuariosTable $GruposUsuarios
 */
class GruposUsuariosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('gruposUsuarios', $this->paginate($this->GruposUsuarios));
        $this->set('_serialize', ['gruposUsuarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Grupos Usuario id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gruposUsuario = $this->GruposUsuarios->get($id, [
            'contain' => []
        ]);
        $this->set('gruposUsuario', $gruposUsuario);
        $this->set('_serialize', ['gruposUsuario']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gruposUsuario = $this->GruposUsuarios->newEntity();
        if ($this->request->is('post')) {
            $gruposUsuario = $this->GruposUsuarios->patchEntity($gruposUsuario, $this->request->data);
            if ($this->GruposUsuarios->save($gruposUsuario)) {
                $this->Flash->success(__('The grupos usuario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The grupos usuario could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('gruposUsuario'));
        $this->set('_serialize', ['gruposUsuario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Grupos Usuario id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gruposUsuario = $this->GruposUsuarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gruposUsuario = $this->GruposUsuarios->patchEntity($gruposUsuario, $this->request->data);
            if ($this->GruposUsuarios->save($gruposUsuario)) {
                $this->Flash->success(__('The grupos usuario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The grupos usuario could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('gruposUsuario'));
        $this->set('_serialize', ['gruposUsuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupos Usuario id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gruposUsuario = $this->GruposUsuarios->get($id);
        if ($this->GruposUsuarios->delete($gruposUsuario)) {
            $this->Flash->success(__('The grupos usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The grupos usuario could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
