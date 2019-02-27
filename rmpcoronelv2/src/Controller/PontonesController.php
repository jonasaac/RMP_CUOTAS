<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pontones Controller
 *
 * @property \App\Model\Table\PontonesTable $Pontones
 */
class PontonesController extends AppController
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
            case 'add': $tmp_permiso = (bool) in_array('admin_ponton_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('admin_ponton_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool) in_array('admin_ponton_delete', $this->Auth->user('privilegios')); break;
        }

        return $tmp_permiso || parent::isAuthorized($user);
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add()
    {
        $status = 'success';
        $ponton = $this->Pontones->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['division_id'] = 1;

            $ponton = $this->Pontones->patchEntity($ponton, $this->request->data);
            $puerto = $this->Pontones->Puertos->get($ponton->puerto_id, [
              'contain' => ['Recintos.Areas']
            ]);
            $ponton->recinto->set('areas', $puerto->recinto->areas);
            if ($this->Pontones->save($ponton, ['associated' => ['Recintos.Areas']])) {
                $ponton = $this->Pontones->get($ponton->id, [
                    'contain' => ['Puertos', 'Recintos.Areas']
                ]);
                debug($ponton->recinto->areas);
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $puertos = $this->Pontones->Puertos->find('list', ['limit' => 200]);
        $this->set(compact('ponton', 'puertos', 'status'));
        $this->set('_serialize', ['ponton']);
    }

    public function listar_filtrado()
    {
      $areasIds = $this->Auth->user('areas_ids');

      $puertos = $this->Pontones->Puertos->find('all', [
          'contain' => [
            'Pontones.Recintos' => function($q) {
              return $q->select(['id', 'nombre']);
            },
            'Recintos' => function($q) {
              return $q->select(['id', 'Recintos.nombre']);
            }
          ]
      ])
      ->distinct(['Puertos.id'])
      ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
        return $q->where(['Areas.id IN' => $areasIds]);
      })
      ->order(['Recintos.nombre' => 'ASC'])
      ->reduce(function($salida, $row) {
        $row->nombre = $row->recinto->nombre;
        unset($row->recinto);
        foreach($row->pontones as $ponton) {
          $ponton->nombre = $ponton->recinto->nombre;
          unset($ponton->recinto);
          unset($ponton->puerto_id);
        }

        $salida[] = $row;
        return $salida;
      }, []);

      $this->set([
        'puertos' => $puertos,
        '_serialize' => ['puertos']
      ]);
    }
}
