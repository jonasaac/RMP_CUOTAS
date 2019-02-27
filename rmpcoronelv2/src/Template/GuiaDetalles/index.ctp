<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Guia Detalle'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Guia Encabezados'), ['controller' => 'GuiaEncabezados', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Guia Encabezado'), ['controller' => 'GuiaEncabezados', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Especies'), ['controller' => 'Especies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Especy'), ['controller' => 'Especies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unidades'), ['controller' => 'Unidades', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unidade'), ['controller' => 'Unidades', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="guiaDetalles index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('guia_encabezado_id') ?></th>
            <th><?= $this->Paginator->sort('nro_linea') ?></th>
            <th><?= $this->Paginator->sort('especie_id') ?></th>
            <th><?= $this->Paginator->sort('unidad_id') ?></th>
            <th><?= $this->Paginator->sort('cantidad') ?></th>
            <th><?= $this->Paginator->sort('precio') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($guiaDetalles as $guiaDetalle): ?>
        <tr>
            <td>
                <?= $guiaDetalle->has('guia_encabezado') ? $this->Html->link($guiaDetalle->guia_encabezado->id, ['controller' => 'GuiaEncabezados', 'action' => 'view', $guiaDetalle->guia_encabezado->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($guiaDetalle->nro_linea) ?></td>
            <td>
                <?= $guiaDetalle->has('especy') ? $this->Html->link($guiaDetalle->especy->id, ['controller' => 'Especies', 'action' => 'view', $guiaDetalle->especy->id]) : '' ?>
            </td>
            <td>
                <?= $guiaDetalle->has('unidade') ? $this->Html->link($guiaDetalle->unidade->id, ['controller' => 'Unidades', 'action' => 'view', $guiaDetalle->unidade->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($guiaDetalle->cantidad) ?></td>
            <td><?= $this->Number->format($guiaDetalle->precio) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $guiaDetalle->guia_encabezado_id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $guiaDetalle->guia_encabezado_id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $guiaDetalle->guia_encabezado_id], ['confirm' => __('Are you sure you want to delete # {0}?', $guiaDetalle->guia_encabezado_id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
