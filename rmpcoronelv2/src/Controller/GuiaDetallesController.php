<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GuiaDetalles Controller
 *
 * @property \App\Model\Table\GuiaDetallesTable $GuiaDetalles
 */
class GuiaDetallesController extends AppController
{
    public function isAuthorized($user = null)
    {
        switch ($this->request->action) {
            case 'add': return (bool)array_in_array(['rmp_guia_add', 'rmp_guia_edit'], $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($recursoId)
    {
        $recurso = $this->loadModel('Recursos')->get($recursoId, [
          'contain' => ['UnidadesPrincipales']
        ]);

        $this->set(compact('recurso'));
    }
}
