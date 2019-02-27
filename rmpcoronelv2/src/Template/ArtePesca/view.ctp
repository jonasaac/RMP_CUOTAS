<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Arte Pesca'), ['action' => 'edit', $artePesca->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Arte Pesca'), ['action' => 'delete', $artePesca->id], ['confirm' => __('Are you sure you want to delete # {0}?', $artePesca->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Arte Pesca'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Arte Pesca'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descarga Encabezados'), ['controller' => 'DescargaEncabezados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['controller' => 'DescargaEncabezados', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="artePesca view large-10 medium-9 columns">
    <h2><?= h($artePesca->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($artePesca->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($artePesca->id) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($artePesca->estado) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related DescargaEncabezados') ?></h4>
    <?php if (!empty($artePesca->descarga_encabezados)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Tipo Descarga') ?></th>
            <th><?= __('Compra') ?></th>
            <th><?= __('Arte Pesca Id') ?></th>
            <th><?= __('Fin Descarga') ?></th>
            <th><?= __('Fecha Pesca') ?></th>
            <th><?= __('Estado') ?></th>
            <th><?= __('Observaciones') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($artePesca->descarga_encabezados as $descargaEncabezados): ?>
        <tr>
            <td><?= h($descargaEncabezados->id) ?></td>
            <td><?= h($descargaEncabezados->tipo_descarga) ?></td>
            <td><?= h($descargaEncabezados->compra) ?></td>
            <td><?= h($descargaEncabezados->arte_pesca_id) ?></td>
            <td><?= h($descargaEncabezados->fin_descarga) ?></td>
            <td><?= h($descargaEncabezados->fecha_pesca) ?></td>
            <td><?= h($descargaEncabezados->estado) ?></td>
            <td><?= h($descargaEncabezados->observaciones) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'DescargaEncabezados', 'action' => 'view', $descargaEncabezados->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'DescargaEncabezados', 'action' => 'edit', $descargaEncabezados->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'DescargaEncabezados', 'action' => 'delete', $descargaEncabezados->id], ['confirm' => __('Are you sure you want to delete # {0}?', $descargaEncabezados->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
