<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FolioDetalles Controller
 *
 * @property \App\Model\Table\FolioDetallesTable $FolioDetalles
 */
class FolioDetallesController extends AppController
{
  /**
   * Metodo isAuthorized, usado para comprobar los permisos de los usuarios en
   * este controlador
   *
   * @return boolean True si está autorizado
   */
  public function isAuthorized($user = null)
  {
      switch ($this->request->action) {
          case 'add': return (bool)array_in_array(['produccion_folio_add', 'produccion_folio_edit'], $this->Auth->user('privilegios')); break;
      }
      return parent::isAuthorized($user);
  }

    /**
     * Metodo Add, usado para manipular la creación y edición de los detalles de
     * los Folios
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // NOTE: Codigo temporal
        $recursoId = 2; // XXX: Solo langostinos por ahora
        $recurso = $this->loadModel('Recursos')->get($recursoId, [
          'contain' => ['UnidadesPrincipales']
        ]);
        //$calibres = $this->FolioDetalles->Calibres->find('list');
        $this->set(compact('recurso'));
    }
}
