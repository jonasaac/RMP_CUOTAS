<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\CacheSession;

class LoginForm extends Form
{
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('username', 'string');
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->notEmpty('username', 'Debe ingresar su nombre de usuario');
    }

    protected function _execute(array $data, $request = null)
    {
        $username = $data['username'];
        $permisos = [];

        $user = TableRegistry::get('Usuarios')->find()->where(['uid' => $username, 'estado' => '1'])->contain(['Grupos', 'Grupos.Permisos', 'Grupos.Permisos.Privilegios'])->first();

        if(empty($user))
            return false;
        $grupos = $user->grupos;
        if(empty($grupos))
            return false;

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

        if (empty($divisiones) or empty($procesos) or empty($permisos))
            return false;

        $divisiones = TableRegistry::get('Divisiones')->find('all', [
            'conditions' => ['Divisiones.id IN' => $divisiones]
        ]);
        $procesos = TableRegistry::get('Procesos')->find('all', [
            'conditions' => ['Procesos.id IN' => $procesos]
        ]);

        if($divisiones->count() == 1) {
            debug($divisiones->first());
//            $request->session()->write('division.id', array_keys($divisiones)[0]);
//            CacheSession::write('division.nombre', array_values($divisionesLst)[0]);
        }
        debug($procesos->count());

//        $this->request->session()->write('divisiones', $divisiones);
//        $this->request->session()->write('procesos', $procesos);
//        $this->request->session()->write('username', $username);
//        $divisiones = $this->loadModel('Divisiones')->find('list')->toArray();
//        $procesos = $this->loadModel('Procesos')->find('list', ['limit' => 200])->toArray();

/*        if (count($divisionesLst) == 1) {
            $this->request->session()->write('division.id', array_keys($divisionesLst)[0]);
            $this->request->session()->write('division.nombre', array_values($divisionesLst)[0]);
        }
        if (count($procesosLst) == 1) {
            $this->request->session()->write('proceso.id', array_keys($procesosLst)[0]);
            $this->request->session()->write('proceso.nombre', array_values($procesosLst)[0]);
        }

        debug($divisionesLst);
        debug($procesosLst);*/

        return false;
    }
}
?>
