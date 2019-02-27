<?php
$this->layout = 'ajax';
?>
<div class="camiones view large-10 medium-9 columns">
    <h2><?= h($camione->patente) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Patente') ?></h6>
            <p><?= h($camione->patente) ?></p>
            <h6 class="subheader"><?= __('Transporte') ?></h6>
            <p><?= $camione->has('transporte') ? $this->Html->link($camione->transporte->id, ['controller' => 'Transportes', 'action' => 'view', $camione->transporte->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tipo Camion') ?></h6>
            <p><?= h($camione->tipo_camion) ?></p>
        </div>
    </div>
</div>
