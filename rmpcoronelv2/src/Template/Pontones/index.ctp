<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Pontone'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Recintos'), ['controller' => 'Recintos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Recinto'), ['controller' => 'Recintos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Puertos'), ['controller' => 'Puertos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Puerto'), ['controller' => 'Puertos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="pontones index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('puerto_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pontones as $pontone): ?>
        <tr>
            <td>
                <?= $pontone->has('recinto') ? $this->Html->link($pontone->recinto->nombre, ['controller' => 'Recintos', 'action' => 'view', $pontone->recinto->id]) : '' ?>
            </td>
            <td>
                <?= $pontone->has('puerto') ? $this->Html->link($pontone->puerto->nombre, ['controller' => 'Puertos', 'action' => 'view', $pontone->puerto->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $pontone->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pontone->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pontone->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pontone->id)]) ?>
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
