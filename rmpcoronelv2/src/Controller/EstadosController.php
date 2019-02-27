<?php
namespace App\Controller;

use App\Controller\AppController;

class EstadosController extends AppController {

    public function initialize()
    {
            parent::initialize();
            $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $estados = $this->Estados->find('list');

        if (isset($this->request->query['paridad'])) {
            $estados = $estados->where(['Estados.paridad' => $this->request->query['paridad']]);
        }

        $this->set([
            'estados' => $estados,
            '_serialize' => ['estados']
        ]);
    }
}
?>
