<?php
$this->layout = 'ajax';
?>
<div class="transportes view large-10 medium-9 columns">
    <h2><?= h($transporte->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($transporte->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($transporte->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Camiones') ?></h4>
    <?php if (!empty($transporte->camiones)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Patente') ?></th>
            <th><?= __('Transporte Id') ?></th>
            <th><?= __('Tipo Camion') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($transporte->camiones as $camiones): ?>
        <tr>
            <td><?= h($camiones->patente) ?></td>
            <td><?= h($camiones->transporte_id) ?></td>
            <td><?= h($camiones->tipo_camion) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Camiones', 'action' => 'view', $camiones->patente]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Camiones', 'action' => 'edit', $camiones->patente]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Camiones', 'action' => 'delete', $camiones->patente], ['confirm' => __('Are you sure you want to delete # {0}?', $camiones->patente)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
