<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Tipo Descarga'), ['action' => 'edit', $tipoDescarga->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tipo Descarga'), ['action' => 'delete', $tipoDescarga->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tipoDescarga->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tipo Descargas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tipo Descarga'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descarga Encabezados'), ['controller' => 'DescargaEncabezados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['controller' => 'DescargaEncabezados', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="tipoDescargas view large-10 medium-9 columns">
    <h2><?= h($tipoDescarga->nombre) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($tipoDescarga->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($tipoDescarga->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Descarga Encabezados') ?></h4>
    <?php if (!empty($tipoDescarga->descarga_encabezados)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Tipo Descarga Id') ?></th>
            <th><?= __('Movimiento Id') ?></th>
            <th><?= __('Arte Pesca Id') ?></th>
            <th><?= __('Termino Desembarque') ?></th>
            <th><?= __('Fecha Pesca') ?></th>
            <th><?= __('Estado Id') ?></th>
            <th><?= __('Recalada Id') ?></th>
            <th><?= __('Resolucion') ?></th>
            <th><?= __('Observaciones') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($tipoDescarga->descarga_encabezados as $descargaEncabezados): ?>
        <tr>
            <td><?= h($descargaEncabezados->id) ?></td>
            <td><?= h($descargaEncabezados->tipo_descarga_id) ?></td>
            <td><?= h($descargaEncabezados->movimiento_id) ?></td>
            <td><?= h($descargaEncabezados->arte_pesca_id) ?></td>
            <td><?= h($descargaEncabezados->termino_desembarque) ?></td>
            <td><?= h($descargaEncabezados->fecha_pesca) ?></td>
            <td><?= h($descargaEncabezados->estado_id) ?></td>
            <td><?= h($descargaEncabezados->recalada_id) ?></td>
            <td><?= h($descargaEncabezados->resolucion) ?></td>
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
