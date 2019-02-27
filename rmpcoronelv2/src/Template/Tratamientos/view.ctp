<?php
$this->layout = 'ajax';
?>
<div class="tratamientos view large-10 medium-9 columns">
    <h2><?= h($tratamiento->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($tratamiento->nombre) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $tratamiento->has('estado') ? $this->Html->link($tratamiento->estado->nombre, ['controller' => 'Estados', 'action' => 'view', $tratamiento->estado->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($tratamiento->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Controles Calidad') ?></h4>
    <?php if (!empty($tratamiento->controles_calidad)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Guia Encabezado Id') ?></th>
            <th><?= __('Tratamiento Id') ?></th>
            <th><?= __('Tvn') ?></th>
            <th><?= __('Agua') ?></th>
            <th><?= __('Ph') ?></th>
            <th><?= __('C') ?></th>
            <th><?= __('N Litro') ?></th>
            <th><?= __('Talla') ?></th>
            <th><?= __('Peso') ?></th>
            <th><?= __('Moda') ?></th>
            <th><?= __('Cms') ?></th>
            <th><?= __('Observaciones') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($tratamiento->controles_calidad as $controlesCalidad): ?>
        <tr>
            <td><?= h($controlesCalidad->id) ?></td>
            <td><?= h($controlesCalidad->guia_encabezado_id) ?></td>
            <td><?= h($controlesCalidad->tratamiento_id) ?></td>
            <td><?= h($controlesCalidad->tvn) ?></td>
            <td><?= h($controlesCalidad->agua) ?></td>
            <td><?= h($controlesCalidad->ph) ?></td>
            <td><?= h($controlesCalidad->c) ?></td>
            <td><?= h($controlesCalidad->n_litro) ?></td>
            <td><?= h($controlesCalidad->talla) ?></td>
            <td><?= h($controlesCalidad->peso) ?></td>
            <td><?= h($controlesCalidad->moda) ?></td>
            <td><?= h($controlesCalidad->cms) ?></td>
            <td><?= h($controlesCalidad->observaciones) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'ControlesCalidad', 'action' => 'view', $controlesCalidad->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'ControlesCalidad', 'action' => 'edit', $controlesCalidad->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ControlesCalidad', 'action' => 'delete', $controlesCalidad->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controlesCalidad->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
