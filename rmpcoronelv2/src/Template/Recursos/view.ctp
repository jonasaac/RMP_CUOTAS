<?php
$this->layout = 'ajax';
?>

<div class="recursos view large-10 medium-9 columns">
    <h2><?= h($recurso->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($recurso->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($recurso->id) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($recurso->estado) ?></p>
        </div>
    </div>
</div>
