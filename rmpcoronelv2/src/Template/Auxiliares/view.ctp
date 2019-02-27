<?php
$this->layout = 'ajax';
?>
<div class="auxiliares view large-10 medium-9 columns">
    <h2><?= h($auxiliar->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Rut') ?></h6>
            <p><?= h($auxiliar->rut) ?></p>
            <h6 class="subheader"><?= __('Verificador') ?></h6>
            <p><?= h($auxiliar->verificador) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($auxiliar->nombre) ?></p>
            <h6 class="subheader"><?= __('Domicilio') ?></h6>
            <p><?= h($auxiliar->domicilio) ?></p>
            <h6 class="subheader"><?= __('Ciudad') ?></h6>
            <p><?= $auxiliar->has('ciudad') ? $this->Html->link($auxiliar->ciudad->id, ['controller' => 'Ciudades', 'action' => 'view', $auxiliar->ciudad->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($auxiliar->id) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($auxiliar->estado) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Chofer') ?></h6>
            <?= $this->Text->autoParagraph(h($auxiliar->chofer)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Armador') ?></h6>
            <?= $this->Text->autoParagraph(h($auxiliar->armador)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Encargado Planta') ?></h6>
            <?= $this->Text->autoParagraph(h($auxiliar->encargado_planta)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Capitan') ?></h6>
            <?= $this->Text->autoParagraph(h($auxiliar->capitan)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Destinatario') ?></h6>
            <?= $this->Text->autoParagraph(h($auxiliar->destinatario)); ?>

        </div>
    </div>
</div>
