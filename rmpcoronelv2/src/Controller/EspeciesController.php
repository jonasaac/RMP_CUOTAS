<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Especies Controller
 *
 * @property \App\Model\Table\EspeciesTable $Especies
 */
class EspeciesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
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
            case 'add': return (bool)in_array('admin_especie_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('admin_especie_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('admin_especie_delete', $this->Auth->user('privilegios')); break;
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

    /**
     * Metodo utilizado para listar las especies, que luego serán mostradas
     * en las datatables
     *
     * @param string|null $estado nombre del estado de las especies a consultar
     * @return void
     */
    public function listar($estado = 'ACTIVO')
    {
        $especies = $this->Especies->find('all', [
            'contain' => ['Estados' => ['fields' => ['id']]]
        ])
        ->where(['Estados.nombre' => $estado]);

        if ($this->request->query('tieneLicencias')) {
          $especies = $especies->innerJoinWith('Licencias', function ($q) {
            return $q->where(['Licencias.fecha_termino_vigencia >' => new \DateTime()]);
          })->distinct();
        }

        if ($this->request->query('q')) {
            $query_value = str_replace('+', ' ', $this->request->query('q'));
            $especies = $especies->where([
                'Especies.nombre LIKE' => '%'.$query_value.'%'
            ]);
        }

        $this->set([
            'especies' => $especies,
            '_serialize' => ['especies'],
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
        $especie = $this->Especies->newEntity();
        if ($this->request->is('post')) {
            $especie = $this->Especies->patchEntity($especie, $this->request->data);
            if ($this->Especies->save($especie)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $recursos = $this->Especies->Recursos->find('list');
        $errors = $especie->errors();
        $this->set(compact('especie', 'status', 'recursos', 'errors'));
        $this->set('_serialize', ['especie', 'status', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Especie id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $especie = $this->Especies->get($id, [
            'contain' => ['Recursos', 'Estados']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $especie = $this->Especies->patchEntity($especie, $this->request->data);
            if ($this->Especies->save($especie)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $recursos = $this->Especies->Recursos->find('list');
        $estados = $this->Especies->Estados->find('list');
        $errors = $especie->errors();
        $this->set(compact('especie', 'status', 'estados', 'recursos', 'errors'));
        $this->set('_serialize', ['especie', 'status', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Especie id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $especie = $this->Especies->get($id);
        if ($this->Especies->delete($especie)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $data = $this->request->data;
        $this->set(compact('status'));
        $this->set('_serialize', ['status', 'data']);

    }
}
