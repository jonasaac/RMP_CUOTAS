<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ArtePesca Controller
 *
 * @property \App\Model\Table\ArtePescaTable $ArtePesca
 */
class ArtePescaController extends AppController
{

    /**
     * Metodo usado para determinar si un usuario esta autorizado
     * a acceder a una determinada acción del modulo.
     */
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['index', 'listar'])) {
            return true;
        }

        switch ($this->request->action) {
            case 'add': return (bool) in_array('admin_artePesca_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool) in_array('admin_artePesca_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool) in_array('admin_artePesca_delete', $this->Auth->user('privilegios')); break;
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
        $artepesca = $this->ArtePesca->find('all',[
            'contain' => ['Estados', 'Recursos']
        ])->where(['Estados.nombre' => $estado]);

        $this->set([
            'artepesca' => $artepesca,
            '_serialize' => ['artepesca'],
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
        $artePesca = $this->ArtePesca->newEntity();
        if ($this->request->is('post')) {
            $artePesca = $this->ArtePesca->patchEntity($artePesca, $this->request->data);
            if ($this->ArtePesca->save($artePesca)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $recursos = $this->ArtePesca->Recursos->find('list');

        $this->set(compact('artePesca', 'recursos', 'status'));
        $this->set('_serialize', ['artePesca']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Arte Pesca id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $artePesca = $this->ArtePesca->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $artePesca = $this->ArtePesca->patchEntity($artePesca, $this->request->data);
            if ($this->ArtePesca->save($artePesca)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $estados = $this->ArtePesca->Estados->find('list');
        $recursos = $this->ArtePesca->Recursos->find('list');
        $this->set(compact('artePesca', 'status', 'estados', 'recursos'));
        $this->set('_serialize', ['artePesca']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Arte Pesca id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $artePesca = $this->ArtePesca->get($id);
        if ($this->ArtePesca->delete($artePesca)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
