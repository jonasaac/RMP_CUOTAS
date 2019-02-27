<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\LoginForm;

class LoginController extends AppController
{
    /**
     * Index metod
     * Encargado de verificar si el usuario está logeado o no
     * @return void
     */
    public function index()
    {
        if ($this->request->session()->check('username')) {
            $this->redirect(['controller' => 'Rmp', 'action' => 'index']);
        }

        $login = new LoginForm();

        if ($this->request->is('post')) {
            $username = $this->request->data['username'];
            $permisos = [];

            $user = $this->loadModel('Usuarios')
                         ->find()
                         ->where(['uid' => $username, 'estado' => '1'])
                         ->contain(['Grupos', 'Grupos.Permisos', 'Grupos.Permisos.Privilegios'])
                         ->first();

            if (!empty($user)) {
                $grupos = $user->grupos;
                if(!empty($grupos)) {
                    $divisones = [];
                    $procesos = [];
                    $permisos = [];
                    foreach ($grupos as $grupo) {
                        if ($grupo->permiso) {
                            $division = $grupo->permiso['division_id'];
                            $proceso = $grupo->permiso['proceso_id'];
                            $divisiones[] = $division;
                            $procesos[] = $proceso;
                            foreach($grupo->permiso->privilegios as $privilegio) {
                                $permisos[$division][$proceso][] = $privilegio->nombre;
                            }
                        }
                    }
                }
            }

            if (empty($divisiones) or empty($procesos) or empty($permisos)) {
                $this->Flash->error('No cuenta con los permisos necesarios.');
            } else {
                $divisiones = $this->loadModel('Divisiones')->find('all', [
                    'conditions' => ['Divisiones.id IN' => $divisiones,
                                     'estado' => '1']
                ]);
                $procesos = $this->loadModel('Procesos')->find('all', [
                    'conditions' => ['Procesos.id IN' => $procesos,
                                     'estado' => '1']
                ]);
                if($divisiones->count() == 1) {
                    $this->request->session()->write('division.id', $divisiones->first()->id);
                    $this->request->session()->write('division.nombre', $divisiones->first()->nombre);
                }
                if($procesos->count() == 1) {
                    $this->request->session()->write('proceso.id', $procesos->first()->id);
                    $this->request->session()->write('proceso.nombre', $procesos->first()->nombre);
                }
                $this->request->session()->write('divisiones', $divisiones->toArray());
                $this->request->session()->write('procesos', $procesos->toArray());
                $this->request->session()->write('username', $username);
                $this->request->session()->write('permisos', $permisos);
                $this->redirect(['controller' => 'Rmp', 'action' => 'index']);
                $this->Flash->success('Ingreso correcto.');
            }
        }
        $this->set('login', $login);
    }

    public function logout()
    {
        $this->autorender = false;
        $this->request->session()->destroy();
        $this->Flash->success('Sesión finalizada.');
        $this->redirect(['action' => 'index']);
    }
}
?>
