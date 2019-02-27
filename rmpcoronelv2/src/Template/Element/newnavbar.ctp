<?php
/** Nuevo diseño de navbar
Este consiste en un breadcrumb que muestra donde esta navegando
actualmente el usuario
**/
?>
<div class="page-breadcrumbs" id="navbar-rmp">
    <ul class="breadcrumb">
        <?= $this->Html->getCrumbList([
            'firstClass' => false,
            'lastClass' => 'active',
            'class' => 'breadcrumb',
            'escape' => false,
        ], '<i class="fa fa-home"></i> '.__('Home')) ?>
    </ul>
    <ul class="nav navbar-nav pull-right">
      <li>
        <a href="#">
          <i class="glyphicon glyphicon-user"></i>
          <span> <?= $current_user['nombre'] ?></span>
        </a>
      </li>
      <li>
        <?= $this->Html->link('<i class="glyphicon glyphicon-log-out"></i><span> '.__('Log out').'</span>', ['controller' => 'Usuarios', 'action' => 'logout'], ['escape' => false])?>
      </li>
    </ul>
</div>
