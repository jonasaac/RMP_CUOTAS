<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LoteEncabezados Controller
 *
 * @property \App\Model\Table\LoteEncabezadosTable $LoteEncabezados
 */
class LoteEncabezadosController extends AppController
{
  public function isAuthorized($user = null)
  {
      if (in_array($this->request->action, ['listar']))
          return true;

      switch ($this->request->action) {
          case 'add': return (bool)in_array('produccion_lote_add', $this->Auth->user('privilegios')); break;
          case 'edit': return (bool)in_array('produccion_lote_edit', $this->Auth->user('privilegios')); break;
          case 'delete': return (bool)in_array('produccion_lote_delete', $this->Auth->user('privilegios')); break;
          case 'lock': return (bool)in_array('produccion_lote_lock', $this->Auth->user('privilegios')); break;
          case 'unlock': return (bool)in_array('produccion_lote_unlock', $this->Auth->user('privilegios')); break;
      }
      return parent::isAuthorized($user);
  }
  /**
   *
   * @return void Envia una respuesta ajax que tiene un valor booleano, true si
   * los datos ingresados son validos y false en caso contrario
   */
  public function checkSubcodigo()
  {
    $sub_codigo = $this->request->data('sub_codigo');
    $folio_detalles = $this->request->data('folio_detalles');
    $folio_detalles = explode(',', $folio_detalles);

    $lotes = $this->LoteEncabezados->find()->where(['sub_codigo' => $sub_codigo])
      ->matching('FolioDetalles', function ($q) use ($folio_detalles) {
        return $q->where(['FolioDetalles.id IN' => $folio_detalles]);
      });

    $this->set('response', $lotes->isEmpty() );
  }


