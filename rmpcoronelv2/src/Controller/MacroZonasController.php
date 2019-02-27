<?php

namespace App\Controller;

use App\Controller\AppController;

class MacroZonasController extends AppController {

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
        if (in_array($this->request->action, ['index', 'obtenerPorNombre', 'obtenerPorEspecie'])) {
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
        $macro_zonas = $this->MacroZonas->find('all', [
            'contain' => ['ZonasPesca']
        ]);

        if (isset($this->request->query['estado'])) {
            $macro_zonas = $macro_zonas->where([
                'estado_id' => $this->request->query['estado']
            ]);
        }

        // Cuando se realiza una busqueda a traves de un Select2
        if ($this->request->query('q')) {
            $q = $this->request->query('q');
            $values = explode(' ', strtoupper($q));
            foreach ($values as $value) {
                $macro_zonas = $macro_zonas->where([
                    'OR' => [
                        'MacroZonas.nombre LIKE' => "%{$value}%",
                    ]
                ]);
            }
        }

        $this->set([
            'macro_zonas' => $macro_zonas,
            '_serialize' => ['macro_zonas']
        ]);
    }

    public function obtenerPorNombre()
    {
      if ($this->request->query('nombre')) {
        $macro_zona = $this->MacroZonas->find('all')
        ->where([
          'nombre' => $this->request->query('nombre')
        ])
        ->first();
      } else {
        $macro_zona = null;
      }

      $this->set([
        'macro_zona' => $macro_zona,
        '_serialize' => ['macro_zona']
      ]);
    }

    public function obtenerPorEspecie()
    {
      if ($this->request->query('especie')) {
        $especie_id = $this->request->query('especie');
        $macro_zonas = $this->MacroZonas->find('all')
        ->select(['MacroZonas.nombre', 'MacroZonas.id'])
        ->matching('Operaciones.Licencias', function($q) use ($especie_id) {
          return $q->where(['Licencias.especie_id' => $especie_id]);
        })
        ->group(['Licencias.id', 'MacroZonas.id', 'MacroZonas.nombre']);
      } else {
        $macro_zonas = null;
      }

      $this->set([
        'macro_zonas' => $macro_zonas,
        '_serialize' => ['macro_zonas']
      ]);
    }

    public function add()
    {
      $status = 'success';
      $errors = Null;
      $macro_zona = $this->MacroZonas->newEntity();
      if ($this->request->is('post')) {
        $macro_zona = $this->MacroZonas->patchEntity($macro_zona, $this->request->data);
        $macro_zona->set('estado_id', '1');
        $macro_zona->set('usuario_uid', $this->Auth->user('uid'));
        if ($this->MacroZonas->save($macro_zona)) {
          $status = 'success';
        } else {
            $errors = $macro_zona->errors();
            $status = 'error';
        }
      }
      $this->set(compact('macro_zona', 'status', 'errors'));
      $this->set('_serialize', ['macro_zona', 'status', 'errors']);
    }

    public function edit($id = Null)
    {
        $status = 'success';
        $errors = Null;
        $macro_zona = $this->MacroZonas->get($id, [
            'contain' => ['ZonasPesca']
        ]);

        $ids = [];
        foreach($macro_zona->zonas_pesca as $zona_pesca) {
            $ids[] = $zona_pesca->id;
        }
        $macro_zona->zonas_pesca_ids = implode(",", $ids);

        if ($this->request->is('post')) {
          $macro_zona = $this->MacroZonas->patchEntity($macro_zona, $this->request->data);
          $macro_zona->set('usuario_uid', $this->Auth->user('uid'));
          if ($this->MacroZonas->save($macro_zona)) {
            $macro_zona = $this->MacroZonas->get($macro_zona->id);
            $status = 'success';
          } else {
              $errors = $macro_zona->errors();
              $status = 'error';
          }
        }
        $this->set(compact('macro_zona', 'status', 'errors'));
        $this->set('_serialize', ['macro_zona', 'status', 'errors']);
    }

    public function delete($id = Null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $macro_zona = $this->MacroZonas->get($id, ['contain' => 'ZonasPesca']);
        if(count($macro_zona->zonas_pesca) > 0) {
            $status = 'error';
        } else {
            if ($this->MacroZonas->delete($macro_zona)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('status'));
        //$this->set('_serialize', ['status']);
    }
}
?>
