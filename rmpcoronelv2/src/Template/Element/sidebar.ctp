<?php
$this->Html->templates([
    'link' => '<a href="{{url}}"><i {{attrs}}></i><span class="menu-text"> {{content}} </span></a>',
    'mailto' => '<a href="{{url}}"><span class="menu-text"> {{content}} </span></a>',
]);
?>
<div class="page-sidebar menu-compact" id="sidebar">
    <!-- Sidebar Menu -->
    <ul class="nav sidebar-menu">
        <!--Home-->
        <li>
            <?= $this->Html->link(__('Home'), ['controller' => 'Usuarios', 'action' => 'login'], ['class' => 'menu-icon glyphicon glyphicon-home']) ?>
        </li>
        <!--Divisiones-->
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon glyphicon glyphicon-tasks"></i>
                <span class="menu-text"> Divisiones </span>
                <i class="menu-expand"></i>
            </a>

            <ul class="submenu">
                <li>
                    <a href="elements.html">
                        <span class="menu-text">Camanchaca Pesca Sur</span>
                    </a>
                </li>
                <li>
                    <a href="elements.html">
                        <span class="menu-text">Camanchaca Pesca Norte</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--Recursos-->
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon glyphicon glyphicon-tasks"></i>
                <span class="menu-text"> Recursos </span>
                <i class="menu-expand"></i>
            </a>

            <ul class="submenu">
                <li>
                    <a href="elements.html">
                        <span class="menu-text">Jurel</span>
                    </a>
                </li>
                <li>
                    <a href="elements.html">
                        <span class="menu-text">Langostino</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--Mareas-->
        <li>
            <?= $this->Html->link('Mareas', ['controller' => 'Mareas', 'action' => 'index'], ['class' => 'menu-icon fa fa-ship'])?>
        </li>
        <!--Produccion-->
        <li>
            <?= $this->Html->link('Folios', ['controller' => 'Folios', 'action' => 'index'], ['class' => 'menu-icon glyphicon glyphicon-barcode'])?>
        </li>
        <!--Control de Calidad-->
        <li>
            <?= $this->Html->link('Control de Calidad', ['controller' => 'Calidad', 'action' => 'index'], ['class' => 'menu-icon fa fa-line-chart'])?>
        </li>
        <!--Mantenedores-->
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon glyphicon glyphicon-tasks"></i>
                <span class="menu-text"> Mantención </span>
                <i class="menu-expand"></i>
            </a>

            <ul class="submenu">
                <li>
                    <a href="elements.html">
                        <span class="menu-text">Basic Elements</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <span class="menu-text">
                            Icons
                        </span>
                        <i class="menu-expand"></i>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="font-awesome.html">
                                <i class="menu-icon fa fa-rocket"></i>
                                <span class="menu-text">Font Awesome</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="glyph-icons.html">
                                            <i class="menu-icon glyphicon glyphicon-stats"></i>
                                            <span class="menu-text">Glyph Icons</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="typicon.html">
                                            <i class="menu-icon typcn typcn-location-outline"></i>
                                            <span class="menu-text"> Typicons</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="weather-icons.html">
                                            <i class="menu-icon wi wi-hot"></i>
                                            <span class="menu-text">Weather Icons</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="tabs.html">
                                    <span class="menu-text">Tabs & Accordions</span>
                                </a>
                            </li>
                            <li>
                                <a href="alerts.html">
                                    <span class="menu-text">Alerts & Tooltips</span>
                                </a>
                            </li>
                            <li>
                                <a href="modals.html">
                                    <span class="menu-text">Modals & Wells</span>
                                </a>
                            </li>
                            <li>
                                <a href="buttons.html">
                                    <span class="menu-text">Buttons</span>
                                </a>
                            </li>
                            <li>
                                <a href="nestable-list.html">
                                    <span class="menu-text"> Nestable List</span>
                                </a>
                            </li>
                            <li>
                                <a href="treeview.html">
                                    <span class="menu-text">Treeview</span>
                                </a>
                            </li>
                        </ul>
        </li>
    </ul>
    <!-- /Sidebar Menu -->
</div>
