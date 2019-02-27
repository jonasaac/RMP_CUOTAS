<?php
namespace App\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class LdapAuthenticate extends BaseAuthenticate
{
    public function authenticate(Request $request, Response $response)
    {
      // Usuarios personalizados para test y administración principal
      if ($request->data['username'] == "admin" && $request->data['password'] == Configure::read('admin_pass')) {
        return $this->loadUser('admin', $request->data['grupo_id']);
      }/* else if ($request->data['username'] == "daniel") {
        return $this->loadUser('daniel', $request->data['grupo_id']);
      }*/

      $adServer = "ldap://dc03.camanchaca.intranet"; // se conecta al servidor MS Directory correspondiente
      $ldapConnection = @ldap_connect($adServer);

      ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
      ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
      if (!$ldapConnection) {
        debug($ldapConnection);
        throw new CakeException("No se pudo conectar al servidor LDAP");
      }

      $username = $request->data['username'];
      $password = $request->data['password'];
      $grupo_id = $request->data['grupo_id'];
      $usuario = null;

      $bind = @ldap_bind($ldapConnection, 'CAMANCHACA_STGO\\'.$username, $password);
      if ($bind) {
        $usuario = $this->loadUser($username, $grupo_id);
        @ldap_close($ldapConnection);
        return $usuario;
      } else {
        return false;
      }
    }

    protected function loadUser($username, $grupo_id) {
        $usuario = TableRegistry::get('Usuarios')->find()
             ->where([
                 'uid' => $username,
                 'Usuarios.estado_id' => '1'
             ])
             ->contain(['Grupos.Areas', 'Grupos.Privilegios'])
             ->innerJoinWith('Grupos', function ($q) use ($grupo_id) {
               return $q->where(['Grupos.id' => $grupo_id]);
             });
             //->contain(['Grupos', 'Grupos.Privilegios', 'Grupos.Areas']);

        // Si no se encuentra el usuario se retorna un error
        if ($usuario->count() == 0) {
            return false;
        }

        $usuario = $usuario->first();
        $usuario = $usuario->toArray();
        // se obtiene el grupo que ha sido seleccionado en el login
        $usuario['grupo_id'] = $grupo_id; // Se guarda el grupo con el que se logeo el usuario
        $grupo_selected = array_values(array_filter($usuario['grupos'], function($item) use ($grupo_id) {
          return (bool)($item['id'] == $grupo_id);
        }))[0];
        $usuario['grupo'] = $grupo_selected;
        unset($usuario['grupos']); // se borra toda la información de grupos que no será utilizada

        $privilegios = [];
        foreach ($usuario['grupo']['privilegios'] as $privilegio) {
            /*if(!isset($privilegios[$usuario['grupo']['division_id']]))
                $privilegios[$usuario['grupo']['division_id']] = [];*/
            if(!in_array($privilegio['nombre'], $privilegios))
                $privilegios[] = $privilegio['nombre'];
        }

        $usuario['privilegios'] = $privilegios;

        // Se obtienen los recursos a los que tiene acceso el usuario
        $areas_ids = array_reduce($grupo_selected['areas'], function ($output, $item) {
          $output[] = $item['id'];
          return $output;
        }, []);

        $recursos_ids = array_keys(TableRegistry::get('Recursos')->find('list')
            ->innerJoinWith('Areas', function ($q) use ($areas_ids) {
              return $q->where(['Areas.id IN' => $areas_ids]);
            })->toArray());
        $usuario['areas_ids'] = $areas_ids;
        $usuario['recursos_ids'] = $recursos_ids;

        return $usuario;
    }
}
?>
