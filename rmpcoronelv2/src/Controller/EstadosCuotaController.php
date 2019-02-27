<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EstadosCuota Controller
 *
 * @property \App\Model\Table\EstadosCuotaTable $EstadosCuota
 */
class EstadosCuotaController extends AppController
{
    /**
     * Carga los componentes necesarios del Controlador
     *
     * @return null
     */
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
        if (in_array($this->request->action, ['index'])) {
            return true;
        }

        $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool) in_array('cuotas_estado_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('cuotas_estado_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool) in_array('cuotas_estado_delete', $this->Auth->user('privilegios')); break;
        }

        return $tmp_permiso || parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $estadoYear = $this->EstadosCuota
            ->find('all')
            ->select('fecha_estado')
            ->order(['fecha_estado ASC']);

        if ($estadoYear->count() == 0) {
            $firstYear = date('Y');
        } else {
            $firstYear = $estadoYear->first()->toArray()['fecha_estado']->format('Y');
        }

        $years = range(date('Y'), $firstYear);

        $this->set(['years' => $years]);

        if ($this->request->is(['ajax', 'get'])) {
            $estadosCuota = $this->EstadosCuota->find('all')
                ->contain(['Unidades', 'MacroZonas', 'Especies']);

            if ($this->request->query('year')) {
                $estadosCuota = $estadosCuota
                    ->where([
                        'YEAR(fecha_estado)' => $this->request->query('year'),
                    ]);
            }

            if ($this->request->query('especie') && $this->request->query('especie') != 'undefined') {
                $estadosCuota = $estadosCuota
                    ->where([
                        'especie_id' => $this->request->query('especie')
                    ]);
            }

            if ($this->request->query('reload')) {
                $this->set([
                    'data' => $estadosCuota,
                    '_serialize' => ['data']
                ]);
            } else {
                $this->set([
                    'estadosCuota' => $estadosCuota,
                    '_serialize' => ['estadosCuota']
                ]);
            }
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $status = 'success';
        $errors = [];
        $estadoCuota = $this->EstadosCuota->newEntity();
        if ($this->request->is('post')) {
            $estadoCuota = $this->EstadosCuota->patchEntity($estadoCuota, $this->request->data);
            $estadoCuota->set('usuario_uid', $this->Auth->user('uid'));
            $errors = $estadoCuota->errors();
            if ($this->EstadosCuota->save($estadoCuota)) {
              $status = 'success';
            } else {
              $status = 'error';
            }
        }

        $this->set(compact('estadosCuota', 'status', 'errors'));
        $this->set('_serialize', ['estadosCuota', 'status', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Estados Cuotum id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $errors = [];
        $estadoCuota = $this->EstadosCuota->get($id, [
            'contain' => ['Unidades', 'MacroZonas', 'Especies']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estadoCuota = $this->EstadosCuota->patchEntity($estadoCuota, $this->request->data);
            $errors = $estadoCuota->errors();
            if ($this->EstadosCuota->save($estadoCuota)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('estadoCuota', 'status', 'errors'));
        $this->set('_serialize', ['estadoCuota', 'status', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Estados Cuotum id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estadoCuota = $this->EstadosCuota->get($id);
        if ($this->EstadosCuota->delete($estadoCuota)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set([
            'status' => $status,
            '_serialize' => ['status']
        ]);
    }
}
