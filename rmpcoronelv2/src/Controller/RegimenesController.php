<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Regimenes Controller
 *
 * @property \App\Model\Table\RegimenesTable $Regimenes
 */
class RegimenesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('regimenes', $this->paginate($this->Regimenes));
        $this->set('_serialize', ['regimenes']);
    }

    public function listar()
    {
        $regimenes = $this->Regimenes->find('all');
        $this->set(compact('regimenes'));
    }

    /**
     * View method
     *
     * @param string|null $id Regimene id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $regimen = $this->Regimenes->get($id, [
            'contain' => []
        ]);
        $this->set('regimen', $regimen);
        $this->set('_serialize', ['regimen']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $status = 'success';
        $regimen = $this->Regimenes->newEntity();
        if ($this->request->is('post')) {
            $regimen = $this->Regimenes->patchEntity($regimen, $this->request->data);
            if ($this->Regimenes->save($regimen)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('regimen', 'status'));
        $this->set('_serialize', ['regimen']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Regimene id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $regimen = $this->Regimenes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $regimen = $this->Regimenes->patchEntity($regimen, $this->request->data);
            if ($this->Regimenes->save($regimen)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('regimen', 'status'));
        $this->set('_serialize', ['regimen']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Regimene id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $regimene = $this->Regimenes->get($id);
        if ($this->Regimenes->delete($regimene)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
