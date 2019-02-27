<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $guiaDetalle->guia_encabezado_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $guiaDetalle->guia_encabezado_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Guia Detalles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Guia Encabezados'), ['controller' => 'GuiaEncabezados', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Guia Encabezado'), ['controller' => 'GuiaEncabezados', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Especies'), ['controller' => 'Especies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Especy'), ['controller' => 'Especies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unidades'), ['controller' => 'Unidades', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unidade'), ['controller' => 'Unidades', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="guiaDetalles form large-10 medium-9 columns">
    <?= $this->Form->create($guiaDetalle) ?>
    <fieldset>
        <legend><?= __('Edit Guia Detalle') ?></legend>
        <?php
            echo $this->Form->input('especie_id', ['options' => $especies, 'empty' => true]);
            echo $this->Form->input('unidad_id', ['options' => $unidades, 'empty' => true]);
            echo $this->Form->input('cantidad');
            echo $this->Form->input('precio');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
