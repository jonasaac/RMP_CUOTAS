<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DescargasGuias Controller
 *
 * @property \App\Model\Table\DescargasGuiasTable $DescargasGuias
 */
class DescargasGuiasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('descargasGuias', $this->paginate($this->DescargasGuias));
        $this->set('_serialize', ['descargasGuias']);
    }

    /**
     * View method
     *
     * @param string|null $id Descargas Guia id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $descargasGuia = $this->DescargasGuias->get($id, [
            'contain' => []
        ]);
        $this->set('descargasGuia', $descargasGuia);
        $this->set('_serialize', ['descargasGuia']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $descargasGuia = $this->DescargasGuias->newEntity();
        if ($this->request->is('post')) {
            $descargasGuia = $this->DescargasGuias->patchEntity($descargasGuia, $this->request->data);
            if ($this->DescargasGuias->save($descargasGuia)) {
                $this->Flash->success(__('The descargas guia has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The descargas guia could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('descargasGuia'));
        $this->set('_serialize', ['descargasGuia']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Descargas Guia id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $descargasGuia = $this->DescargasGuias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $descargasGuia = $this->DescargasGuias->patchEntity($descargasGuia, $this->request->data);
            if ($this->DescargasGuias->save($descargasGuia)) {
                $this->Flash->success(__('The descargas guia has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The descargas guia could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('descargasGuia'));
        $this->set('_serialize', ['descargasGuia']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Descargas Guia id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $descargasGuia = $this->DescargasGuias->get($id);
        if ($this->DescargasGuias->delete($descargasGuia)) {
            $this->Flash->success(__('The descargas guia has been deleted.'));
        } else {
            $this->Flash->error(__('The descargas guia could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