    public function listar($folio = null, $estado = 'ABIERTO')
    {
        $lotes = $this->LoteEncabezados->find('all', [
            'contain' => ['Estados', 'FolioDetalles', 'LoteDetalles', 'LoteDetalles.Unidades']
        ])->where(['Estados.nombre' => $estado]);

        if ($folio) {
          $lotes = $this->LoteEncabezados->find('all')
              ->select([
                'ids' => 'REPLACE((SELECT DISTINCT le.id AS [data()] FROM lote_encabezados le, folio_detalles fd, folio_detalles_lote_encabezados fdle WHERE fdle.lote_encabezado_id = le.id AND fdle.folio_detalle_id = fd.id AND FolioDetalles.fecha_produccion = fd.fecha_produccion AND fd.folio_encabezado_id = '.$folio.' ORDER BY le.id FOR xml path(\'\')), \' \', \',\')',
                'secuencial' => 'FolioDetalles.secuencial',
                'estado_id' => 'LoteEncabezados.estado_id'
              ])
              ->where(['Estados.nombre' => $estado]) // Se selecciona el estado de los datos que se quieren cargar
              ->innerJoinWith('Estados')
              ->innerJoinWith('FolioDetalles.FolioEncabezados', function ($q) use ($folio) {
                return $q->where(['FolioEncabezados.id' => $folio]);
              })
              ->group(['FolioDetalles.secuencial', 'LoteEncabezados.estado_id', 'FolioDetalles.fecha_produccion'])
              ->map(function ($secuencial, $key) {
                // Se calcula el total de cjs y kls pt
                $lotes_ids = explode(',', $secuencial->ids);

                $lotes = $this->LoteEncabezados->find('all')
                    ->contain(['Estados'])
                    ->where([
                      'LoteEncabezados.id IN' => $lotes_ids,
                      'LoteEncabezados.estado_id' => $secuencial->estado_id
                    ]);

                $total_cjs_pt = 0;
                $total_kls_pt = 0;
                foreach ($lotes as $lote) {
                  $total_cjs_pt += $lote->cajas_totales;
                  $total_kls_pt += $lote->kilos_totales;
                }

                $secuencial->total_cjs_pt = $total_cjs_pt;
                $secuencial->total_kls_pt = $total_kls_pt;

                //Se calcula el rendimiento por secuencial
                $folioDetalles_ids = $secuencial->folio_detalles_ids;
                $folioDetalles = $this->LoteEncabezados->FolioDetalles->find('all')
                    ->contain(['Unidades'])
                    ->where(['FolioDetalles.id IN' => $folioDetalles_ids]);

                $secuencial->total_kls_mp = 0;
                foreach ($folioDetalles as $folioDetalle) {
                  $secuencial->total_kls_mp += $folioDetalle->unidades[0]->_joinData->cantidad * 1000;
                }

                $rendimiento = $secuencial->total_kls_pt/$secuencial->total_kls_mp*100;
                $secuencial->rendimiento = $rendimiento;

                // Se agregan los lotes a la información
                $secuencial->lotes = $lotes->toArray();

                // Se obtiene información del estado
                $estado = $this->LoteEncabezados->Estados->get($secuencial->estado_id);
                $secuencial->estado = $estado;

                return $secuencial;
              });
        }

        $this->set([
            'lotes' => $lotes,
            '_serialize' => ['lotes']
        ]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($folio)
    {
        $loteEncabezado = $this->LoteEncabezados->newEntity();
        $status = 'success';
        if ($this->request->is('post')) {
          $this->request->data['folio_detalles']['_ids'] = explode(',', $this->request->data('folio_detalles._ids'));
            $loteEncabezado = $this->LoteEncabezados->patchEntity($loteEncabezado, $this->request->data, [
                'associated' => ['LoteDetalles', 'LoteDetalles.Unidades', 'FolioDetalles']
            ]);
            $loteEncabezado->set('estado_id', '3');
            $loteEncabezado->set('recurso_id', '2'); // XXX: SOLO LANGOSTINOS
            $loteEncabezado->set('division_id', '1');
            $loteEncabezado->set('usuario_uid', $this->Auth->user('uid'));

            if ($this->LoteEncabezados->save($loteEncabezado)) {
              $status = 'success';
            } else {
              $status = 'error';
            }
        }
        $calibres = $this->LoteEncabezados->LoteDetalles->Calibres->find('list', ['limit' => 200]);
        $folioDetalles = $this->LoteEncabezados->FolioDetalles->find('all', ['limit' => 200])
          ->select([
            'ids' => 'REPLACE((SELECT id AS [data()] FROM folio_detalles WHERE FolioDetalles.fecha_produccion = fecha_produccion AND FolioDetalles.especie_id = especie_id AND folio_encabezado_id = '.$folio.' ORDER BY fecha_produccion FOR xml path(\'\')), \' \', \',\')',
            'nro_folio' => 'FolioEncabezados.nro_folio',
            'especie_id' => 'FolioDetalles.especie_id',
            'especie' => 'Especies.nombre',
            'secuencial' => 'FolioDetalles.secuencial',
            'fecha_produccion' => 'FolioDetalles.fecha_produccion',
            'nave_id' => 'Mareas.nave_id',
            'nave_senal_distintiva' => 'Naves.senal_distintiva',
            'total_TON' => 'SUM(CASE WHEN FolioDetallesUnidades.unidad_id = \'1\' THEN FolioDetallesUnidades.cantidad ELSE 0 END)',
            'total_CJS' => 'SUM(CASE WHEN FolioDetallesUnidades.unidad_id = \'2\' THEN FolioDetallesUnidades.cantidad ELSE 0 END)'
          ])
          ->contain(['Especies', 'FolioEncabezados', 'DescargaDetalles.DescargaEncabezados.Recaladas.Mareas.Naves'])
          ->innerJoinWith('Unidades') // Usado para agregar unidades asociadas
          ->where(['FolioDetalles.folio_encabezado_id' => $folio])
          ->group([
            'FolioEncabezados.nro_folio',
            'FolioDetalles.especie_id',
            'FolioDetalles.fecha_produccion',
            'FolioDetalles.secuencial',
            'Especies.nombre',
            'Mareas.nave_id',
            'Naves.senal_distintiva'
          ]);

        $subcodigos = ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F'];

        $this->set(compact('loteEncabezado', 'folioDetalles', 'subcodigos', 'calibres', 'status'));
        $this->set('_serialize', ['loteEncabezado']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lote Encabezado id.
     * @return void
     */
    public function edit($folio, $id = null)
    {
        $loteEncabezado = $this->LoteEncabezados->get($id, [
            'contain' => ['LoteDetalles', 'LoteDetalles.Unidades', 'LoteDetalles.Calibres', 'FolioDetalles']
        ]);
        $status = 'success';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loteEncabezado = $this->LoteEncabezados->patchEntity($loteEncabezado, $this->request->data, [
                'associated' => ['LoteDetalles', 'LoteDetalles.Unidades', 'LoteDetalles.Unidades._joinData', 'FolioDetalles']
            ]);
            $loteEncabezado->set('usuario_uid', $this->Auth->user('uid'));
            if ($this->LoteEncabezados->save($loteEncabezado)) {
              $detallesIds = [];
              foreach($loteEncabezado->lote_detalles as $d) {
                  $detallesIds[] = $d->id;
              }

              $query = $this->LoteEncabezados
                            ->LoteDetalles->find('all')
                            ->where([
                                'lote_encabezado_id' => $loteEncabezado->id,
                                'id NOT IN' => $detallesIds
                            ])
                            ->toArray();

              foreach ($query as $deleteDetalle) {
                  $this->LoteEncabezados->LoteDetalles->delete($deleteDetalle);
              }

              $status = 'success';
            } else {
              $status = 'error';
            }
        }
        $calibres = $this->LoteEncabezados->LoteDetalles->Calibres->find('list', ['limit' => 200]);
        $folioDetalles = $this->LoteEncabezados->FolioDetalles->find('all', ['limit' => 200])
          ->select([
            'ids' => 'REPLACE((SELECT id AS [data()] FROM folio_detalles WHERE FolioDetalles.fecha_produccion = fecha_produccion AND FolioDetalles.especie_id = especie_id AND folio_encabezado_id = '.$folio.' ORDER BY fecha_produccion FOR xml path(\'\')), \' \', \',\')',
            'nro_folio' => 'FolioEncabezados.nro_folio',
            'especie_id' => 'FolioDetalles.especie_id',
            'especie' => 'Especies.nombre',
            'secuencial' => 'FolioDetalles.secuencial',
            'fecha_produccion' => 'FolioDetalles.fecha_produccion',
            'nave_id' => 'Mareas.nave_id',
            'nave_senal_distintiva' => 'Naves.senal_distintiva',
            'total_TON' => 'SUM(CASE WHEN FolioDetallesUnidades.unidad_id = \'1\' THEN FolioDetallesUnidades.cantidad ELSE 0 END)',
            'total_CJS' => 'SUM(CASE WHEN FolioDetallesUnidades.unidad_id = \'2\' THEN FolioDetallesUnidades.cantidad ELSE 0 END)'
          ])
          ->contain(['Especies', 'FolioEncabezados', 'DescargaDetalles.DescargaEncabezados.Recaladas.Mareas.Naves'])
          ->innerJoinWith('Unidades') // Usado para agregar unidades asociadas
          ->where(['FolioDetalles.folio_encabezado_id' => $folio])
          ->group([
            'FolioEncabezados.nro_folio',
            'FolioDetalles.especie_id',
            'FolioDetalles.fecha_produccion',
            'FolioDetalles.secuencial',
            'Especies.nombre',
            'Mareas.nave_id',
            'Naves.senal_distintiva'
          ]);

        $subcodigos = ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F'];
        $this->set(compact('loteEncabezado', 'folioDetalles', 'calibres', 'subcodigos', 'status'));
        $this->set('_serialize', ['loteEncabezado']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lote Encabezado id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loteEncabezado = $this->LoteEncabezados->get($id);
        if ($this->LoteEncabezados->delete($loteEncabezado)) {
          $status = 'success';
        } else {
          $status = 'error';
        }
        $this->set(compact('status'));
    }

    public function lock($id = null) {
        //$this->request->allowMethod(['post']);

        $loteEncabezado = $this->LoteEncabezados->get($id, ['contain' => [
            'LoteDetalles'
        ]]);

        $loteEncabezado->set('estado_id', '4');
        $this->LoteEncabezados->touch($loteEncabezado, 'Model.lock');
        if ($this->LoteEncabezados->save($loteEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('loteEncabezado', 'status'));
    }

    public function unlock($id = null) {
        //$this->request->allowMethod(['post']);

        $loteEncabezado = $this->LoteEncabezados->get($id);
        $loteEncabezado->set('estado_id', '3');
        if ($this->LoteEncabezados->save($loteEncabezado)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('loteEncabezado', 'status'));
        $this->render('lock');
    }
}
