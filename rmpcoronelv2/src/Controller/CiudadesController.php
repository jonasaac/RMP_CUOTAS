<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ciudades Controller
 *
 * @property \App\Model\Table\CiudadesTable $Ciudades
 */
class CiudadesController extends AppController
{

    /**
     * Metodo utilizado para verificar el nivel de autorizacion de un usuario
     *
     * @param int|null $user uid de un Usuario a consultar
     * @return bool que indica si el usuario a sido autorizado (true) o no (false)
     */
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['index', 'listar'])) {
            return true;
        }

        $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool) in_array('admin_ciudad_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('admin_ciudad_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool) in_array('admin_ciudad_delete', $this->Auth->user('privilegios')); break;
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
        $ciudades = $this->Ciudades->find('all', [
            'contain' => ['Estados']
        ])->where(['Estados.nombre' => $estado]);

        $this->set([
            'ciudades' => $ciudades,
            '_serialize' => ['ciudades']
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
        $ciudad = $this->Ciudades->newEntity();
        if ($this->request->is('post')) {
            $ciudad = $this->Ciudades->patchEntity($ciudad, $this->request->data);
            if ($this->Ciudades->save($ciudad)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('ciudad', 'status'));
        $this->set('_serialize', ['ciudad']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ciudade id.
     * @return void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $ciudad = $this->Ciudades->get($id, [
            'contain' => ['Estados']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ciudad = $this->Ciudades->patchEntity($ciudad, $this->request->data);
            if ($this->Ciudades->save($ciudad)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->Ciudades->Estados->find('list');
        $this->set(compact('ciudad', 'estados', 'status'));
        $this->set('_serialize', ['ciudad']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ciudade id.
     * @return void Redirects to index.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ciudad = $this->Ciudades->get($id);
        if ($this->Ciudades->delete($ciudad)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
