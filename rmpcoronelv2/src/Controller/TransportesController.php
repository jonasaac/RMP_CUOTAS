<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Transportes Controller
 *
 * @property \App\Model\Table\TransportesTable $Transportes
 */
class TransportesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('transportes', $this->paginate($this->Transportes));
        $this->set('_serialize', ['transportes']);
    }

    public function listar($estado = 'ACTIVO')
    {
        $transportes = $this->Transportes->find('all', [
            'contain' => ['Estados', 'Camiones']
        ])->where(['Estados.nombre' => $estado]);

        $this->set([
            'transportes' => $transportes,
            '_serialize' => ['trasportes'],
        ]);
    }
    /**
     * View method
     *
     * @param string|null $id Transporte id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transporte = $this->Transportes->get($id, [
            'contain' => ['Camiones']
        ]);
        $this->set('transporte', $transporte);
        $this->set('_serialize', ['transporte']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transporte = $this->Transportes->newEntity();
        $status = 'success';
        if ($this->request->is(['post', 'put'])) {
            $transporte = $this->Transportes->patchEntity($transporte, $this->request->data);
            if ($this->Transportes->save($transporte)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('transporte', 'status'));
        $this->set('_serialize', ['transporte']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transporte id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transporte = $this->Transportes->get($id, [
            'contain' => []
        ]);
        $status = 'success';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transporte = $this->Transportes->patchEntity($transporte, $this->request->data);
            if ($this->Transportes->save($transporte)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->Transportes->Estados->find('list');
        $this->set(compact('transporte', 'estados', 'status'));
        $this->set('_serialize', ['transporte']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transporte id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transporte = $this->Transportes->get($id);
        if ($this->Transportes->delete($transporte)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
