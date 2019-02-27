<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
  <div class="col-md-12">
    <?= $this->Form->create($loteEncabezado, ['id' => 'lote-form']) ?>
    <div class="row">
    <div class="col-md-12"><legend>Encabezado</legend></div>
    <div class="col-md-5">
      <div class="form-group">
        <label class="col-sm-3 control-label">Folio Detalle</label>
        <div class="col-sm-9">
              <select class="form-control input-xs" name="folio_detalles[_ids]" id="folio-detalles-ids" data-placeholder="Seleccione un el Detalle del Folio Indicado" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($folioDetalles as $detalle): ?>
                  <option
                        value="<?=$detalle->ids?>"
                        data-nro-folio="<?= $detalle->nro_folio?>"
                        data-codigo-nave="<?=explode('-', $detalle->nave_senal_distintiva)[1]?>"
                        data-year="<?=date('y', $detalle->fecha_produccion->toUnixString())?>"
                        data-juliano="<?=date('z', $detalle->fecha_produccion->toUnixString()) + 1?>"
                        data-total-ton="<?=$detalle->total_TON?>">
                        <?=$detalle->especie?> - <?=convertirFecha($detalle->fecha_produccion->toUnixString(), false)?> - <?= round($detalle->total_CJS, 0) ?> CJS
                      </option>
                  <?php endforeach; ?>
              </select>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <?= $this->Form->input('sub_codigo', ['label' => 'Sub. Código', 'placeholder' => 'Seleccione un Sub Código', 'lang' => 'es', 'options' => $subcodigos, 'empty' => true, 'style' => 'width: 100%']) ?>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label class="col-sm-3 control-label">Lote</label>
        <div class="col-sm-9">
          <input type="text" class="form-control input-xs text-right" name="lote" id="lote" readonly value="0">
        </div>
      </div>
    </div>
    </div>
    <div class="row">
      <div class="col-md-9 col-md-offset-3">
        <?= $this->Form->input('observaciones') ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12"><legend>Detalles</legend></div>
      <div class="col-md-4">
        <a id="new-detalle-lote" class="btn input-xs"><i class="fa fa-plus"></i> Agregar Detalle</a>
        <?php if(array_in_array(['admin_calibre_add'], $current_user['privilegios'])): ?>
          <a id="new-calibre" class="btn input-xs">Nuevo Calibre</a>
        <?php else:?>
          <a id="new-calibre" class="btn input-xs" disabled>Nuevo Calibre</a>
        <?php endif; ?>
      </div>
      <!--<div class="col-md-3">
        <input type="text" class="form-control input-xs text-right" id="rendimiento" readonly disabled value="0 %">
      </div>-->
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-hover table-condensed" id="detalles-table">
          <thead>
            <th>Pallet</th>
            <th>Calibre</th>
            <th>CJS PT</th>
            <th>KLS PT</th>
            <th></th>
          </thead>
          <?php
              $this->Form->templates([
                  'formGroup' => '{{input}}',
              ]);
          ?>
          <tbody>
            <tr>
              <td>
                <?= $this->Form->input('lote_detalles.0.pallet', ['placeholder' => 'Ingrese el nro. del Pallet']) ?>
              </td>
              <td>
                <?= $this->Form->input('lote_detalles.0.calibre_id', ['placeholder' => 'Seleccione un Calibre', 'lang' => 'es', 'options' => $calibres, 'style' => 'width: 100%']) ?>
              </td>
              <td>
                <div class="input-container">
                    <input type="text"
                           name="lote_detalles[0][unidades][0][_joinData][cantidad]"
                           required="required" class="input-xs form-control"
                           placeholder="Ingrese el número de Cajas"
                           data-precision="0"
                           data-unidad-id="4">
                    <?= $this->Form->input('lote_detalles.0.unidades.0.id', ['type' => 'hidden', 'value' => '4']) ?>
                    <label>CJS</label>
                </div>
              </td>
              <td>
                <div class="input-container">
                    <input type="text"
                           name="lote_detalles[0][unidades][1][_joinData][cantidad]"
                           required="required"
                           class="input-xs form-control"
                           placeholder="Ingrese el número de Kilos"
                           data-precision="3"
                           data-unidad-id="3">
                    <?= $this->Form->input('lote_detalles.0.unidades.1.id', ['type' => 'hidden', 'value' => '3']) ?>
                    <label>KLS</label>
                </div>
              </td>
              <td class="centered">
                <button class="btn btn-warning btn-xs btn-delete-detalle" id="del-detalle-lote"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?= $this->Form->end() ?>
  </div>
