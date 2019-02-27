<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Procesos Controller
 *
 * @property \App\Model\Table\ProcesosTable $Procesos
 */
class RecursosController extends AppController
{

    /**
     * Index method
     *
     * @return vota
     */
    public function index()
    {
        $this->set('recursos', $this->paginate($this->Recursos));
        $this->set('_serialize', ['recursos']);
    }

    /**
     * Metodo utilizado para listar los recursos, que luego serán mostradas
     * en las datatables
     *
     * @param string|null $estado nombre del estado de los recursos a consultar
     * @return void
     */
    public function listar($estado = 'ACTIVO')
    {
        $recursos = $this->Recursos->find('all')
            ->contain(['Estados'])
            ->where(['Estados.nombre' => $estado]);

        $this->set([
            'recursos' => $recursos,
            '_serialize' => ['recursos']
        ]);
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add()
    {
        $status = 'success';
        $recurso = $this->Recursos->newEntity();
        if ($this->request->is('post')) {
            $recurso = $this->Recursos->patchEntity($recurso, $this->request->data);
            if ($this->Recursos->save($recurso)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $unidades = $this->Recursos->Unidades->find('list');
        $especies = $this->Recursos->Especies->find('list')
            ->order(['Especies.nombre' => 'ASC']);
        $this->set(compact('recurso', 'unidades', 'especies', 'status'));
        $this->set('_serialize', ['recurso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Recurso id.
     * @return void
     */
    public function edit($id = null)
    {

        $status = 'success';
        $recurso = $this->Recursos->get($id, [
            'contain' => ['Estados', 'Especies', 'Unidades']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recurso = $this->Recursos->patchEntity($recurso, $this->request->data);
            if ($this->Recursos->save($recurso)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $unidades = $this->Recursos->Unidades->find('list');
        $especies = $this->Recursos->Especies->find('list')
            ->order(['Especies.nombre' => 'ASC']);
        $estados = $this->Recursos->Estados->find('list');
        $this->set(compact('recurso', 'estados', 'status', 'especies', 'unidades'));
        $this->set('_serialize', ['recurso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recurso id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recurso = $this->Recursos->get($id);
        if ($this->Recursos->delete($recurso)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
