<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Privilegio'), ['action' => 'edit', $privilegio->nombre]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Privilegio'), ['action' => 'delete', $privilegio->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $privilegio->nombre)]) ?> </li>
        <li><?= $this->Html->link(__('List Privilegios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Privilegio'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grupos'), ['controller' => 'Grupos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grupo'), ['controller' => 'Grupos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="privilegios view large-10 medium-9 columns">
    <h2><?= h($privilegio->nombre) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($privilegio->nombre) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Grupos') ?></h4>
    <?php if (!empty($privilegio->grupos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Nombre') ?></th>
            <th><?= __('Division Id') ?></th>
            <th><?= __('Recurso Id') ?></th>
            <th><?= __('Estado') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($privilegio->grupos as $grupos): ?>
        <tr>
            <td><?= h($grupos->id) ?></td>
            <td><?= h($grupos->nombre) ?></td>
            <td><?= h($grupos->division_id) ?></td>
            <td><?= h($grupos->recurso_id) ?></td>
            <td><?= h($grupos->estado) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Grupos', 'action' => 'view', $grupos->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Grupos', 'action' => 'edit', $grupos->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Grupos', 'action' => 'delete', $grupos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grupos->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
