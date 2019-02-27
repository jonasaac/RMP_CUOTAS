<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Camiones Controller
 *
 * @property \App\Model\Table\CamionesTable $Camiones
 */
class CamionesController extends AppController
{

    /**
     * Metodo utilizado para verificar el nivel de autorizacion de un usuario
     *
     * @param int|null $user uid de un Usuario a consultar
     * @return bool que indica si el usuario a sido autorizado (true) o no (false)
     */
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['index', 'listar']))
            return true;

        switch ($this->request->action) {
            case 'add': return (bool)in_array('admin_camion_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('admin_camion_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('admin_camion_delete', $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

    public function listar($estado = 'ACTIVO')
    {
        $camiones = $this->Camiones->find('all', [
            'contain' => ['Estados', 'Transportes']
        ])->where(['Estados.nombre' => $estado]);

        $this->set([
            'camiones' => $camiones,
            '_serialize' => ['camiones'],
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
        $camion = $this->Camiones->newEntity();
        if ($this->request->is('post')) {
            $camion = $this->Camiones->patchEntity($camion, $this->request->data);
            if ($this->Camiones->save($camion)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $areas = $this->Camiones->Areas->find('list');
        $transportes = $this->Camiones->Transportes->find('list');
        $this->set(compact('camion', 'status', 'transportes', 'areas'));
        $this->set('_serialize', ['camion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Camione id.
     * @return void
     */
    public function edit($id = null)
    {
        $camion = $this->Camiones->get($id, [
            'contain' => ['Areas']
        ]);
        $status = 'success';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $camion = $this->Camiones->patchEntity($camion, $this->request->data);
            if ($this->Camiones->save($camion)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $areas = $this->Camiones->Areas->find('list');
        $transportes = $this->Camiones->Transportes->find('list');
        $estados = $this->Camiones->Estados->find('list');
        $this->set(compact('camion', 'status', 'transportes', 'estados', 'areas'));
        $this->set('_serialize', ['camion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Camione id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $camione = $this->Camiones->get($id);
        if ($this->Camiones->delete($camione)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('status'));
    }
}
