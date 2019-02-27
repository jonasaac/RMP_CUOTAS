<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Plantas Controller
 *
 * @property \App\Model\Table\PlantasTable $Plantas
 */
class PlantasController extends AppController
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

          $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool)in_array('admin_planta_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool)in_array('admin_planta_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool)in_array('admin_planta_delete', $this->Auth->user('privilegios')); break;
        }
        return $tmp_permiso || parent::isAuthorized($user);
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
        $plantas = $this->Plantas->find('all', [
            'contain' => ['Recintos', 'Recintos.Estados']
        ])->where([
            'Estados.nombre' => $estado
        ]);

        $this->set([
            'plantas' => $plantas,
            '_serialize' => ['plantas'],
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
        $planta = $this->Plantas->newEntity();
        if ($this->request->is('post')) {
            $planta = $this->Plantas->patchEntity($planta, $this->request->data);
            if ($this->Plantas->save($planta)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $areas = $this->Plantas->Recintos->Areas->find('list');
        $this->set(compact('planta', 'status', 'areas'));
        $this->set('_serialize', ['planta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Planta id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $planta = $this->Plantas->get($id, [
            'contain' => ['Recintos.Estados', 'Recintos.Areas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $planta = $this->Plantas->patchEntity($planta, $this->request->data, [
              'associated' => ['Recintos.Areas._ids']
            ]);
            if ($this->Plantas->save($planta)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $areas = $this->Plantas->Recintos->Areas->find('list');
        $estados = $this->Plantas->Recintos->Estados->find('list');
        $this->set(compact('planta', 'status', 'estados', 'areas'));
        $this->set('_serialize', ['planta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Planta id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $planta = $this->Plantas->get($id);
        if ($this->Plantas->delete($planta)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('status'));
    }
}
