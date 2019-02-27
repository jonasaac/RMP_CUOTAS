<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>RMP Coronel | <?= $this->fetch('title') ?></title>

        <?= $this->Html->css('bootstrap.min.css') ?>
        <?= $this->Html->css('animate.css') ?>
        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('font-awesome.css') ?>
        <?= $this->Html->css('plugins/iCheck/blue.css') ?>
        <?= $this->Html->css('plugins/toastr/toastr.min.css') ?>
        <?= $this->Html->css('plugins/jasny/jasny-bootstrap.min.css') ?>
        <?= $this->fetch('css') ?>
    </head>

<body class="top-navigation">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="/" class="navbar-brand">
                    <i class="icon-element medium camanchaca-icon"></i>
                </a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <?php if(count($this->request->session()->read('divisiones')) == 1): ?>
                        <?= $this->Html->tag('li', $this->Html->link($this->request->session()->read('division.nombre'), ['controller' => 'Rmp', 'action' => 'index']), ['class' => 'active']) ?>
                    <?php else: ?>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->request->session()->check('division') ? $this->request->session()->read('division.nombre') : 'División';?><span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <?php
                            foreach ($this->request->session()->read('divisiones') as $division):
                            echo $this->Html->tag('li', $this->Html->link($division->nombre, ['controller' => 'Rmp', 'action' => 'updateDivision', $division->id, $division->nombre]));
                            endforeach;
                            ?>

                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if ($this->request->session()->check('division.id')): ?>
                    <?php if(count($this->request->session()->read('procesos')) == 1): ?>
                        <?= $this->Html->tag('li', $this->Html->tag('a', $this->request->session()->read('proceso.nombre')), ['class' => 'active']) ?>
                    <?php else: ?>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->request->session()->check('proceso') ? $this->request->session()->read('proceso.nombre') : 'Proceso';?><span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <?php
                            foreach ($this->request->session()->read('procesos') as $proceso):
                            if(isset($this->request->session()->read('permisos')[$this->request->session()->read('division.id')][$proceso->id]))
                            echo $this->Html->tag('li', $this->Html->link($proceso->nombre, ['controller' => 'Rmp', 'action' => 'updateProceso', $proceso->id, $proceso->nombre]));
                            endforeach;
                            ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($this->request->session()->check('division') and $this->request->session()->check('proceso')): ?>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> Mareas <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <?= $this->Html->link('Registrar Marea', ['controller' => 'Mareas', 'action' => 'add']) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('Ver Mareas', ['controller' => 'Mareas', 'action' => 'index']) ?>
                            </li>
                            <li><a href="#">Registrar Recalada</a></li>
                            <li><a href="#">Registrar Descarga</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> Folios <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Registrar Folio</a></li>
                            <li><a href="#">Registrar Lote</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <?= $this->Html->link('<i class="fa fa-sign-out"></i>'.__('Log out'), ['controller' => 'Usuarios', 'action' => 'logout'], ['escape' => false])?>
                    </li>
                </ul>
            </div>
        </nav>
        </div>
        <?= $this->fetch('breadcrumb') ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
        <div class="footer">
            <div>
                <strong><a href="http://www.irbits.cl">Irbits</a></strong> 2015
            </div>
        </div>

        </div>
        </div>


        <!-- Mainly scripts -->
        <?= $this->Html->script('jquery-2.1.1.js') ?>
        <?= $this->Html->script('bootstrap.min.js') ?>
        <?= $this->Html->script('inspinia.js') ?>
        <?= $this->Html->script('plugins/pace/pace.min.js') ?>
        <?= $this->Html->script('plugins/toastr/toastr.min.js') ?>
        <?= $this->Html->script('plugins/jasny/jasny-bootstrap.min.js') ?>
        <?= $this->Html->script('plugins/iCheck/icheck.min.js') ?>
        <?= $this->fetch('script') ?>
        <?= $this->Html->scriptStart() ?>
        $(document).ready(function () {
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
          });
          <?= $this->fetch('jquery') ?>
        });
        <?= $this->Html->scriptEnd() ?>
</body>
</html>