</div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $thisModal.parents('.modal-dialog').addClass('modal-lg');
     $('select', $thisModal).select2({
         dropdownParent: $thisModal
     });


     $('#folio-detalle-id, #sub-codigo', $thisModal).on('change', function() {
       // TODO: Se debe actualiza el nro de lote
       console.log('cambia lote');
     });

     var numRow = 1;
     $("#new-detalle-lote", $thisModal).click(function (e) {
         e.preventDefault();
         var delButton = '<button class="btn btn-warning btn-xs btn-delete-detalle" id="del-detalle-lote"><i class="fa fa-trash-o"></i></button>';
         var calibreSelect = '<?= $this->Form->input('lote_detalles.\'+ numRow +\'.calibre_id', ['label' => false, 'options' => $calibres, 'style' => 'width: 100%']); ?>';
         //cajas
         var cajasInput = '<div class="input-container"><input type="text"';
           cajasInput += 'name="lote_detalles['+numRow+'][unidades][0][_joinData][cantidad]"';
           cajasInput += 'required="required" class="input-xs form-control"';
           cajasInput += 'placeholder="Ingrese el número de Cajas"';
           cajasInput += 'data-precision="0"';
           cajasInput += 'data-unidad-id="4">';
           cajasInput += '<?= $this->Form->input('lote_detalles.\'+ numRow +\'.unidades.0.id', ['type' => 'hidden', 'value' => 4]); ?><label>CJS</label></div>';
         //kilos
         var kilosInput = '<div class="input-container"><input type="text"';
           kilosInput += 'name="lote_detalles['+numRow+'][unidades][1][_joinData][cantidad]"';
           kilosInput += 'required="required" class="input-xs form-control"';
           kilosInput += 'placeholder="Ingrese el cantidad de Kilos"';
           kilosInput += 'data-precision="3"';
           kilosInput += 'data-unidad-id="3">';
           kilosInput += '<?= $this->Form->input('lote_detalles.\'+ numRow +\'.unidades.1.id', ['type' => 'hidden', 'value' => 3]); ?><label>KLS</label></div>';
         var palletInput = '<input type="text" name="lote_detalles['+numRow+'][pallet]" required="required" class="input-xs form-control" placeholder="Ingrese el nro. de Pallet">';
         $('#detalles-table tbody').append('<tr><td>'+palletInput+'</td><td>'+calibreSelect+'</td><td>'+cajasInput+'</td><td>'+kilosInput+'</td><td class="centered">'+delButton+'</td></tr>');

         $('select[name$="[calibre_id]"]', $('#detalles-table', $thisModal)).select2();
         numRow++;
     });

     $('#detalles-table', $thisModal).on('click', '.btn-delete-detalle', function (e) {
         var $row = $(this).parents('tr');
         e.preventDefault();
         BootstrapDialog.confirm({
             message: "¿Seguro de borrar un detalle de descarga?",
             size: BootstrapDialog.SIZE_SMALL,
             callback: function (result) {
                 if (result) {
                     $row.remove();
                     //updateTotal();
                 }
             }
         });
     });

     // Se actualiza inputs de cantidad en funcion de su precision
     $('#detalles-table tbody').on('blur', 'input[name$="[cantidad]"]', function () {
       var precision = $(this).data('precision');
       var value = Number($(this).val().replace(',', '.'))
       value = value.toFixed( precision ).toString().replace('.', ',')
       console.log( value );
       $(this).val( value );
       updateRendimiento();
     });

     $('#folio-detalles-ids', $thisModal).on('change', function() {
       updateNroLote();
       updateRendimiento();
     });

     $('#sub-codigo', $thisModal).on('change', function() {
       updateNroLote();
     });

     /** Actualiza el nro_de_lote utilizando la información ingresada por el
      * usuario
      */
     function updateNroLote()
     {
       if ($('#folio-detalles-ids', $thisModal).val()) {
         var option_selected = $('#folio-detalles-ids option:selected', $thisModal)
         var _senal_distintiva = option_selected.data('codigoNave');
         var _nro_folio = option_selected.data('nroFolio');
         var _year = option_selected.data('year');
         var _juliano = option_selected.data('juliano');
       } else {
         var _senal_distintiva = '__';
         var _nro_folio = '___';
         var _year = '__';
         var _juliano = '___';
       }
       if ($('#sub-codigo', $thisModal).val()) {
         var _sub_codigo = $('#sub-codigo', $thisModal).val();
       } else {
         var _sub_codigo = '_';
       }
       var _tipo_proceso = 'P';

       $('#lote', $thisModal).val('' +
                                  _senal_distintiva +
                                  formatNumberLength(_nro_folio, 3) +
                                  _tipo_proceso +
                                  _sub_codigo +
                                  _year +
                                  formatNumberLength(_juliano, 3));
     }

     /** Funcion utilizada para actualizar la información del rendimiento basado
      * la información que va ingresando el usuario
      */
     function updateRendimiento()
     {
       var rendimiento = '- %';
       if ($('#folio-detalles-ids').val()) {
         var total_toneladas = $('#folio-detalles-ids option:selected').data('totalTon');
         console.log( total_toneladas );
         rendimiento = '0 %';
       }
       $('#rendimiento').val( rendimiento );
     }

     $('#lote-form', $thisModal).validate({
         rules: {
           folio_detalle_id: {
               required: true
           },
           sub_codigo: {
             required: true,
             remote: {
               url: '/lote_encabezados/checkSubcodigo',
               type: 'post',
               data: {
                 sub_codigo: function () {
                   var sub_codigo = $('#sub-codigo', $thisModal).val();
                   return sub_codigo;
                 },
                 folio_detalles: function () {
                   var folio_detalles = $('#folio-detalles-ids', $thisModal).val();
                   return folio_detalles
                 }
               }
             }
           }
         },
         messages: {
            sub_codigo: {
              remote: "Sub. Código ya asociado a otro lote."
            }
         },
     });
     $('[name^="lote_detalles"]', $thisModal).rules('add', {
         required: true
     });
     $('[name^="lote_detalles"][name$="[cantidad]"]', $thisModal).rules('add', {
         number: true
     });

     <?php if (array_in_array(['admin_calibre_add'], $current_user['privilegios'])):?>
     $('#new-calibre', $thisModal).on('click', function(e) {
         e.stopPropagation();
         newEntity('Nuevo Calibre', '/calibres/add', {
             successCallback: function ( data ){
                 var $select = $('select[name^="lote_detalles"][name$="[calibre_id]"]', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });
     <?php endif; ?>
 });
</script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $loteEncabezado->errors(),
        'data' => $loteEncabezado
    ]);
}
?>
