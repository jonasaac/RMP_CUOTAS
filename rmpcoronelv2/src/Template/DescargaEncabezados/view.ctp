<?php
$this->layout = 'ajax';
?>
<div class="descargaEncabezados view large-10 medium-9 columns">
    <h2><?= h($descargaEncabezado->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Arte Pesca') ?></h6>
            <p><?= $descargaEncabezado->has('arte_pesca') ? $this->Html->link($descargaEncabezado->arte_pesca->nombre, ['controller' => 'ArtePesca', 'action' => 'view', $descargaEncabezado->arte_pesca->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Recalada') ?></h6>
            <p><?= $descargaEncabezado->has('recalada') ? $this->Html->link($descargaEncabezado->recalada->display_name, ['controller' => 'Recaladas', 'action' => 'view', $descargaEncabezado->recalada->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Codigo Descarga') ?></h6>
            <p><?= h($descargaEncabezado->codigo_descarga) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($descargaEncabezado->id) ?></p>
            <h6 class="subheader"><?= __('Tipo Descarga') ?></h6>
            <p><?= $this->Number->format($descargaEncabezado->tipo_descarga) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($descargaEncabezado->estado) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Termino Desembarque') ?></h6>
            <p><?= h($descargaEncabezado->termino_desembarque) ?></p>
            <h6 class="subheader"><?= __('Fecha Pesca') ?></h6>
            <p><?= h($descargaEncabezado->fecha_pesca) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Compra') ?></h6>
            <?= $this->Text->autoParagraph(h($descargaEncabezado->compra)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Observaciones') ?></h6>
            <?= $this->Text->autoParagraph(h($descargaEncabezado->observaciones)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Descarga Detalles') ?></h4>
    <?php if (!empty($descargaEncabezado->descarga_detalles)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Descarga Encabezado Id') ?></th>
            <th><?= __('Especie Id') ?></th>
            <th><?= __('Zona Pesca') ?></th>
            <th><?= __('Destinatario Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($descargaEncabezado->descarga_detalles as $descargaDetalles): ?>
        <tr>
            <td><?= h($descargaDetalles->id) ?></td>
            <td><?= h($descargaDetalles->descarga_encabezado_id) ?></td>
            <td><?= h($descargaDetalles->especie_id) ?></td>
            <td><?= h($descargaDetalles->zona_pesca) ?></td>
            <td><?= h($descargaDetalles->destinatario_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'DescargaDetalles', 'action' => 'view', $descargaDetalles->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'DescargaDetalles', 'action' => 'edit', $descargaDetalles->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'DescargaDetalles', 'action' => 'delete', $descargaDetalles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $descargaDetalles->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
</div>
