<?php
namespace App\Controller;

use Cake\Core\Configure;

class HomeController extends AppController
{

  /**
   * Metodo utilizado para verificar si un usuario está autorizado a acceder
   * a un modulo o no
   *
   * @param string|null $user con el nombre del usuario a consultar
   * @return bool true si está autorizado false en otro caso.
   **/
  public function isAuthorized($user = null)
  {
    if (in_array($this->request->action, ['index'])) {
      return true;
    }
    return parent::isAuthorized($user);
  }

  public function index()
  {
    $modulos = [];
    foreach($this->Auth->user('privilegios') as $priv) {
        $p_explode = explode('_', $priv);
        if (!in_array($p_explode[0], $modulos))
          $modulos[] = $p_explode[0];
        if (!in_array($p_explode[1], $modulos))
          $modulos[] = $p_explode[1];
    }

    $recursos_list = $this->loadModel('Recursos')->find('all');
    $rmp_version = Configure::read('rmp_version');
    $changelog = $this->Auth->user('change_log');
    $this->set(compact('recursos_list', 'rmp_version', 'changelog', 'modulos'));
  }

  public function RmpUpdateRecurso ($modulo, $id)
  {
    $this->autorender = false;
    $this->request->session()->write('recurso.id', $id);
    $this->request->session()->write('recurso.nombre', $this->loadModel('Recursos')->get($id)->nombre);

    switch ($modulo) {
      case '1':
      $this->redirect(['controller' => 'Mareas', 'action' => 'index']);
      break;
      case '2':
      $this->redirect(['controller' => 'Guias', 'action' => 'index']);
      break;
      case '3':
      $this->redirect(['controller' => 'Folios', 'action' => 'index']);
      break;
      case '4':
      $this->redirect(['controller' => 'ControlesCalidad', 'action' => 'index']);
      break;
      // Agregue yo
      case '5':
      $this->redirect(['controller' => 'Cuotas', 'action' => 'index']);
      //fin
      default:
      $this->redirect(['action' => 'index']);
      break;
    }
  }
}
?>
