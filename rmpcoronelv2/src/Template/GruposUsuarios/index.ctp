<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Grupos Usuario'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Grupos'), ['controller' => 'Grupos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grupo'), ['controller' => 'Grupos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="gruposUsuarios index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('grupo_id') ?></th>
            <th><?= $this->Paginator->sort('usuario_uid') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($gruposUsuarios as $gruposUsuario): ?>
        <tr>
            <td>
                <?= $gruposUsuario->has('grupo') ? $this->Html->link($gruposUsuario->grupo->id, ['controller' => 'Grupos', 'action' => 'view', $gruposUsuario->grupo->id]) : '' ?>
            </td>
            <td>
                <?= $gruposUsuario->has('usuario') ? $this->Html->link($gruposUsuario->usuario->uid, ['controller' => 'Usuarios', 'action' => 'view', $gruposUsuario->usuario->uid]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $gruposUsuario->usuario_uid]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $gruposUsuario->usuario_uid]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $gruposUsuario->usuario_uid], ['confirm' => __('Are you sure you want to delete # {0}?', $gruposUsuario->usuario_uid)]) ?>
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
