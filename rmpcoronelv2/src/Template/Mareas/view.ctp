<?php
$this->layout = 'ajax';
?>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Recaladas') ?></h4>
    <?php if (!empty($marea->recaladas)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Fecha') ?></th>
            <th><?= __('Marea Id') ?></th>
            <th><?= __('Nro Recalada') ?></th>
            <th><?= __('Ponton Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($marea->recaladas as $recaladas): ?>
        <tr>
            <td><?= h($recaladas->fecha) ?></td>
            <td><?= h($recaladas->marea_id) ?></td>
            <td><?= h($recaladas->nro_recalada) ?></td>
            <td><?= h($recaladas->ponton_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Recaladas', 'action' => 'view', $recaladas->fecha]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Recaladas', 'action' => 'edit', $recaladas->fecha]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Recaladas', 'action' => 'delete', $recaladas->fecha], ['confirm' => __('Are you sure you want to delete # {0}?', $recaladas->fecha)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
