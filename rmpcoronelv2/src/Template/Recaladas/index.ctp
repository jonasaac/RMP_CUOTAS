<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Recalada'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Mareas'), ['controller' => 'Mareas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Marea'), ['controller' => 'Mareas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pontones'), ['controller' => 'Pontones', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pontone'), ['controller' => 'Pontones', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="recaladas index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('fecha') ?></th>
            <th><?= $this->Paginator->sort('marea_id') ?></th>
            <th><?= $this->Paginator->sort('nro_recalada') ?></th>
            <th><?= $this->Paginator->sort('ponton_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($recaladas as $recalada): ?>
        <tr>
            <td><?= h($recalada->fecha) ?></td>
            <td>
                <?= $recalada->has('marea') ? $this->Html->link($recalada->marea->id, ['controller' => 'Mareas', 'action' => 'view', $recalada->marea->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($recalada->nro_recalada) ?></td>
            <td>
                <?= $recalada->has('pontone') ? $this->Html->link($recalada->pontone->id, ['controller' => 'Pontones', 'action' => 'view', $recalada->pontone->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $recalada->fecha]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $recalada->fecha]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $recalada->fecha], ['confirm' => __('Are you sure you want to delete # {0}?', $recalada->fecha)]) ?>
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
