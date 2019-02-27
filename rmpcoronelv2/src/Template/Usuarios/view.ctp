<div class="usuarios view large-10 medium-9 columns">
    <h2><?= h($usuario->uid) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Uid') ?></h6>
            <p><?= h($usuario->uid) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($usuario->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($usuario->estado) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Grupos') ?></h4>
    <?php if (!empty($usuario->grupos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Nombre') ?></th>
            <th><?= __('Estado') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($usuario->grupos as $grupos): ?>
        <tr>
            <td><?= h($grupos->id) ?></td>
            <td><?= h($grupos->nombre) ?></td>
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
