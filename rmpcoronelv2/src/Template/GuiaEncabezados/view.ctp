<?php
$this->layout = 'ajax';
?>
<div class="guiaEncabezados view large-10 medium-9 columns">
    <h2><?= h($guiaEncabezado->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Planta') ?></h6>
            <p><?= $guiaEncabezado->has('planta') ? $this->Html->link($guiaEncabezado->planta->id, ['controller' => 'Plantas', 'action' => 'view', $guiaEncabezado->planta->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Camion Patente') ?></h6>
            <p><?= h($guiaEncabezado->camion_patente) ?></p>
            <h6 class="subheader"><?= __('Auxiliare') ?></h6>
            <p><?= $guiaEncabezado->has('auxiliare') ? $this->Html->link($guiaEncabezado->auxiliare->id, ['controller' => 'Auxiliares', 'action' => 'view', $guiaEncabezado->auxiliare->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($guiaEncabezado->id) ?></p>
            <h6 class="subheader"><?= __('Nro Guia') ?></h6>
            <p><?= $this->Number->format($guiaEncabezado->nro_guia) ?></p>
            <h6 class="subheader"><?= __('Origen Id') ?></h6>
            <p><?= $this->Number->format($guiaEncabezado->origen_id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Salida') ?></h6>
            <p><?= h($guiaEncabezado->fecha_salida) ?></p>
            <h6 class="subheader"><?= __('Fecha Recepcion') ?></h6>
            <p><?= h($guiaEncabezado->fecha_recepcion) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Observaciones') ?></h6>
            <?= $this->Text->autoParagraph(h($guiaEncabezado->observaciones)); ?>

        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related GuiaDetalles') ?></h4>
    <?php if (!empty($guiaEncabezado->guia_detalles)): ?>
    <table class="table table-bordered">
        <tr>
            <th><?= __('Especie Id') ?></th>
            <th><?= __('Unidad Id') ?></th>
            <th><?= __('Cantidad') ?></th>
        </tr>
        <?php foreach ($guiaEncabezado->guia_detalles as $guiaDetalles): ?>
        <tr>
            <td><?= h($guiaDetalles->especie_id) ?></td>
            <td><?= h($guiaDetalles->unidades[0]->nombre) ?></td>
            <td><?= h($guiaDetalles->unidades[0]->_joinData->cantidad) ?></td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related DescargaEncabezados') ?></h4>
    <?php if (!empty($guiaEncabezado->descarga_encabezados)): ?>
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
        </tr>
        <?php foreach ($guiaEncabezado->descarga_encabezados as $descargaEncabezados): ?>
        <tr>
            <td><?= h($descargaEncabezados->id) ?></td>
            <td><?= h($descargaEncabezados->tipo_descarga) ?></td>
            <td><?= h($descargaEncabezados->compra) ?></td>
            <td><?= h($descargaEncabezados->arte_pesca_id) ?></td>
            <td><?= h($descargaEncabezados->fin_descarga) ?></td>
            <td><?= h($descargaEncabezados->fecha_pesca) ?></td>
            <td><?= h($descargaEncabezados->estado) ?></td>
            <td><?= h($descargaEncabezados->observaciones) ?></td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
