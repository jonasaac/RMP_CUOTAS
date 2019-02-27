<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Puertos Controller
 *
 * @property \App\Model\Table\PuertosTable $Puertos
 */
class PuertosController extends AppController
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
        if (in_array($this->request->action, ['index', 'listar', 'listar_filtrado'])) {
            return true;
        }

        $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool) in_array('admin_puerto_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('admin_puerto_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool) in_array('admin_puerto_delete', $this->Auth->user('privilegios')); break;
        }

        return $tmp_permiso || parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('puertos', $this->paginate($this->Puertos));
        $this->set('_serialize', ['puertos']);
    }

    public function listar_filtrado()
    {
      $recursosIds = $this->Auth->user('recursos_ids');
      $areasIds = $this->Auth->user('areas_ids');

      $puertos = $this->Puertos->find('list')
          ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          });
      $puertos = $puertos->toArray();
      asort($puertos, SORT_STRING);

      $this->set([
        'puertos' => $puertos,
        '_serialize' => ['puertos']
      ]);
    }

    public function listar($estado = 'ACTIVO')
    {
        $puertos = $this->Puertos->find('all', [
            'contain' => ['Pontones.Recintos', 'Recintos', 'Recintos.Estados']
        ])->where([
            'Estados.nombre' => $estado
        ]);

        $this->set([
            'puertos' => $puertos,
            '_serialize' => ['puertos'],
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
        $puerto = $this->Puertos->newEntity();
        if ($this->request->is('post')) {
            /*if(empty($this->request->data['pontones']))
                $this->request->data['pontones'] = Array();
            $temp = Array();
            foreach($this->request->data['pontones'] as $ponton) {
                $ponton['estado'] = 1;
                $temp[] = $ponton;
            }
            $this->request->data['pontones'] = $temp;
            */
            $puerto = $this->Puertos->patchEntity($puerto, $this->request->data, [
              'associated' => ['Recintos.Areas._ids', 'Pontones.Recintos']
            ]);
            foreach ($puerto->pontones as $ponton) {
              $ponton->recinto->set('areas', $puerto->recinto->areas);
            }
            if ($this->Puertos->save($puerto)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $areas = $this->Puertos->Recintos->Areas->find('list');
        $this->set(compact('puerto', 'status', 'areas'));
        $this->set('_serialize', ['puerto']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Puerto id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $puerto = $this->Puertos->get($id, [
            'contain' => ['Pontones', 'Recintos.Areas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $puerto = $this->Puertos->patchEntity($puerto, $this->request->data, [
                'associated' => ['Pontones.Recintos', 'Recintos', 'Recintos.Areas._ids']
            ]);
            foreach ($puerto->pontones as $ponton) {
              $ponton->recinto->set('areas', $puerto->recinto->areas);
            }
            if ($this->Puertos->save($puerto)) {
                $pontonesIds = [];
                foreach($puerto->pontones as $p) {
                    $pontonesIds[] = $p->id;
                }

                $pontones = $this->Puertos->Pontones->find()
                    ->where(['puerto_id' => $puerto->id, 'id NOT IN' => $pontonesIds])
                    ->toArray();

                foreach ($pontones as $ponton) {
                  $this->Puertos->Pontones->delete($ponton);
                }

                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $areas = $this->Puertos->Recintos->Areas->find('list');
        $this->set(compact('puerto', 'status', 'areas'));
        $this->set('_serialize', ['puerto']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Puerto id.
     * @return void.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $puerto = $this->Puertos->get($id);
        if ($this->Puertos->delete($puerto)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
