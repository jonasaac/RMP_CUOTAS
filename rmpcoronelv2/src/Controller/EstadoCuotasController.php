<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * Estado Cuotas Controller
 */
class EstadoCuotasController extends AppController
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
        return true;
        /*if (in_array($this->request->action, ['index', 'listar']))
            return true;

        switch ($this->request->action) {
            case 'add': return (bool)in_array('admin_especie_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('admin_especie_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('admin_especie_delete', $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);*/
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
      $operacionesYear = $this->loadModel('Operaciones')
      ->find('all')
      ->select('fecha_operacion')
      ->order(['fecha_operacion ASC']);

      if ($operacionesYear->count() == 0) {
          $firstYear = date('Y');
      } else {
          $firstYear = $operacionesYear->first()->toArray()['fecha_operacion']->format('Y');
      }

      $years = range(date('Y'), $firstYear);

      $especies = $this->loadModel('Operaciones')->find('all', [
        'contain' => ['Licencias', 'Licencias.Especies'],
        'group' => ['Especies.id', 'Especies.nombre']
      ])
      ->select(['Especies.id', 'Especies.nombre']);

      $this->set([
        'years' => $years,
        'especies' => $especies
      ]);

    }

    public function totales_por_mes()
    {
      $totales_captura = $this->loadModel('TotalesCapturaEspecieMes')->find('all');

      if ($this->request->query('year')) {
        $totales_captura = $totales_captura
        ->where(['año' => $this->request->query('year')]);
      }
      if ($this->request->query('mes')) {
        $totales_captura = $totales_captura
        ->where(['mes' => $this->request->query('mes')]);
      }
      if ($this->request->query('especie')) {
        $totales_captura = $totales_captura
        ->where(['especie_id' => $this->request->query('especie')]);
      }

      $this->set([
        'totales_captura' => $totales_captura,
        '_serialize' => ['totales_captura']
      ]);
    }
}
?>
