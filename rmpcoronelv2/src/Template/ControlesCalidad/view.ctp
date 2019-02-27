<?php
$this->layout = 'ajax';
?>
<div class="controlesCalidad view large-10 medium-9 columns">
    <h2><?= h($controlesCalidad->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Guia Encabezado') ?></h6>
            <p><?= $controlesCalidad->has('guia_encabezado') ? $this->Html->link($controlesCalidad->guia_encabezado->nro_guia, ['controller' => 'GuiaEncabezados', 'action' => 'view', $controlesCalidad->guia_encabezado->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tratamiento') ?></h6>
            <p><?= $controlesCalidad->has('tratamiento') ? $this->Html->link($controlesCalidad->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $controlesCalidad->tratamiento->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->id) ?></p>
            <h6 class="subheader"><?= __('Tvn') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->tvn) ?></p>
            <h6 class="subheader"><?= __('Agua') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->agua) ?></p>
            <h6 class="subheader"><?= __('Ph') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->ph) ?></p>
            <h6 class="subheader"><?= __('C') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->c) ?></p>
            <h6 class="subheader"><?= __('N Litro') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->n_litro) ?></p>
            <h6 class="subheader"><?= __('Talla') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->talla) ?></p>
            <h6 class="subheader"><?= __('Peso') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->peso) ?></p>
            <h6 class="subheader"><?= __('Moda') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->moda) ?></p>
            <h6 class="subheader"><?= __('Cms') ?></h6>
            <p><?= $this->Number->format($controlesCalidad->cms) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Observaciones') ?></h6>
            <?= $this->Text->autoParagraph(h($controlesCalidad->observaciones)) ?>
        </div>
    </div>
</div>
