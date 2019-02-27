<nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-rmp">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div style="height: 20px; padding-top:2px;">
                <?= $this->Html->link('Inicio', ['controller' => 'Rmp', 'action' => 'index']) ?>
            </div>
    </div>
    <div class="collapse navbar-collapse" id="navbar-rmp">
        <ul class="nav navbar-nav">
            <?php
            // MAREAS
            if (isset($modulos['marea'])) {
                if (!empty($recursos) and $recursos->count() > 1) {
                    echo '<li class="dropdown">'.
                     '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mareas <span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu">';
                    foreach ($recursos as $id => $recurso) {
                        $params = !in_array($id, $modulos['marea']) ? ['onclick' => 'return false'] : [];
                        echo '<li'.(!in_array($id, $modulos['marea']) ? ' class="disabled"' : '').'>'.
                         $this->html->link($recurso, [
                             'controller' => 'Rmp',
                             'action' => 'updateRecurso',
                             $id,
                             $recurso,
                             'rlink' => $this->Url->build(['controller' => 'Mareas', 'action' => 'index']),
                         ], $params).
                         '</li>';
                    }
                    echo '</ul></li>';
                } else {
                    echo '<li>'.
                     $this->html->link('Mareas', [
                         'controller' => 'Mareas',
                         'action' => 'index',
                     ]).
                     '</li>';
                }
            }
            ?>
            <?php
            // GUIAS
            if (isset($modulos['guia'])) {
                if (!empty($recursos) and $recursos->count() > 1) {
                    echo '<li class="dropdown">'.
                     '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Guias <span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu">';
                    foreach ($recursos as $id => $recurso) {
                        $params = !in_array($id, $modulos['guia']) ? ['onclick' => 'return false'] : [];
                        echo '<li'.(!in_array($id, $modulos['guia']) ? ' class="disabled"' : '').'>'.
                         $this->html->link($recurso, [
                             'controller' => 'Rmp',
                             'action' => 'updateRecurso',
                             $id,
                             $recurso,
                             'rlink' => $this->Url->build(['controller' => 'Guias', 'action' => 'index']),
                         ], $params).
                         '</li>';
                    }
                    echo '</ul></li>';
                } else {
                    echo '<li>'.
                     $this->html->link('Guias', [
                         'controller' => 'Guias',
                         'action' => 'index',
                     ]).
                     '</li>';
                }
            }
            ?>
            <?php
            // FOLIOS
            /*if (!empty($recursos) and $recursos->count() > 1) {
                echo '<li class="dropdown">'.
                     '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Folios <span class="caret"></span></a>';
                echo '<ul class="dropdown-menu">';
                foreach ($recursos as $id => $recurso) {
                    echo '<li>'.
                         $this->html->link($recurso, [
                             'controller' => 'Rmp',
                             'action' => 'updateRecurso',
                             $id,
                             $recurso,
                             'rlink' => $this->Url->build(['controller' => 'Folios', 'action' => 'index'])
                         ]).
                         '</li>';
                }
                echo '</ul></li>';
            } else {
                echo '<li>'.
                     $this->html->link('Folios', [
                         'controller' => 'Folios',
                         'action' => 'index'
                     ]).
                     '</li>';
            }*/
            ?>
            <?php
            // CONTROL DE CALIDAD
            if (isset($modulos['calidad'])) {
                if (!empty($recursos) and $recursos->count() > 1) {
                    echo '<li class="dropdown">'.
                     '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Control de Calidad <span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu">';
                    foreach ($recursos as $id => $recurso) {
                        $params = !in_array($id, $modulos['calidad']) ? ['onclick' => 'return false'] : [];
                        echo '<li'.(!in_array($id, $modulos['calidad']) ? ' class="disabled"' : '').'>'.
                         $this->html->link($recurso, [
                             'controller' => 'Rmp',
                             'action' => 'updateRecurso',
                             $id,
                             $recurso,
                             'rlink' => $this->Url->build(['controller' => 'ControlesCalidad', 'action' => 'index']),
                         ], $params).
                         '</li>';
                    }
                    echo '</ul></li>';
                } else {
                    echo '<li>'.
                     $this->html->link('Calidad', [
                         'controller' => 'ControlesCalidad',
                         'action' => 'index',
                     ]).
                     '</li>';
                }
            }
            ?>
            <?php if (array_in_array(['admin'], $userPermisos)): ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mantenedores <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link('Usuarios', ['controller' => 'Usuarios', 'action' => 'index'])?></li>
                    <li class="divider"></li>
                    <li><?= $this->Html->link('Tratamientos', ['controller' => 'Tratamientos', 'action' => 'index'])?></li>
                    <li class="divider"></li>
                    <li><?= $this->Html->link('Naves', ['controller' => 'Naves', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Transportes', ['controller' => 'Transportes', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Camiones', ['controller' => 'Camiones', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Auxiliares', ['controller' => 'Auxiliares', 'action' => 'index']) ?></li>
                    <li class="divider"></li>
                    <li><?= $this->Html->link('Plantas', ['controller' => 'Plantas', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Puertos', ['controller' => 'Puertos', 'action' => 'index']) ?></li>
                    <!-- <li><?= $this->Html->link('Divisiones', ['controller' => 'Divisiones', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Recursos', ['controller' => 'Recursos', 'action' => 'index']) ?></li>-->
                    <li><?= $this->Html->link('Ciudades', ['controller' => 'Ciudades', 'action' => 'index']) ?></li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
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
    </div>
</nav>
