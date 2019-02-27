<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Arte Pesca'), ['controller' => 'ArtePesca', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Arte Pesca'), ['controller' => 'ArtePesca', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Recaladas'), ['controller' => 'Recaladas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Recalada'), ['controller' => 'Recaladas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Descarga Detalles'), ['controller' => 'DescargaDetalles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Descarga Detalle'), ['controller' => 'DescargaDetalles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Guia Encabezados'), ['controller' => 'GuiaEncabezados', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Guia Encabezado'), ['controller' => 'GuiaEncabezados', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="descargaEncabezados index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('tipo_descarga') ?></th>
            <th><?= $this->Paginator->sort('arte_pesca_id') ?></th>
            <th><?= $this->Paginator->sort('termino_desembarque') ?></th>
            <th><?= $this->Paginator->sort('fecha_pesca') ?></th>
            <th><?= $this->Paginator->sort('estado') ?></th>
            <th><?= $this->Paginator->sort('recalada_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($descargaEncabezados as $descargaEncabezado): ?>
        <tr>
            <td><?= $this->Number->format($descargaEncabezado->id) ?></td>
            <td><?= $this->Number->format($descargaEncabezado->tipo_descarga) ?></td>
            <td>
                <?= $descargaEncabezado->has('arte_pesca') ? $this->Html->link($descargaEncabezado->arte_pesca->nombre, ['controller' => 'ArtePesca', 'action' => 'view', $descargaEncabezado->arte_pesca->id]) : '' ?>
            </td>
            <td><?= h($descargaEncabezado->termino_desembarque) ?></td>
            <td><?= h($descargaEncabezado->fecha_pesca) ?></td>
            <td><?= $this->Number->format($descargaEncabezado->estado) ?></td>
            <td>
                <?= $descargaEncabezado->has('recalada') ? $this->Html->link($descargaEncabezado->recalada->display_name, ['controller' => 'Recaladas', 'action' => 'view', $descargaEncabezado->recalada->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $descargaEncabezado->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $descargaEncabezado->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $descargaEncabezado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $descargaEncabezado->id)]) ?>
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
