<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Movimientos Controller
 *
 * @property \App\Model\Table\MovimientosTable $Movimientos
 */
class MovimientosController extends AppController
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
            case 'add': $tmp_permiso = (bool)in_array('admin_movimiento_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool)in_array('admin_movimiento_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool)in_array('admin_movimiento_delete', $this->Auth->user('privilegios')); break;
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
     * Metodo utilizado para listar los movimientos, que luego serán mostradas
     * en las datatables
     *
     * @param string|null $estado nombre del estado de los movimientos a consultar
     * @return void
     */
    public function listar($estado = 'ACTIVO')
    {
        $movimientos = $this->Movimientos->find('all')
            ->contain(['Estados'])
            ->where(['Estados.nombre' => $estado]);

        $this->set([
            'movimientos' => $movimientos,
            '_serialize' => ['movimientos']
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
        $movimiento = $this->Movimientos->newEntity();
        if ($this->request->is('post')) {
            $movimiento = $this->Movimientos->patchEntity($movimiento, $this->request->data);
            $movimiento->set('estado_id', 1);
            if ($this->Movimientos->save($movimiento)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('movimiento', 'status'));
        $this->set('_serialize', ['movimiento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Movimiento id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $movimiento = $this->Movimientos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $movimiento = $this->Movimientos->patchEntity($movimiento, $this->request->data);
            if ($this->Movimientos->save($movimiento)) {
              $status = 'success';
            } else {
              $status = 'error';
            }
        }
        $estados = $this->Movimientos->Estados->find('list');
        $this->set(compact('movimiento', 'status', 'estados'));
        $this->set('_serialize', ['movimiento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Movimiento id.
     * @return void
     */
    public function delete($id = null)
    {
        $status = 'success';
        $this->request->allowMethod(['post', 'delete']);
        $movimiento = $this->Movimientos->get($id);
        if ($this->Movimientos->delete($movimiento)) {
          $status = 'success';
        } else {
          $status = 'error';
        }
        $this->set(compact('status'));
    }
}
