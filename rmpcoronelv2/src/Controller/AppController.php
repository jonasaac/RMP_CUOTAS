<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    protected $userPermisos = Array();
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
            'Ldap' => [
              'userModel' => 'Usuarios',
              'fields' => [
                'username' => 'username',
                'password' => 'password'
              ]
            ],
            ],
            'loginAction' => [
              'controller' => 'Usuarios',
              'action' => 'login'
            ],
            'loginRedirect' => [
              'controller' => 'Home',
              'action' => 'index'
            ],
            'logoutRedirect' => [
              'controller' => 'Usuarios',
              'action' => 'login'
            ],
            'authorize' => ['Controller']
            ]);
    }

    public function beforeFilter(Event $event)
    {
        I18n::locale('es-CL');

        // Se redirecciona con a login si no se ha iniciado session
        if( !$this->request->session()->check('Auth.User.uid') && $this->request->action != 'login' && $this->request->action != 'getGrupo' ){
            $this->Flash->error('Debe iniciar sesión.');
            //return $this->redirect(['controller' => 'Usuarios', 'action' => 'login']);
        }

        if ($this->Auth->user()) {
            $this->set('current_user', $this->Auth->user());
        }
    }

    /**
     * Metodo utilizado para verificar si un usuario está autorizado a acceder
     * a un modulo o no
     *
     * @param string|null $user con el nombre del usuario a consultar
     * @return bool true si está autorizado false en otro caso.
     **/
    public function isAuthorized($user = null)
    {
      // El usuario "admin" tiene acceso a todo
      if ($user['uid'] == "admin") {
        return true;
      }

      // Cualquier tipo de usuario esta autorizado para ver el modulo de Inicio
      if ($this->request->controller == 'Home')
          return true;

      return false;
    }

    /**
     * XXX: NO USADO
     * Metodo protegido para obtener los recursos a los que tiene acceso
     * un usuario
     * @param $user string con el nombre del usuario
     *
     * @return arreglo con objetos de los recursos a los que tiene acceso el
     * usuario con el nombre $user
     */
    protected function _getRecursos($user = null) {
        $division = 1;
        $recursosIds = [1,2,3];

        /*foreach ($user['privilegios'][$division] as $id_res => $priv) {
            $recursosIds[] = $id_res;
        }*/

        $recursos = $this->loadModel('Recursos')->find('list')->where([
            'id IN' => $recursosIds,
            'estado_id' => '1'
          ]);

        return $recursos;
    }

    /**
     * XXX: NO USADO
     **/
    protected function _getModulos($user = null) {
        $division = 1;

        $modulos = [];

        if ( isset($user['privilegios'][$division]) ) {
            foreach ($user['privilegios'][$division] as $resId => $priv) {
                foreach ($priv as $p) {
                    switch( split('_', $p)[0] ) {
                        case 'marea':
                        case 'recalada':
                        case 'descarga':
                        $pp = 'marea'; break;
                        case 'guia':
                        $pp = 'guia'; break;
                        case 'calidad':
                        $pp = 'calidad'; break;
                    }
                    if ( isset($pp) && (!isset($modulos[$pp]) || !in_array($resId, $modulos[$pp])) )
                        $modulos[$pp][] = $resId;
                }
            }
        }

            return $modulos;
        }
    }
