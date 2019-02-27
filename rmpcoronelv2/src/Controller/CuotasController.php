<?php

namespace App\Controller;

/**
 * Mareas Controller.
 *
 * @property \App\Model\Table\CuotasTable $Cuotas
 */
class CuotasController extends AppController
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

      switch ($this->request->action) {
          case 'add': return (bool) in_array('rmp_marea_add', $this->Auth->user('privilegios')); break;
          case 'edit': return (bool) in_array('rmp_marea_edit', $this->Auth->user('privilegios')); break;
          case 'delete': return (bool) in_array('rmp_marea_delete', $this->Auth->user('privilegios')); break;
          case 'lock': return (bool) in_array('rmp_marea_lock', $this->Auth->user('privilegios')); break;
          case 'unlock': return (bool) in_array('rmp_marea_unlock', $this->Auth->user('privilegios')); break;
      }

      return parent::isAuthorized($user);
  }

  /**
   * Metodo que es utilizado para cargar la vista principal
   * de la sección de mareas en el modulo de RMP. Además, se utiliza este metodo
   * para determinar la cantidad de años que serán mostrados en la vista.
   */
  public function index()
  {
    $recursosIds = $this->Auth->user('recursos_ids');

    /**$mareasfirstDate = $this->loadModel('Mareas')
                            ->find('all')
                            ->where(['Mareas.recurso_id IN' => $recursosIds])
                            ->select('fecha_zarpe')
                            ->order(['fecha_zarpe ASC']);

    if ($mareasfirstDate->count() == 0) {
        $firstYear = date('Y');
    } else {
        $firstYear = $mareasfirstDate->first()->toArray()['fecha_zarpe']->format('Y');
    }

    $years = range(date('Y'), $firstYear);
    $years = array_combine($years, $years);

    $this->set(compact('years'));*/
  }

  /**
   * Metodo utilizado para listar las mareas, que luego serán mostradas
   * en las datatables
   *
   * @param int|null $year año en el que se buscan las mareas
   * @param string|null $estado nombre del estado de las mareas a consultar
   * @return void
   */
  public function listar($year = null, $estado = 'ABIERTO')
  {
    $data = $this->Cuotas->find();
    $this->set(['data' => $data]);
  }

  /**
   * Add method
   *
   * @return void
   */
  public function add()
  {
    $recursosIds = $this->Auth->user('recursos_ids');
    $areasIds = $this->Auth->user('areas_ids');

    $status = 'success';
    $cuota = $this->Cuotas->newEntity();
    $this->set(compact('cuota'));
    $this->set('_serialize', ['cuota']);

  }

  /**
   * Edit method.
   *
   * @param string|null $id Marea id.
   * @return void
   */
  public function edit($id = null)
  {
    $recursosIds = $this->Auth->user('recursos_ids');
    $areasIds = $this->Auth->user('areas_ids');

    $status = 'success';
    if (isset($this->request->data['id'])) {
        $id = $this->request->data['id'];
    }

    $marea = $this->Mareas->get($id, [
        'contain' => ['Naves'],
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $this->request->data['fecha_zarpe'] = $this->request->data('fecha_zarpe_date').' '.$this->request->data('fecha_zarpe_time');
      $marea = $this->Mareas->patchEntity($marea, $this->request->data);
      $marea->set('usuario_uid', $this->Auth->user('uid'));
      if ($this->Mareas->save($marea)) {
          $status = 'success';
      } else {
          $status = 'error';
      }
    }

    $reducer = function ($output, $value) {
      if(!array_key_exists($value->id, $output)) {
        $output[$value->id] = $value;
      }
      return $output;
    };

    $naves = $this->Mareas->Naves->find('all')
        ->contain(['Recursos'])
        ->select(['id', 'Naves.nombre', 'Naves.capitan_id'])
        ->innerJoinWith('Recursos', function ($q) use ($recursosIds) {
            return $q->where(['Recursos.id IN' => $recursosIds]);
        })
        ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
        })
        ->order(['Naves.nombre' => 'ASC'])
        ->reduce($reducer, []);
    $capitanes = $this->Mareas->Capitanes->find('list')
        ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
        });
    $capitanes = $capitanes->toArray();
    asort($capitanes, SORT_STRING);
    $puertos = $this->Mareas->Puertos->find('list')
        ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        });
    $puertos = $puertos->toArray();
    asort($puertos, SORT_STRING);
    $artePesca = $this->Mareas->ArtePesca->find('all')
        ->where(['ArtePesca.recurso_id IN' => $recursosIds])
        ->order(['nombre' => 'ASC']);
    $this->set(compact('marea', 'status', 'artePesca', 'capitanes', 'puertos', 'naves'));
    $this->set('_serialize', ['marea']);
  }

  /**
   * Delete method.
   *
   * @param string|null $id Marea id.
   * @return void
   */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);

    $marea = $this->Mareas->get($id, ['contain' => 'Recaladas']);
    if (count($marea->recaladas) > 0) {
        $status = 'error';
    } else {
        if ($this->Mareas->delete($marea)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
    }

    $this->set(compact('status'));
  }

  /**
   * Metodo utilizado para manejar el cierre de una marea
   *
   * @param int|null $id Marea $id
   * @return void
   **/
  public function lock($id = null)
  {
    $this->request->allowMethod(['post']);

    $marea = $this->Mareas->get($id, ['contain' => ['Recaladas', 'RecaladasAbiertas']]);
    if (count($marea->recaladas_abiertas) > 0) {
        $status = 'error';
    } else {
        $marea->set('estado_id', '4');
        $this->Mareas->touch($marea, 'Model.lock');
        if ($this->Mareas->save($marea)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
    }

    $this->set(compact('status'));
  }

  /**
   * Metodo utilizado para manejar el re-apertura de una marea
   *
   * @param int|null $id Marea $id
   * @return void
   **/
  public function unlock($id = null)
  {
    $this->request->allowMethod(['post']);

    $marea = $this->Mareas->get($id);
    $marea->set('estado_id', '3');
    if ($this->Mareas->save($marea)) {
        $status = 'success';
    } else {
        $status = 'error';
    }

    $this->set(compact('status'));
    $this->render('lock');
  }
}
