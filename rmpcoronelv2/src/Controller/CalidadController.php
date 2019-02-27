<?php
namespace App\Controller;

use App\Controller\AppController;

class CalidadController extends AppController
{
    public function index()
    {
        $this->set('_serialize', ['years', 'divisions']);
    }
}
?>
