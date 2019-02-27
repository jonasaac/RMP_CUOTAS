<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Divisiones Controller
 *
 * @property \App\Model\Table\DivisionesTable $Divisiones
 */
class DivisionesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

    public function listar()
    {
        $divisiones = $this->Divisiones->find('all')->contain(['Estados']);

        $this->set([
            'divisiones' => $divisiones,
            '_serialize' => ['divisiones'],
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
        $division = $this->Divisiones->newEntity();
        if ($this->request->is('post')) {
            $division = $this->Divisiones->patchEntity($division, $this->request->data);
            if ($this->Divisiones->save($division)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $estados = $this->Divisiones->Estados->find('list');
        $this->set(compact('division', 'estados'));
        $this->set('status', $status);
        $this->set('_serialize', ['division']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Divisione id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $division = $this->Divisiones->get($id, [
            'contain' => ['Estados']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $division = $this->Divisiones->patchEntity($division, $this->request->data);
            if ($this->Divisiones->save($division)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $estados = $this->Divisiones->Estados->find('list');
        $this->set(compact('division', 'estados', 'status'));
        $this->set('_serialize', ['division']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Divisione id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $division = $this->Divisiones->get($id);
        if ($this->Divisiones->delete($division)) {
            $status = 'success';
        } else {
            $status =  'error';
        }

        $this->set(compact('status'));
    }
}
?>
