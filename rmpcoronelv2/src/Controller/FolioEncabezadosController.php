<?php

namespace App\Controller;

/**
 * FolioEncabezados Controller.
 *
 * @property \App\Model\Table\FolioEncabezadosTable $FolioEncabezados
 */
class FolioEncabezadosController extends AppController
{
  public function isAuthorized($user = null)
  {
      if (in_array($this->request->action, ['index', 'listar']))
          return true;

      switch ($this->request->action) {
          case 'add': return (bool)in_array('produccion_folio_add', $this->Auth->user('privilegios')); break;
          case 'edit': return (bool)in_array('produccion_folio_edit', $this->Auth->user('privilegios')); break;
          case 'delete': return (bool)in_array('produccion_folio_delete', $this->Auth->user('privilegios')); break;
          case 'lock': return (bool)in_array('produccion_folio_lock', $this->Auth->user('privilegios')); break;
          case 'unlock': return (bool)in_array('produccion_folio_unlock', $this->Auth->user('privilegios')); break;
      }
      return parent::isAuthorized($user);
  }
    /**
   * Index method.
   */
  public function index()
  {
      $recuroId = 2; // Sólo Langostinos por ahora
      $recurso = $this->loadModel('Recursos')->get($recuroId);

      $foliosFirstDate = $this->loadModel('FolioEncabezados')->find('all')->select('fecha_recepcion')->order(['fecha_recepcion ASC']);
      if ($foliosFirstDate->isEmpty()) {
          $firstYear = date('Y');
      } else {
          $firstYear = $foliosFirstDate->first()->toArray()['fecha_recepcion']->format('Y');
      }

      $years = range(date('Y'), $firstYear);
      $years = array_combine($years, $years);
      $divisions = $this->loadModel('Divisiones')->find('list');

      $this->set(compact('years', 'recurso'));
      $this->set('_serialize', ['folioEncabezados']);
  }

    public function listar($year = null, $estado = 'ABIERTO')
    {
        $recursosIds = [2]; // XXX: solo langostinos por ahora

    // Se determina el orden que deben tener los datos
    $orderColumnId = $this->request->data('order.0.column');
        $orderColumnName = $this->request->data('columns.'.$orderColumnId.'.name');

        $folios = $this->FolioEncabezados->find('all', [
          'contain' => ['FolioDetalles', 'Estados'],
          ])
    ->where([
      'Estados.nombre' => $estado,
    'FolioEncabezados.recurso_id IN' => $recursosIds,
    ])
    ->offset($this->request->data('start'))
    ->limit($this->request->data('length'));

        if ($year) {
            $folios = $folios->where(function ($exp, $q) use ($year) {
        $ym = $q->func()->year([
          'fecha_recepcion' => 'literal',
          ]);

      return $exp->eq($ym, $year);
    });
        }

        $totaldata = $folios->count();

        $searchString = $this->request->data('search.value');
        if (!empty($searchString)) {
            $folios->where([
              'OR' => [
                  // IDs
                  'CAST(FolioEncabezados.id AS VARCHAR) LIKE' => '%'.$searchString.'%',
                  // Nrofolios
                  'CAST(FolioEncabezados.nro_folio AS VARCHAR) LIKE' => '%'.$searchString.'%',
                  // Fecha
                  'dbo.ConvertirFecha(FolioEncabezados.fecha_recepcion) LIKE' => '%'.$searchString.'%', ],
                  ]);
        }

        $totalfiltered = $folios->count();

        // Se agregan los secuenciales a los encabezados
        $folios->map(function($folio, $key) {
          $folio->secuenciales = NULL;
          $folioDetalles = $this->FolioEncabezados->FolioDetalles->find()
              ->select([
                'ids' => 'REPLACE((SELECT DISTINCT le.id AS [data()] FROM lote_encabezados le, folio_detalles fd, folio_detalles_lote_encabezados fdle WHERE fdle.lote_encabezado_id = le.id AND fdle.folio_detalle_id = fd.id AND FolioDetalles.fecha_produccion = fd.fecha_produccion AND fd.folio_encabezado_id = '.$folio.' ORDER BY le.id FOR xml path(\'\')), \' \', \',\')',
                'secuencial' => 'FolioDetalles.secuencial',
                'cjs_totales' => 0,
                'kls_totales' => 0,
                'rendimiento' => 0
               ])
               ->innerJoinWith('FolioEncabezados', function ($q) use ($folio) {
                 return $q->where(['FolioEncabezados.id' => $folio]);
               })
               ->group(['FolioDetalles.secuencial', 'FolioDetalles.fecha_produccion']);
          return $folio;
        });

        $this->set([
          'folios' => $folios,
          'draw' => $this->request->data('draw'),
          'totaldata' => $totaldata,
          'totalfiltered' => $totalfiltered,
          '_serialize' => ['folios'],
        ]);
    }

