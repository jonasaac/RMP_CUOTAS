<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Form\LoginForm;
use Cake\Event\Event;
use Cake\Core\Configure;
/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 */
class UsuariosController extends AppController
{

    public function beforeFilter(Event $event)
    {
      $this->Auth->allow('getGrupo');

      parent::beforeFilter($event);
    }

    /**
     * Metodo utilizado para verificar si un usuario está autorizado a acceder
     * a un modulo o no
     *
     * @param string|null $user con el nombre del usuario a consultar
     * @return bool true si está autorizado false en otro caso.
     **/
    public function isAuthorized($user = null) {
      // Cualquier usuario está autorizado para acceder al logout del sistema
      if (in_array($this->request->action, ['logout', 'getGrupo']))
      return true;
      // solo los usuarios logeados están autorizados a mantener la conexión viva
      if (!empty($this->Auth->user()) && in_array($this->request->action, ['keepAlive'])) {
        return true;
      }
      // Privilegios por acción
      $tmp_permiso = false;
      switch ($this->request->action) {
          case 'index':
          case 'listar':
          $search = 'admin_usuario';
          $matches = array_filter($this->Auth->user('privilegios'), function ($var) use ($search) {
            return preg_match("/$search/i", $var);
          });
          $tmp_permiso = (bool)$matches;
          break;
          case 'add': $tmp_permiso = (bool)in_array('admin_usuario_add', $this->Auth->user('privilegios')); break;
          case 'edit': $tmp_permiso = (bool)in_array('admin_usuario_edit', $this->Auth->user('privilegios')); break;
          case 'delete': $tmp_permiso = (bool)in_array('admin_usuario_delete', $this->Auth->user('privilegios')); break;
      }

      return $tmp_permiso || parent::isAuthorized($user);
    }

    /** Metodo utilizado para mantener una conexión abierta mientras el usuario
     * esta inactivo en el sistema
     **/
    public function keepAlive()
    {
      $this->viewBuilder()->layout('ajax');
      $this->render(false);
      echo json_encode(['data' => true]);
    }

    public function getGrupo($username)
    {
      $this->viewBuilder()->layout('ajax');
      $this->render(false);
      $usuario = $this->Usuarios->find()
          ->where(['Usuarios.uid' => $username])
          ->contain(['Grupos'])
          ->toArray();
      if (count($usuario) > 0) {
        echo $usuario[0]->grupos[0]->id;
      } else {
        echo '';
      }
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {}

    public function listar($estado = 'ACTIVO')
    {
        $usuarios = $this->Usuarios->find('all')->contain(['Estados'])->where(['Estados.nombre' => $estado]);

        $this->set([
            'usuarios' => $usuarios,
            '_serialize' => ['usuarios'],
        ]);
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add()
    {
        $status = 'success';
        $grupos = $this->Usuarios->Grupos->find('list');

        $usuario = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            $usuario->set('change_log', 1);
            if ($this->Usuarios->save($usuario)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $grupos = $this->Usuarios->Grupos->find('list');
        $this->set(compact('usuario', 'status', 'grupos'));
        $this->set('_serialize', ['usuario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Usuario id.
     * @return void
     */
    public function edit($id = null)
    {
        $status = 'success';
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Grupos', 'Estados']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            if ($this->Usuarios->save($usuario)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $estados = $this->Usuarios->Estados->find('list');
        $grupos = $this->Usuarios->Grupos->find('list');
        $this->set(compact('usuario', 'usuario', 'grupos', 'estados', 'status'));
        $this->set('_serialize', ['usuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Usuario id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
        if ($this->Usuarios->delete($usuario)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }

    /**
     * Metodo de login, utilizado para manejar el acceso de usuarios al sistema
     *
     * @return void
     **/
    public function login()
    {
        if ($this->request->session()->check('Auth.User.uid')) {
            $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }

        $login = new LoginForm();
        if ($this->request->is('post')) {
            $usuario = $this->Auth->identify();
            if ($usuario) {
                $this->Auth->setUser($usuario);
                $this->Flash->success('Ingreso correcto.');
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('No cuenta con los permisos necesarios.');
        }

        $rmp_version = Configure::read('rmp_version');

        $grupos = $this->loadModel('Grupos')->find('list');
        $this->set('grupos', $grupos);
        $this->set('login', $login);
        $this->set('rmp_version', $rmp_version);
    }

    /**
     * Metodo de logout, utilizado para manejar la salida de usuarios
     * del sistema
     *
     * @return void
     **/
    public function logout()
    {
        $this->request->session()->destroy();
        $this->Flash->success('Sesión finalizada.');
        return $this->redirect($this->Auth->logout());
    }
}
