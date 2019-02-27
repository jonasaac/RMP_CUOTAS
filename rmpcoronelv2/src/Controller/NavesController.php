<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Number;

/**
 * Naves Controller
 *
 * @property \App\Model\Table\NavesTable $Naves
 */
class NavesController extends AppController
{
  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('RequestHandler');
  }
  /**
   * Metodo utilizado para verificar si un usuario está autorizado a acceder
   * a un modulo o no
   *
   * @param string|null $user con el nombre del usuario a consultar
   * @return bool true si está autorizado false en otro caso.
   **/
  public function isAuthorized($user = null) {
    // Privilegios por acción
    $tmp_permiso = false;
    switch ($this->request->action) {
        case 'listar_filtrado':
          $tmp_permiso = true; break;
        case 'index':
        case 'listar':
        $search = 'admin_nave';
        $matches = array_filter($this->Auth->user('privilegios'), function ($var) use ($search) {
          return preg_match("/$search/i", $var);
        });
        $tmp_permiso = (bool)$matches;
        break;
        case 'add': $tmp_permiso = (bool)in_array('admin_nave_add', $this->Auth->user('privilegios')); break;
        case 'edit': $tmp_permiso = (bool)in_array('admin_nave_edit', $this->Auth->user('privilegios')); break;
        case 'delete': $tmp_permiso = (bool)in_array('admin_nave_delete', $this->Auth->user('privilegios')); break;
    }

    return $tmp_permiso || parent::isAuthorized($user);
  }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

    public function listar_filtrado()
    {
      $recursosIds = $this->Auth->user('recursos_ids');
      $areasIds = $this->Auth->user('areas_ids');

      $reducer = function ($output, $value) {
        if(!array_key_exists($value->id, $output)) {
          $value->recursos_ids = $value->recursos_ids;
          $output[$value->id] = $value;
        }
        return $output;
      };

      $naves = $this->Naves->find('all')
          //->contain(['Recursos'])
          ->select(['id', 'Naves.nombre', 'Naves.capitan_id'])
          ->innerJoinWith('Recursos', function ($q) use ($recursosIds) {
              return $q->where(['Recursos.id IN' => $recursosIds]);
          })
          ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          })
          ->order(['Naves.nombre' => 'ASC']);

      if ($this->request->query('q')) {
        $q = $this->request->query('q');
        $naves = $naves->where([
          'Naves.nombre LIKE' => '%'.$q.'%'
        ]);
      }

      $naves = $naves->reduce($reducer, []);

      if ($this->request->query('page')) {
        $page = $this->request->query('page');
        $naves = array_slice($naves, 30 * $page, 30);
      }
        $this->set([
          'naves' => $naves,
          '_serialize' => ['naves']
        ]);
    }

    public function listar($estado = 'ACTIVO')
    {
        $naves = $this->Naves->find('all', [
            'contain' => [
              'Estados',
              'Armadores' => function($q) {
                return $q->select([
                  'id', 'nombre',
                  'apellido_paterno', 'apellido_materno',
                  'nombre_razon_social', 'tipo_entidad',
                ]);
              },
              'Representantes' => function($q) {
                return $q->select([
                  'id', 'nombre',
                  'apellido_paterno', 'apellido_materno',
                  'nombre_razon_social', 'tipo_entidad',
                ]);
              },
              'Unidades', 'Bodegas']
        ])
        ->where(['Estados.nombre' => $estado]);

        $recursos = $this->request->query('recursos') === 'true'?true:false;
        if ($recursos) {
            $naves = $naves->map(function ($nave) {
                $nave['recursos_list'] = $nave->recursos_list;
                return $nave;
            });
        }

        $this->set([
            'naves' => $naves,
            '_serialize' => ['naves'],
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
        $nave = $this->Naves->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['division_id'] = 1;
            if ( $this->request->data['regimen_id'] == 2 ) {
                unset($this->request->data['bodegas']);
                unset($this->request->data['unidades']);
                $this->request->data['senal_distintiva'] = $this->request->data['senal_tipo'].'-'.$this->request->data['senal_nro'];
            }
            $nave = $this->Naves->patchEntity($nave, $this->request->data);
            $nave->set('division_id', '1');
            if ($this->Naves->save($nave)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $recursos = $this->Naves->Recursos->find('list');
        $areas = $this->Naves->Areas->find('list');
        $capitanes = $this->Naves->Capitanes->find('list');
        $capitanes = $capitanes->toArray();
        asort($capitanes, SORT_STRING);
        $representantes = $this->Naves->Representantes->find('list');
        $representantes = $representantes->toArray();
        asort($representantes, SORT_STRING);
        $armadores = $this->Naves->Armadores->find('list');
        $armadores = $armadores->toArray();
        asort($armadores, SORT_STRING);
        $sindicatos = $this->Naves->Sindicatos->find('list');
        $sindicatos = $sindicatos->toArray();
        asort($sindicatos, SORT_STRING);
        $zonaOperaciones = $this->Naves->ZonaOperaciones->find('list');
        $zonaOperaciones = $zonaOperaciones->toArray();
        asort($zonaOperaciones, SORT_STRING);
        $this->set('unidades', $this->Naves->Unidades->find('list'));
        $this->set('regimenes', $this->Naves->Regimenes->find('list'));
        $this->set(compact('nave', 'areas', 'status', 'capitanes', 'zonaOperaciones', 'recursos', 'armadores', 'representantes', 'sindicatos'));
        $this->set('_serialize', ['nave', 'status']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nave id.
     * @return void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $nave = $this->Naves->get($id, [
            'contain' => ['Unidades', 'Bodegas', 'Areas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ( $this->request->data['regimen_id'] == 2 ) {
                unset($this->request->data['bodegas']);
                unset($this->request->data['unidades']);
            }
            $this->request->data['senal_distintiva'] = $this->request->data['senal_tipo'].'-'.$this->request->data['senal_nro'];
            $nave = $this->Naves->patchEntity($nave, $this->request->data, ['associated' => ['Unidades._joinData', 'Bodegas', 'Recursos', 'Areas._ids']]);
            if ($this->Naves->save($nave)) {
                if ($nave->regimen_id != '2') {
                    $bodegasIds = [];
                    foreach($nave->bodegas as $b) {
                        $bodegasIds[] = $b->id;
                    }

                    $bodegas = $this->Naves->Bodegas->find('all')->where(['nave_id' => $nave->id, 'id NOT IN' => $bodegasIds]);
                    foreach ($bodegas as $bodega)
                        $this->Naves->Bodegas->delete($bodega);
                }
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $recursos = $this->Naves->Recursos->find('list');
        $areas = $this->Naves->Areas->find('list');
        $estados = $this->Naves->Estados->find('list');
        $unidades = $this->Naves->Unidades->find('list');
        $bodegas = $this->Naves->Bodegas->find('list');
        $regimenes = $this->Naves->Regimenes->find('list');
        $capitanes = $this->Naves->Capitanes->find('list');
        $capitanes = $capitanes->toArray();
        asort($capitanes, SORT_STRING);
        $armadores = $this->Naves->Armadores->find('list');
        $armadores = $armadores->toArray();
        asort($armadores, SORT_STRING);
        $representantes = $this->Naves->Representantes->find('list');
        $representantes = $representantes->toArray();
        asort($representantes, SORT_STRING);
        $sindicatos = $this->Naves->Sindicatos->find('list');
        $sindicatos = $sindicatos->toArray();
        asort($sindicatos, SORT_STRING);
        $zonaOperaciones = $this->Naves->ZonaOperaciones->find('list');
        $zonaOperaciones = $zonaOperaciones->toArray();
        asort($zonaOperaciones, SORT_STRING);
        $this->set(compact('status', 'nave', 'areas', 'armadores', 'representantes', 'unidades', 'bodegas', 'regimenes', 'estados', 'capitanes', 'zonaOperaciones', 'recursos', 'sindicatos'));
        $this->set('_serialize', ['nave', 'status']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nave id.
     * @return void Redirects to index.
     */
    public function delete($id = null)
    {
        $status = 'success';
        //$this->request->allowMethod(['post', 'delete']);
        $nave = $this->Naves->get($id);
        if ($this->Naves->delete($nave)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('status'));
    }
}