  /**
   * Add method.
   */
  public function add()
  {
    $status = 'success';
    $folioEncabezado = $this->FolioEncabezados->newEntity();
    if ($this->request->is('post')) {
        $this->request->data['fecha_recepcion'] = $this->request->data('fecha_recepcion_date').' 00:00';
        $folioEncabezado = $this->FolioEncabezados->patchEntity($folioEncabezado, $this->request->data, [
            'associated' => ['FolioDetalles', 'FolioDetalles.Unidades']
        ]);
        $folioEncabezado->set('estado_id', '3');
        $folioEncabezado->set('recurso_id', $this->request->session()->read('recurso.id'));
        $folioEncabezado->set('division_id', '1');
        $folioEncabezado->set('usuario_uid', $this->Auth->user('uid'));

        // Se calcula el secuencial de cada detalle
        $fecha_recepcion = $folioEncabezado->fecha_recepcion->toUnixString();
        foreach ($folioEncabezado->folio_detalles as $detalle) {
          $fecha_produccion = strtotime($detalle->fecha_produccion);
          $detalle->set('secuencial', date('z', $fecha_produccion) - date('z', $fecha_recepcion));
        }
        if ($this->FolioEncabezados->save($folioEncabezado)) {
          $status = 'success';
        } else {
          $status = 'error';
        }
    }
    // NOTE: Codigo temporal
    $recursoId = 2; // XXX: Solo para langostinos
    $recurso = $this->loadModel('Recursos')->get($recursoId, [
      'contain' => ['UnidadesPrincipales'],
    ]);
    //$calibres = $this->FolioEncabezados->FolioDetalles->Calibres->find('list');

    $this->set(compact('folioEncabezado', 'status', 'recurso'));
    $this->set('_serialize', ['folioEncabezado']);
  }

    /**
     * Edit method.
     *
     * @param string|null $id Folio Encabezado id.
     *
     */
    public function edit($id = null)
    {
      $status = 'success';
      $folioEncabezado = $this->FolioEncabezados->get($id, [
      'contain' => ['FolioDetalles',
                    'FolioDetalles.DescargaDetalles',
                    'FolioDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas.Naves',
                    'FolioDetalles.Especies',
                    'FolioDetalles.Unidades'],
      ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
          $this->request->data['fecha_recepcion'] = $this->request->data('fecha_recepcion_date').' 00:00';
          $folioEncabezado = $this->FolioEncabezados->patchEntity($folioEncabezado, $this->request->data, [
              'associated' => ['FolioDetalles', 'FolioDetalles.Unidades', 'FolioDetalles.Unidades._joinData']
          ]);
          $folioEncabezado->set('usuario_uid', $this->Auth->user('uid'));

          // Se calcula el secuencial de cada detalle
          $fecha_recepcion = $folioEncabezado->fecha_recepcion->toUnixString();
          foreach ($folioEncabezado->folio_detalles as $detalle) {
            $fecha_produccion = strtotime($detalle->fecha_produccion);
            $detalle->set('secuencial', date('z', $fecha_produccion) - date('z', $fecha_recepcion));
          }
          if ($this->FolioEncabezados->save($folioEncabezado)) {
            $detallesIds = [];
            foreach($folioEncabezado->folio_detalles as $d) {
                $detallesIds[] = $d->id;
            }

            $query = $this->FolioEncabezados
                          ->FolioDetalles->find('all')
                          ->where([
                              'folio_encabezado_id' => $folioEncabezado->id,
                              'id NOT IN' => $detallesIds
                          ]);
            foreach ($query as $deleteDetalle) {
                $this->FolioEncabezados->FolioDetalles->delete($deleteDetalle);
            }

            $status = 'success';
          } else {
            $status = 'error';
          }
      }

      $recursoId = 2; // XXX: Solo para langostinos
      $recurso = $this->loadModel('Recursos')->get($recursoId, [
        'contain' => ['UnidadesPrincipales'],
      ]);
      //$calibres = $this->FolioEncabezados->FolioDetalles->Calibres->find('list');
      $this->set(compact('folioEncabezado', 'status', 'recurso'));
      $this->set('_serialize', ['folioEncabezado']);
    }

        /**
         * Delete method.
         *
         * @param string|null $id Folio Encabezado id.
         *
         */
        public function delete($id = null)
        {
            $this->request->allowMethod(['post', 'delete']);
            $folioEncabezado = $this->FolioEncabezados->get($id);
            if ($this->FolioEncabezados->delete($folioEncabezado)) {
              $status = 'success';
            } else {
              $status = 'error';
            }

            $this->set(compact('status'));
        }

        public function lock($id = null) {
            $this->request->allowMethod(['post']);

            $folioEncabezado = $this->FolioEncabezados->get($id, ['contain' => []]);
            $folioEncabezado->set('estado_id', '4');
            $this->FolioEncabezados->touch($folioEncabezado, 'Model.lock');
            if ($this->FolioEncabezados->save($folioEncabezado)) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            $this->set(compact('folioEncabezado', 'status'));
        }

        public function unlock($id = null) {
            $this->request->allowMethod(['post']);

            $folioEncabezado = $this->FolioEncabezados->get($id);
            $folioEncabezado->set('estado_id', '3');
            if ($this->FolioEncabezados->save($folioEncabezado)) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            $this->set(compact('folioEncabezado', 'status'));
            $this->render('lock');
        }
}
