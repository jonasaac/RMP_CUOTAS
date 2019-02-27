<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Resoluciones Controller
 *
 * @property \App\Model\Table\ResolucionesTable $Resoluciones
 */
class ResolucionesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['TipoResolucion', 'Movimientos', 'ZonasPesca', 'Especies']
        ];
        $this->set('resoluciones', $this->paginate($this->Resoluciones));
        $this->set('_serialize', ['resoluciones']);
    }

    /**
     * View method
     *
     * @param string|null $id Resolucione id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resolucione = $this->Resoluciones->get($id, [
            'contain' => ['TipoResolucion', 'Movimientos', 'ZonasPesca', 'Especies']
        ]);
        $this->set('resolucione', $resolucione);
        $this->set('_serialize', ['resolucione']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resolucione = $this->Resoluciones->newEntity();
        if ($this->request->is('post')) {
            $resolucione = $this->Resoluciones->patchEntity($resolucione, $this->request->data);
            if ($this->Resoluciones->save($resolucione)) {
                $this->Flash->success(__('The resolucione has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resolucione could not be saved. Please, try again.'));
            }
        }
        $tipoResolucion = $this->Resoluciones->TipoResolucion->find('list', ['limit' => 200]);
        $movimientos = $this->Resoluciones->Movimientos->find('list', ['limit' => 200]);
        $zonasPesca = $this->Resoluciones->ZonasPesca->find('list', ['limit' => 200]);
        $especies = $this->Resoluciones->Especies->find('list', ['limit' => 200]);
        $this->set(compact('resolucione', 'tipoResolucion', 'movimientos', 'zonasPesca', 'especies'));
        $this->set('_serialize', ['resolucione']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Resolucione id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resolucione = $this->Resoluciones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resolucione = $this->Resoluciones->patchEntity($resolucione, $this->request->data);
            if ($this->Resoluciones->save($resolucione)) {
                $this->Flash->success(__('The resolucione has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resolucione could not be saved. Please, try again.'));
            }
        }
        $tipoResolucion = $this->Resoluciones->TipoResolucion->find('list', ['limit' => 200]);
        $movimientos = $this->Resoluciones->Movimientos->find('list', ['limit' => 200]);
        $zonasPesca = $this->Resoluciones->ZonasPesca->find('list', ['limit' => 200]);
        $especies = $this->Resoluciones->Especies->find('list', ['limit' => 200]);
        $this->set(compact('resolucione', 'tipoResolucion', 'movimientos', 'zonasPesca', 'especies'));
        $this->set('_serialize', ['resolucione']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Resolucione id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resolucione = $this->Resoluciones->get($id);
        if ($this->Resoluciones->delete($resolucione)) {
            $this->Flash->success(__('The resolucione has been deleted.'));
        } else {
            $this->Flash->error(__('The resolucione could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
