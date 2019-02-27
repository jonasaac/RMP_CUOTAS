<?php
namespace App\Controller;
use App\Controller\AppController;

class TiposLicenciaController extends AppController {
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $tipos_licencia = $this->TiposLicencia->find('list');

        $this->set([
            'tipos_licencia' => $tipos_licencia,
            '_serialize' => ['tipos_licencia']
        ]);
    }
} ?>
