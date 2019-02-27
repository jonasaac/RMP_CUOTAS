<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Recepciones Controller
 *
 * @property \App\Model\Table\RecepcionesTable $Recepciones
 */
class RecepcionesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('recepciones', $this->paginate($this->Recepciones));
        $this->set('_serialize', ['recepciones']);
    }

    /**
     * View method
     *
     * @param string|null $id Recepcione id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recepcione = $this->Recepciones->get($id, [
            'contain' => []
        ]);
        $this->set('recepcione', $recepcione);
        $this->set('_serialize', ['recepcione']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recepcione = $this->Recepciones->newEntity();
        if ($this->request->is('post')) {
            $recepcione = $this->Recepciones->patchEntity($recepcione, $this->request->data);
            if ($this->Recepciones->save($recepcione)) {
                $this->Flash->success(__('The recepcione has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The recepcione could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('recepcione'));
        $this->set('_serialize', ['recepcione']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Recepcione id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recepcione = $this->Recepciones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recepcione = $this->Recepciones->patchEntity($recepcione, $this->request->data);
            if ($this->Recepciones->save($recepcione)) {
                $this->Flash->success(__('The recepcione has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The recepcione could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('recepcione'));
        $this->set('_serialize', ['recepcione']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recepcione id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recepcione = $this->Recepciones->get($id);
        if ($this->Recepciones->delete($recepcione)) {
            $this->Flash->success(__('The recepcione has been deleted.'));
        } else {
            $this->Flash->error(__('The recepcione could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
