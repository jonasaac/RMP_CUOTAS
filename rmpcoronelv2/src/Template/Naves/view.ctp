<?php
$this->layout = 'ajax';
?>
<div class="naves view large-10 medium-9 columns">
    <h2><?= h($nave->matricula) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Matricula') ?></h6>
            <p><?= h($nave->matricula) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($nave->nombre) ?></p>
            <h6 class="subheader"><?= __('Abreviatura') ?></h6>
            <p><?= h($nave->abreviatura) ?></p>
            <h6 class="subheader"><?= __('Armador') ?></h6>
            <p><?= $nave->has('armador') ? $this->Html->link($nave->armador->nombre, ['controller' => 'Auxiliares', 'action' => 'view', $nave->armador->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Representante') ?></h6>
            <p><?= $nave->has('representante') ? $this->Html->link($nave->representante->nombre, ['controller' => 'Auxiliares', 'action' => 'view', $nave->representante->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Capacidad') ?></h6>
            <p><ul>
            <?php
                foreach ($nave->unidades as $unidad){
                    echo '<li>'.
                         $unidad->_joinData->capacidad.
                         ' '.
                         $unidad->abreviacion.
                         '</li>';
                }
            ?>
            </ul></p>
            <h6 class="subheader"><?= __('Bodegas') ?></h6>
            <p><ul>
            <?php
                foreach ($nave->bodegas as $bodega){
                    echo '<li>'.
                         $bodega->nro.
                         ' '.
                         $bodega->capacidad.
                         '</li>';
                }
            ?>
            </ul></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= __($nave->estado->estado) ?></p>
        </div>
    </div>
</div>
