<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Movimiento'), ['action' => 'edit', $movimiento->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Movimiento'), ['action' => 'delete', $movimiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movimiento->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Movimientos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movimiento'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descarga Encabezados'), ['controller' => 'DescargaEncabezados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['controller' => 'DescargaEncabezados', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Guia Encabezados'), ['controller' => 'GuiaEncabezados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Guia Encabezado'), ['controller' => 'GuiaEncabezados', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="movimientos view large-10 medium-9 columns">
    <h2><?= h($movimiento->nombre) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($movimiento->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($movimiento->id) ?></p>
            <h6 class="subheader"><?= __('Tipo') ?></h6>
            <p><?= $this->Number->format($movimiento->tipo) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Descarga Encabezados') ?></h4>
    <?php if (!empty($movimiento->descarga_encabezados)): ?>
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
        <?php foreach ($movimiento->descarga_encabezados as $descargaEncabezados): ?>
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
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Guia Encabezados') ?></h4>
    <?php if (!empty($movimiento->guia_encabezados)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Nro Guia') ?></th>
            <th><?= __('Movimiento Id') ?></th>
            <th><?= __('Division Id') ?></th>
            <th><?= __('Recurso Id') ?></th>
            <th><?= __('Origen Id') ?></th>
            <th><?= __('Destino Id') ?></th>
            <th><?= __('Camion Id') ?></th>
            <th><?= __('Chofer Id') ?></th>
            <th><?= __('Fecha Salida') ?></th>
            <th><?= __('Fecha Recepcion') ?></th>
            <th><?= __('Observaciones') ?></th>
            <th><?= __('Estado Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($movimiento->guia_encabezados as $guiaEncabezados): ?>
        <tr>
            <td><?= h($guiaEncabezados->id) ?></td>
            <td><?= h($guiaEncabezados->nro_guia) ?></td>
            <td><?= h($guiaEncabezados->movimiento_id) ?></td>
            <td><?= h($guiaEncabezados->division_id) ?></td>
            <td><?= h($guiaEncabezados->recurso_id) ?></td>
            <td><?= h($guiaEncabezados->origen_id) ?></td>
            <td><?= h($guiaEncabezados->destino_id) ?></td>
            <td><?= h($guiaEncabezados->camion_id) ?></td>
            <td><?= h($guiaEncabezados->chofer_id) ?></td>
            <td><?= h($guiaEncabezados->fecha_salida) ?></td>
            <td><?= h($guiaEncabezados->fecha_recepcion) ?></td>
            <td><?= h($guiaEncabezados->observaciones) ?></td>
            <td><?= h($guiaEncabezados->estado_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'GuiaEncabezados', 'action' => 'view', $guiaEncabezados->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'GuiaEncabezados', 'action' => 'edit', $guiaEncabezados->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'GuiaEncabezados', 'action' => 'delete', $guiaEncabezados->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guiaEncabezados->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
