<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TipoDescargas Controller
 *
 * @property \App\Model\Table\TipoDescargasTable $TipoDescargas
 */
class TipoDescargasController extends AppController
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
            case 'add': $tmp_permiso = (bool)in_array('admin_tipoDescarga_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool)in_array('admin_tipoDescarga_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool)in_array('admin_tipoDescarga_delete', $this->Auth->user('privilegios')); break;
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

    /**
     * Metodo utilizado para listar los tipo descargas, que luego serán mostradas
     * en las datatables
     *
     * @param string|null $estado nombre del estado de los tipo descargas a consultar
     * @return void
     */
    public function listar($estado = 'ACTIVO')
    {
        $tipodescargas = $this->TipoDescargas->find('all')
            ->contain(['Estados'])
            ->where(['Estados.nombre' => $estado]);

        $this->set([
            'tipodescargas' => $tipodescargas,
            '_serialize' => ['tipodescargas']
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
        $tipoDescarga = $this->TipoDescargas->newEntity();
        if ($this->request->is('post')) {
            $tipoDescarga = $this->TipoDescargas->patchEntity($tipoDescarga, $this->request->data);
            $tipoDescarga->set('estado_id', 1);
            if ($this->TipoDescargas->save($tipoDescarga)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('tipoDescarga', 'status'));
        $this->set('_serialize', ['tipoDescarga']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Descarga id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $tipoDescarga = $this->TipoDescargas->get($id, [
            'contain' => ['Estados']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoDescarga = $this->TipoDescargas->patchEntity($tipoDescarga, $this->request->data);
            if ($this->TipoDescargas->save($tipoDescarga)) {
              $status = 'success';
            } else {
              $status = 'error';
            }
        }
        $estados = $this->TipoDescargas->Estados->find('list');
        $this->set(compact('tipoDescarga', 'status', 'estados'));
        $this->set('_serialize', ['tipoDescarga']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Descarga id.
     * @return void
     */
    public function delete($id = null)
    {
        $status = 'success';
        $this->request->allowMethod(['post', 'delete']);
        $tipoDescarga = $this->TipoDescargas->get($id);
        if ($this->TipoDescargas->delete($tipoDescarga)) {
          $status = 'success';
        } else {
          $status = 'error';
        }
        $this->set(compact('status'));
    }
}
