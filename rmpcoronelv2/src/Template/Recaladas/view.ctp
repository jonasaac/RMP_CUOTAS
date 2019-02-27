<?php
$this->layout = 'ajax';
?>
<div class="recaladas view large-10 medium-9 columns">
    <h2><?= h($recalada->fecha) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Marea') ?></h6>
            <p><?= $recalada->has('marea') ? $this->Html->link($recalada->marea->id, ['controller' => 'Mareas', 'action' => 'view', $recalada->marea->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Pontone') ?></h6>
            <p><?= $recalada->has('pontone') ? $this->Html->link($recalada->pontone->id, ['controller' => 'Pontones', 'action' => 'view', $recalada->pontone->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Nro Recalada') ?></h6>
            <p><?= $this->Number->format($recalada->nro_recalada) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($recalada->fecha) ?></p>
        </div>
    </div>
</div>
