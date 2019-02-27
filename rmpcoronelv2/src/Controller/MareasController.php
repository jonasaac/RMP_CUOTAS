<?php

namespace App\Controller;

/**
 * Mareas Controller.
 *
 * @property \App\Model\Table\MareasTable $Mareas
 */
class MareasController extends AppController
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

    $mareasfirstDate = $this->loadModel('Mareas')
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

    $this->set(compact('years'));
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
    $recursosIds = $this->Auth->user('recursos_ids');
    $areasIds = $this->Auth->user('areas_ids');

    // Se determina el orden que deben tener los datos
    $orderColumnId = $this->request->data('order.0.column');
    $orderColumnName = $this->request->data('columns.'.$orderColumnId.'.name');

    // Se seleccionan las naves que tienen un area en común con el usuario
    $areas_naves_ids = array_keys($this->Mareas->Naves->find('list')
        ->innerJoinWith('Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        })->toArray());

    // Se selecciones los puertos
    $areas_recintos_ids = array_keys($this->Mareas->Puertos->find('list')
        ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        })->toArray());

    $mareas = $this->Mareas->find('all')
        ->contain(['Naves', 'Capitanes', 'Puertos.Recintos', 'Estados', 'ArtePesca'])
        ->where([
          'Estados.nombre' => $estado,
          'Mareas.recurso_id IN' => $recursosIds,
          'OR' => [
            'Naves.id IN' => $areas_naves_ids,
            'Recintos.id IN' => $areas_recintos_ids
          ]
        ]);
        /*->offset($this->request->data('start'))
        ->limit($this->request->data('length'));*/

    if ($orderColumnId) {
      $orderColumns = [];
      foreach ( explode(' ', $orderColumnName) as $orderName ) {
        $orderColumns[$orderName] = $this->request->data('order.0.dir');
      }

      $mareas->order( $orderColumns );
    }

    if ($year) {
      $mareas->where(function ($exp, $q) use ($year) {
          $ym = $q->func()->year([
              'fecha_zarpe' => 'literal',
          ]);

          return $exp->eq($ym, $year);
      });
    }

    $totaldata = $mareas->count();

    $searchString = $this->request->data('search.value');
    if ( !empty($searchString) ) {
      $array_search = explode(' ', $searchString);

      $mareas_array = [];
      foreach ($array_search AS $search) {
        if (empty($search))
          continue;
        $tmp_mareas = $mareas->cleanCopy();
        $tmp_mareas->where([
          'OR' => [
            // IDs
            'CAST(Mareas.id AS VARCHAR) LIKE'    => '%'.$search.'%',
            // Puertos
            'Recintos.nombre LIKE'       => '%'.$search.'%',
            // Fecha
            'dbo.ConvertirFecha(Mareas.fecha_zarpe) LIKE' => '%'.$search.'%',
            // Naves
            'Naves.nombre LIKE'                  => '%'.$search.'%',
            // Capitanes
            'Capitanes.nombre_razon_social LIKE' => '%'.$search.'%',
            'Capitanes.nombre LIKE'              => '%'.$search.'%',
            'Capitanes.apellido_paterno LIKE'    => '%'.$search.'%',
            'Capitanes.apellido_materno LIKE'    => '%'.$search.'%'
          ]
        ]);
        $tmp_mareas_array = $tmp_mareas->toArray();

        //debug($search);
        //debug($tmp_mareas_array);
        if (empty($mareas_array)) {
          $mareas_array = $tmp_mareas_array;
        } else {
          $mareas_array = array_uintersect($tmp_mareas_array, $mareas_array, "comparacion_ids");
        }
        //$mareas_array = array_merge($mareas_array, $tmp_mareas->toArray());
        // XXX: se debre realizar una interseccion con array_intersect_uassoc()
      }
    } else {
        $mareas_array = $mareas->toArray();
    }

    $totalfiltered = count($mareas_array);//$mareas->count();

    if ($this->request->data('start')) {
      $startResponse = $this->request->data('start');
    } else {
      $startResponse = 0;
    }

    if ($this->request->data('length')) {
      $lengthResponse = $this->request->data('length');
    } else {
      $lengthResponse = 100;
    }

    $mareas_array = array_slice($mareas_array, $startResponse, $lengthResponse);

    $this->set([
      'draw'          => $this->request->data('draw'),
      'totaldata'     => $totaldata,
      'totalfiltered' => $totalfiltered,
      'mareas'        => $mareas_array,//$mareas,
      '_serialize'    => ['mareas', 'draw'],
    ]);
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
    $marea = $this->Mareas->newEntity();
    if ($this->request->is('post')) {
      $this->request->data['fecha_zarpe'] = $this->request->data('fecha_zarpe_date').' '.$this->request->data('fecha_zarpe_time');
      $marea = $this->Mareas->patchEntity($marea, $this->request->data);
      $marea->set('estado_id', '3');
      $marea->set('division_id', '1');
      $marea->set('usuario_uid', $this->Auth->user('uid'));
      if ($this->Mareas->save($marea)) {
          $marea = $this->Mareas->get($marea->id, [
              'contain' => ['Naves', 'ArtePesca'],
          ]);
          $status = 'success';
      } else {
          $status = 'error';
      }
    }

    /*
    asort($capitanes, SORT_STRING);*/
    $artePesca = $this->Mareas->ArtePesca->find('all')
                                         ->where(['ArtePesca.recurso_id IN' => $recursosIds])
                                         ->order(['nombre' => 'ASC']);
    $this->set(compact('marea', 'artePesca', 'status'));
    $this->set('_serialize', ['marea']);
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
        'contain' => ['Naves', 'Capitanes', 'Puertos'],
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

    $artePesca = $this->Mareas->ArtePesca->find('all')
        ->where(['ArtePesca.recurso_id IN' => $recursosIds])
        ->order(['nombre' => 'ASC']);
    $this->set(compact('marea', 'status', 'artePesca'));
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
