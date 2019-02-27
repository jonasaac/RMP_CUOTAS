<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\AuxiliarForm;

/**
 * Auxiliares Controller
 *
 * @property \App\Model\Table\AuxiliaresTable $Auxiliares
 */
class AuxiliaresController extends AppController
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
        if (in_array($this->request->action, ['index', 'listar', 'checkRut', 'listar_filtrado']))
            return true;

        switch ($this->request->action) {
            case 'add': return (bool)in_array('admin_auxiliar_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('admin_auxiliar_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('admin_auxiliar_delete', $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

    public function listar($function = null, $estado = 'ACTIVO') {
        $this->loadComponent('RequestHandler');

        $auxiliares = $this->Auxiliares->find('all', [
            'contain' => ['Ciudades', 'Estados']
        ])->where(['Estados.nombre' => $estado]);

        if ($function && $function != 'ALL')
        $auxiliares = $auxiliares->where([$function => '1']);

        /** procesamiento para select **/
        if ($this->request->is('ajax')) {
            if ($this->request->query('licencia')) {
              $tipo_licencia = $this->request->query('licencia');
              if ($tipo_licencia == '4') {  // Para los RAE solo trae sindicatos
                $auxiliares = $auxiliares->where([
                    'Auxiliares.sindicato' => '1',
                ]);
              } else {
                $auxiliares = $auxiliares->where([
                  'Auxiliares.titular_licencia' => '1'
                ]);
              }
            }

            if ($this->request->query('q')) {
                $q = $this->request->query('q');
                $values = explode(' ', strtoupper($q));
                foreach ($values as $value) {
                    $auxiliares = $auxiliares->where([
                        'OR' => [
                            'Auxiliares.nombre LIKE' => '%'.$value.'%',
                            'Auxiliares.apellido_paterno LIKE' => '%'.$value.'%',
                            'Auxiliares.apellido_materno LIKE' => '%'.$value.'%',
                            'Auxiliares.nombre_razon_social LIKE' => '%'.$value.'%',
                        ]
                    ]);
                }
            }

            if ($this->request->query('retornarFunciones')) {
              $auxiliares = $auxiliares->map(function($auxiliar) {
                $auxiliar['funciones'] = $auxiliar->funciones;
                return $auxiliar;
              });
            }
        }

        $this->set([
            'auxiliares' => $auxiliares,
            '_serialize' => ['auxiliares'],
        ]);
    }

    public function checkRut($rut = null) {
        $this->render(false);  // Esta accion no se renderiza desde la vista
        $rut = $this->request->data('rut');
        $response = !$this->Auxiliares->exists(['rut' => $rut]);
        echo json_encode($response); // Se imprime true || false
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($funcion = null)
    {
        $status = 'success';
        $auxiliar = $this->Auxiliares->newEntity();
        if ($funcion)
            $auxiliar->set($funcion, '1');
        if ($this->request->is('post')) {
            $this->request->data['division_id'] = 1;
            $auxiliar = $this->Auxiliares->patchEntity($auxiliar, $this->request->data);
            if ($this->Auxiliares->save($auxiliar)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $ciudades = $this->Auxiliares->Ciudades->find('list')
            ->order(['Ciudades.nombre' => 'ASC']);
        $funciones = [
            'chofer' => ' Chofer',
            'armador' => ' Armador',
            'encargado_planta' => ' Encargado de Planta',
            'capitan' => ' Capitán',
            'destinatario' => ' Destinatario',
            'representante' => ' Representante',
            'transporte' => 'Empresa Transporte',
            'tcs' => 'Titular Contrato Suministro',
            'titular_licencia' => 'Titular Licencia',
            'sindicato' => 'Sindicato',
        ];
        asort($funciones);  // ordena los nombres alfabeticamente
        $areas = $this->Auxiliares->Areas->find('list');
        $errors = $auxiliar->errors();
        $this->set(compact('auxiliar', 'ciudades', 'funciones', 'status', 'areas'));
        $this->set('_serialize', ['auxiliar', 'status', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Auxiliare id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $auxiliar = $this->Auxiliares->get($id, [
            'contain' => ['Areas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auxiliar = $this->Auxiliares->patchEntity($auxiliar, $this->request->data);
            if ($this->Auxiliares->save($auxiliar)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $ciudades = $this->Auxiliares->Ciudades->find('list')
            ->order(['Ciudades.nombre' => 'ASC']);
        $estados = $this->Auxiliares->Estados->find('list');
        $funciones = [
            'armador' => ' Armador',
            'chofer' => ' Chofer',
            'encargado_planta' => ' Encargado de Planta',
            'capitan' => ' Capitán',
            'destinatario' => ' Destinatario',
            'representante' => ' Representante',
            'transporte' => 'Empresa Transporte',
            'tcs' => 'Titular Contrato Suministro',
            'titular_licencia' => 'Titular Licencia',
            'sindicato' => 'Sindicato',
        ];
        asort($funciones);  // ordena los nombres alfabeticamente
        $areas = $this->Auxiliares->Areas->find('list')
            ->order(['Areas.nombre' => 'ASC']);;
        $errors = $auxiliar->errors();
        $this->set(compact('auxiliar', 'status', 'ciudades', 'funciones', 'estados', 'areas'));
        $this->set('_serialize', ['auxiliar', 'status', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Auxiliar id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $status = 'success';
        $this->request->allowMethod(['post', 'delete']);
        $auxiliar = $this->Auxiliares->get($id);
        if ($this->Auxiliares->delete($auxiliar)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact(['status']));
    }

    public function listar_filtrado()
    {
      $recursosIds = $this->Auth->user('recursos_ids');
      $areasIds = $this->Auth->user('areas_ids');

      $reducer = function ($output, $value) {
        if(!array_key_exists($value->id, $output)) {
          $output[$value->id] = $value;
        }
        return $output;
      };

      $auxiliares = $this->Auxiliares->find('list')
          ->innerJoinWith('Areas', function ($q) use ($areasIds) {
            return $q->where(['Areas.id IN' => $areasIds]);
          });

      if ($this->request->query('funcion')) {
        $funcion = $this->request->query('funcion');
        $auxiliares = $auxiliares->where([
          'Auxiliares.'.$funcion => '1'
        ]);
      }

      if ($this->request->query('q')) {
        $q = $this->request->query('q');
        $auxiliares = $auxiliares->where([
            'OR' => [
                'Auxiliares.nombre LIKE' => '%'.$q.'%',
                'Auxiliares.apellido_paterno LIKE' => '%'.$q.'%',
                'Auxiliares.apellido_materno LIKE' => '%'.$q.'%',
                'Auxiliares.nombre_razon_social LIKE' => '%'.$q.'%',
            ]
        ]);
      }

      $auxiliares = $auxiliares->toArray();

      if ($this->request->query('page')) {
        $page = $this->request->query('page');
        $auxiliares = array_slice($auxiliares, 30 * $page, 30);
      }

      $this->set([
        'auxiliares' => $auxiliares,
        '_serialize' => ['auxiliares']
      ]);
    }
}
