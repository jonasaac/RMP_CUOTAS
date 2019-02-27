<?php
$this->layout = 'ajax';
?>
<div class="plantas view large-10 medium-9 columns">
    <h2><?= h($planta->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Seccion') ?></h6>
            <p><?= h($planta->seccion) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($planta->nombre) ?></p>
            <h6 class="subheader"><?= __('Auxiliare') ?></h6>
            <p><?= $planta->has('auxiliare') ? $this->Html->link($planta->auxiliare->id, ['controller' => 'Auxiliares', 'action' => 'view', $planta->auxiliare->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($planta->id) ?></p>
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= $this->Number->format($planta->codigo) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($planta->estado) ?></p>
        </div>
    </div>
</div>
