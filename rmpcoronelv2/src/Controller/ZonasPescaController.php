<?php

namespace App\Controller;

use App\Controller\AppController;

class ZonasPescaController extends AppController {

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
        if (in_array($this->request->action, ['index', 'obtenerPorEspecie'])) {
            return true;
        }

        $tmp_permiso = false;
        switch ($this->request->action) {
            case 'add': $tmp_permiso = (bool) in_array('cuotas_zona_add', $this->Auth->user('privilegios')); break;
            case 'edit': $tmp_permiso = (bool) in_array('cuotas_zona_edit', $this->Auth->user('privilegios')); break;
            case 'delete': $tmp_permiso = (bool) in_array('cuotas_zona_delete', $this->Auth->user('privilegios')); break;
        }

        return $tmp_permiso || parent::isAuthorized($user);
    }

    public function index()
    {
        $zonas_pesca = $this->ZonasPesca->find('all', [
            'contain' => ['MacroZonas']
        ]);

        if (isset($this->request->query['estado'])) {
            $zonas_pesca = $zonas_pesca->where([
                'estado_id' => $this->request->query['estado']
            ]);
        }

        $this->set([
            'zonas_pesca' => $zonas_pesca,
            '_serialize' => ['zonas_pesca']
        ]);
    }

    public function add()
    {
      $status = 'success';
      $errors = Null;
      $zona_pesca = $this->ZonasPesca->newEntity();
      if ($this->request->is('post')) {
        $zona_pesca = $this->ZonasPesca->patchEntity($zona_pesca, $this->request->data);
        $zona_pesca->set('estado_id', '1');
        $zona_pesca->set('usuario_uid', $this->Auth->user('uid'));
        if ($this->ZonasPesca->save($zona_pesca)) {
          $zona_pesca = $this->ZonasPesca->get($zona_pesca->id);
          $status = 'success';
        } else {
            $errors = $zona_pesca->errors();
            $status = 'error';
        }
      }
      $this->set(compact('zona_pesca', 'status', 'errors'));
      $this->set('_serialize', ['zona_pesca', 'status', 'errors']);
    }

    public function edit($id = Null)
    {
        $status = 'success';
        $errors = Null;
        $zona_pesca = $this->ZonasPesca->get($id, [
            'contain' => ['MacroZonas']
        ]);

        $ids = [];
        foreach($zona_pesca->macro_zonas as $macro_zona) {
            $ids[] = $macro_zona->id;
        }
        $zona_pesca->macro_zonas_ids = implode(",", $ids);

        if ($this->request->is('post')) {
          $zona_pesca = $this->ZonasPesca->patchEntity($zona_pesca, $this->request->data);
          $zona_pesca->set('usuario_uid', $this->Auth->user('uid'));
          if ($this->ZonasPesca->save($zona_pesca)) {
            $zona_pesca = $this->ZonasPesca->get($zona_pesca->id);
            $status = 'success';
          } else {
              $errors = $zona_pesca->errors();
              $status = 'error';
          }
        }
        $this->set(compact('zona_pesca', 'status', 'errors'));
        $this->set('_serialize', ['zona_pesca', 'status', 'errors']);
    }

    public function delete($id = Null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $zona_pesca = $this->ZonasPesca->get($id, ['contain' => 'MacroZonas']);
        if(count($zona_pesca->macro_zonas) > 0) {
            $status = 'error';
        } else {
            if ($this->ZonasPesca->delete($zona_pesca)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('status'));
        //$this->set('_serialize', ['status']);
    }

    public function obtenerPorEspecie()
    {
      if ($this->request->query('especie')) {
        $especie_id = $this->request->query('especie');
        $especie = $this->loadModel('Especies')->get($especie_id);
        if (! $especie->ltp) {
          $zonas_pesca = $this->ZonasPesca->find('all')
          ->select(['ZonasPesca.nombre', 'ZonasPesca.id']);
        } else {
          $zonas_pesca = $this->ZonasPesca->find('all')
          ->select(['ZonasPesca.nombre', 'ZonasPesca.id'])
          ->matching('MacroZonas.Operaciones.Licencias', function($q) use ($especie_id) {
            return $q->where(['Licencias.especie_id' => $especie_id]);
          })
          ->group(['Licencias.id', 'ZonasPesca.id', 'ZonasPesca.nombre'])
          ->distinct();
        }
      } else {
        $zonas_pesca = null;
      }

      $this->set([
        'zonas_pesca' => $zonas_pesca,
        '_serialize' => ['zonas_pesca']
      ]);
    }
}

?>
