<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Unidades Controller
 *
 * @property \App\Model\Table\UnidadesTable $Unidades
 */
class UnidadesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

    public function listar($estado = 'ACTIVO')
    {
        $unidades = $this->Unidades->find('all', [
            'contain' => ['Estados']
        ])->where(['Estados.nombre' => $estado]);

        $this->set([
            'unidades' => $unidades,
            '_serialize' => ['unidades']
        ]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $status = 'success';
        $unidad = $this->Unidades->newEntity();
        if ($this->request->is('post')) {
            $unidad = $this->Unidades->patchEntity($unidad, $this->request->data);
            if ($this->Unidades->save($unidad)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->Unidades->Estados->find('list');
        $grupos = [
            0 => 'CANTIDAD',
            1 => 'MONEDA'
        ];
        $this->set(compact('unidad', 'status', 'estados', 'grupos'));
        $this->set('_serialize', ['unidad']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Unidade id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $unidad = $this->Unidades->get($id, [
            'contain' => ['Estados', 'Recursos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unidad = $this->Unidades->patchEntity($unidad, $this->request->data);
            if ($this->Unidades->save($unidad)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->Unidades->Estados->find('list');
        $recursos = $this->Unidades->Recursos->find('list');
        $grupos = [
            0 => 'CANTIDAD',
            1 => 'MONEDA'
        ];
        $this->set(compact('unidad', 'status', 'estados', 'recursos', 'grupos'));
        $this->set('_serialize', ['unidad']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Unidade id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unidad = $this->Unidades->get($id);
        if ($this->Unidades->delete($unidad)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
