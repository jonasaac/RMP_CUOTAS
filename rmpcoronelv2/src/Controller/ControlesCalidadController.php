<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * ControlesCalidad Controller.
 *
 * @property \App\Model\Table\ControlesCalidadTable $ControlesCalidad
 */
class ControlesCalidadController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $this->request->session()->write('recurso.id', 1);
        $this->request->session()->write('recurso.nombre', 'SARDINA');
        parent::beforeFilter($event);
    }

    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['index', 'listar'])) {
            return true;
        }

        $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool) in_array('calidad_artesanal_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('calidad_artesanal_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool) in_array('calidad_artesanal_delete', $this->Auth->user('privilegios')); break;
        }
        return $tmp_permiso || parent::isAuthorized($user);
    }
    /**
     * Index method.
     */
    public function index()
    {
      $recursoId = 1; // Sólo Sardinas por ahora
      $guiasFirstDate = $this->loadModel('GuiaEncabezados')->find('all')
         ->select('fecha_salida')
         ->where(['GuiaEncabezados.recurso_id' => $recursoId])
         ->order(['fecha_salida ASC']);

      if( $guiasFirstDate->isEmpty() )
          $firstYear = date('Y');
      else
          $firstYear = $guiasFirstDate->first()->toArray()['fecha_salida']->format('Y');

      $years = range(date('Y'), $firstYear);
      $years = array_combine($years, $years);
      $recursos = $this->loadModel('Recursos')->find('list')
         ->where(['Recursos.id' => $recursoId]);

      $this->set(compact('years', 'recursos'));
      $this->set('_serialize', ['years', 'divisions']);
    }

    public function listar($year = null, $estado = 'SIN CALIDAD')
    {
      $recursosIds = [1]; // TODO: obtener los ids de los recursos a los que puede acceder un usuario
      // XXX: Solo Sardinas

      // Se determina el orden que deben tener los datos
      $orderColumnId = $this->request->data('order.0.column');
      $orderColumnName = $this->request->data('columns.'.$orderColumnId.'.name');

        if ($estado == 'SIN CALIDAD') {
          $nombre_tabla = 'GuiasSinCalidad';
            $guias = $this->loadModel('GuiasSinCalidad')->find('all')
              ->contain(['OrigenRecintos',
                         'DestinoRecintos',
                         'Camiones' => function ($q) {
                           return $q->select(['id', 'patente']);
                         },
                         'GuiaDetalles' => function ($q) {
                           return $q->select(['id', 'guia_encabezado_id', 'descarga_detalle_id']);
                         },
                         'GuiaDetalles.DescargaDetalles' => function ($q) {
                           return $q->select(['id', 'descarga_encabezado_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados' => function ($q) {
                           return $q->select(['id', 'recalada_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas' => function ($q) {
                           return $q->select(['id', 'marea_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas' => function ($q) {
                           return $q->select(['id', 'nave_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas.Naves' => function ($q) {
                           return $q->select(['Naves.id', 'Naves.nombre']);
                         },
                       ])
              ->where(['GuiasSinCalidad.recurso_id IN' => $recursosIds])
              ->innerJoinWith('GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas');
            // TODO: Falta filtrar solo artesanales
        } else {
          $nombre_tabla = 'GuiasConCalidad';
            $guias = $this->loadModel('GuiasConCalidad')->find('all')
              ->contain(['ControlesCalidad',
                         'OrigenRecintos',
                         'DestinoRecintos',
                         'Camiones' => function ($q) {
                           return $q->select(['id', 'patente']);
                         },
                         'GuiaDetalles' => function ($q) {
                           return $q->select(['id', 'guia_encabezado_id', 'descarga_detalle_id']);
                         },
                         'GuiaDetalles.DescargaDetalles' => function ($q) {
                           return $q->select(['id', 'descarga_encabezado_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados' => function ($q) {
                           return $q->select(['id', 'recalada_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas' => function ($q) {
                           return $q->select(['id', 'marea_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas' => function ($q) {
                           return $q->select(['id', 'nave_id']);
                         },
                         'GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas.Naves' => function ($q) {
                           return $q->select(['Naves.id', 'Naves.nombre']);
                         },
                       ])
              ->where(['GuiasConCalidad.recurso_id IN' => $recursosIds])
              ->innerJoinWith('GuiaDetalles.DescargaDetalles.DescargaEncabezados.Recaladas.Mareas');
            // TODO: Falta filtrar solo artesanales
        }

        //$guias->offset($this->request->data('start'))
        //      ->limit($this->request->data('length'));

        if ($year) {
          $guias = $guias->where(function ($exp, $q) use ($year) {
            $ym = $q->func()->year([
              'fecha_recepcion' => 'literal',
            ]);

            return $exp->eq($ym, $year);
          });
        }

        $totaldata = $guias->count();

        $searchString = $this->request->data('search.value');
        if ( !empty($searchString) ) {
          $array_search = explode(' ', $searchString);

          $guias_array = [];
          foreach ($array_search AS $searchWord) {
              if (empty($searchWord))
                continue;
            $tmp_guias = $guias->cleanCopy();

            $tmp_naves = $this->loadModel('Naves')->find()
              ->select(['id'])
              ->where(['Naves.nombre LIKE' => '%'.$searchWord.'%']);

            $tmp_guias->where([
              'OR' => [
                // IDs
                'CAST('.$nombre_tabla.'.id AS VARCHAR) LIKE'    => '%'.$searchWord.'%',
                // NroGuias
                'CAST('.$nombre_tabla.'.nro_guia AS VARCHAR) LIKE'    => '%'.$searchWord.'%',
                // Origen
                'OrigenRecintos.nombre LIKE'       => '%'.$searchWord.'%',
                // Destino
                'DestinoRecintos.nombre LIKE'       => '%'.$searchWord.'%',
                // Fecha
                'dbo.ConvertirFecha('.$nombre_tabla.'.fecha_salida) LIKE' => '%'.$searchWord.'%',
                // Fecha
                'dbo.ConvertirFecha('.$nombre_tabla.'.fecha_recepcion) LIKE' => '%'.$searchWord.'%',
                // Camiones
                'Camiones.patente LIKE'              => '%'.$searchWord.'%',
                // Nave
                'Mareas.nave_id IN' => $tmp_naves,
              ]
            ]);
          }

          $tmp_guias_array = $tmp_guias->toArray();

          if (empty($guias_array)) {
            $guias_array = $tmp_guias_array;
          } else {
            $guias_array = array_uintersect($tmp_guias_array, $guias_array, "comparacion_ids");
          }
        } else {
          $guias_array = $guias->toArray();
        }

        $totalfiltered = count($guias_array);
        // Se limitan los elementos obtenidos por la consulta
        $guias_array = array_slice($guias_array, $this->request->data('start'), $this->request->data('length'));

        $this->set([
          'guias' => $guias_array,
          'draw'          => $this->request->data('draw'),
          'totaldata'     => $totaldata,
          'totalfiltered' => $totalfiltered,
          '_serialize' => ['guias']
        ]);
    }

    /**
     * Add method.
     */
    public function add()
    {
        $status = 'success';
        $controlesCalidad = $this->ControlesCalidad->newEntity();
        if ($this->request->is('post')) {
            $controlesCalidad = $this->ControlesCalidad->patchEntity($controlesCalidad, $this->request->data);
            $controlesCalidad->set('estado_id', 3);
            $controlesCalidad->set('usuario_uid', $this->Auth->user('uid'));
            if ($this->ControlesCalidad->save($controlesCalidad)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $guiaEncabezados = $this->ControlesCalidad->GuiaEncabezados->find('list', ['limit' => 200]);
        $tratamientos = $this->ControlesCalidad->Tratamientos->find('list', ['limit' => 200]);
        $this->set(compact('status', 'controlesCalidad', 'guiaEncabezados', 'tratamientos'));
        $this->set('_serialize', ['controlesCalidad']);
    }

    /**
     * Edit method.
     *
     * @param string|null $id Controles Calidad id.
     *
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $controlesCalidad = $this->ControlesCalidad->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $controlesCalidad = $this->ControlesCalidad->patchEntity($controlesCalidad, $this->request->data);
            $controlesCalidad->set('usuario_uid', $this->Auth->user('uid'));
            if ($this->ControlesCalidad->save($controlesCalidad)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $guiaEncabezados = $this->ControlesCalidad->GuiaEncabezados->find('list', ['limit' => 200]);
        $tratamientos = $this->ControlesCalidad->Tratamientos->find('list', ['limit' => 200]);
        $this->set(compact('status', 'controlesCalidad', 'guiaEncabezados', 'tratamientos'));
        $this->set('_serialize', ['controlesCalidad']);
    }

    /**
     * Delete method.
     *
     * @param string|null $id Controles Calidad id.
     *
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $controlesCalidad = $this->ControlesCalidad->get($id);
        if ($this->ControlesCalidad->delete($controlesCalidad)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
