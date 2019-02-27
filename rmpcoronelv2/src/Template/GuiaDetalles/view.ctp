<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Guia Detalle'), ['action' => 'edit', $guiaDetalle->guia_encabezado_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Guia Detalle'), ['action' => 'delete', $guiaDetalle->guia_encabezado_id], ['confirm' => __('Are you sure you want to delete # {0}?', $guiaDetalle->guia_encabezado_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Guia Detalles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Guia Detalle'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Guia Encabezados'), ['controller' => 'GuiaEncabezados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Guia Encabezado'), ['controller' => 'GuiaEncabezados', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Especies'), ['controller' => 'Especies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Especy'), ['controller' => 'Especies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Unidades'), ['controller' => 'Unidades', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unidade'), ['controller' => 'Unidades', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="guiaDetalles view large-10 medium-9 columns">
    <h2><?= h($guiaDetalle->guia_encabezado_id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Guia Encabezado') ?></h6>
            <p><?= $guiaDetalle->has('guia_encabezado') ? $this->Html->link($guiaDetalle->guia_encabezado->id, ['controller' => 'GuiaEncabezados', 'action' => 'view', $guiaDetalle->guia_encabezado->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Especy') ?></h6>
            <p><?= $guiaDetalle->has('especy') ? $this->Html->link($guiaDetalle->especy->id, ['controller' => 'Especies', 'action' => 'view', $guiaDetalle->especy->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Unidade') ?></h6>
            <p><?= $guiaDetalle->has('unidade') ? $this->Html->link($guiaDetalle->unidade->id, ['controller' => 'Unidades', 'action' => 'view', $guiaDetalle->unidade->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Nro Linea') ?></h6>
            <p><?= $this->Number->format($guiaDetalle->nro_linea) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($guiaDetalle->cantidad) ?></p>
            <h6 class="subheader"><?= __('Precio') ?></h6>
            <p><?= $this->Number->format($guiaDetalle->precio) ?></p>
        </div>
    </div>
</div>
