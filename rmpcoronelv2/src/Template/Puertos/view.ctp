<?php
$this->layout = 'ajax';
?>
<div class="puertos view large-10 medium-9 columns">
    <h2><?= h($puerto->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($puerto->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($puerto->id) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($puerto->estado) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Mareas') ?></h4>
    <?php if (!empty($puerto->mareas)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Nave Matricula') ?></th>
            <th><?= __('Fecha Zarpe') ?></th>
            <th><?= __('Capitan Id') ?></th>
            <th><?= __('Puerto Id') ?></th>
            <th><?= __('Estado') ?></th>
            <th><?= __('Observaciones') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($puerto->mareas as $mareas): ?>
        <tr>
            <td><?= h($mareas->id) ?></td>
            <td><?= h($mareas->nave_matricula) ?></td>
            <td><?= h($mareas->fecha_zarpe) ?></td>
            <td><?= h($mareas->capitan_id) ?></td>
            <td><?= h($mareas->puerto_id) ?></td>
            <td><?= h($mareas->estado) ?></td>
            <td><?= h($mareas->observaciones) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Mareas', 'action' => 'view', $mareas->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Mareas', 'action' => 'edit', $mareas->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Mareas', 'action' => 'delete', $mareas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mareas->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Pontones') ?></h4>
    <?php if (!empty($puerto->pontones)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Puerto Id') ?></th>
            <th><?= __('Nombre') ?></th>
            <th><?= __('Estado') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($puerto->pontones as $pontones): ?>
        <tr>
            <td><?= h($pontones->id) ?></td>
            <td><?= h($pontones->puerto_id) ?></td>
            <td><?= h($pontones->nombre) ?></td>
            <td><?= h($pontones->estado) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Pontones', 'action' => 'view', $pontones->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Pontones', 'action' => 'edit', $pontones->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pontones', 'action' => 'delete', $pontones->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pontones->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
