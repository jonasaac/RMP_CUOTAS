<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Recepcione'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Descarga Encabezados'), ['controller' => 'DescargaEncabezados', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['controller' => 'DescargaEncabezados', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Auxiliares'), ['controller' => 'Auxiliares', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Auxiliare'), ['controller' => 'Auxiliares', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="recepciones index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('descarga_encabezado_id') ?></th>
            <th><?= $this->Paginator->sort('armador_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($recepciones as $recepcione): ?>
        <tr>
            <td>
                <?= $recepcione->has('descarga_encabezado') ? $this->Html->link($recepcione->descarga_encabezado->id, ['controller' => 'DescargaEncabezados', 'action' => 'view', $recepcione->descarga_encabezado->id]) : '' ?>
            </td>
            <td>
                <?= $recepcione->has('auxiliare') ? $this->Html->link($recepcione->auxiliare->id, ['controller' => 'Auxiliares', 'action' => 'view', $recepcione->auxiliare->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $recepcione->descarga_encabezado_id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $recepcione->descarga_encabezado_id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $recepcione->descarga_encabezado_id], ['confirm' => __('Are you sure you want to delete # {0}?', $recepcione->descarga_encabezado_id)]) ?>
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
