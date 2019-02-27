<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-md-12">
          <form class="form-horizontal" id="descarga-form">
            <div class="row">
              <div class="col-sm-12">
                <legend>Descarga Encabezado</legend>
              </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tipo Descarga</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                          <select class="form-control input-xs" style="width: 100%" name="tipo_descarga_id" id="tipo-descarga-id" data-placeholder="Seleccione el tipo de descarga" placeholder="Seleccione el tipo de descarga">
                              <option></option>
                              <?php foreach($tipoDescargas as $id => $tipo_descarga): ?>
                                  <option value="<?=$id?>"><?=$tipo_descarga?></option>
                              <?php endforeach; ?>
                          </select>
                          <div class="input-group-btn">
                          <?php if(array_in_array(['admin_tipoDescarga_add'], $current_user['privilegios'])): ?>
                              <a id="new-tipo-descarga" class="btn btn-default input-xs">Nuevo</a>
                            <?php else: ?>
                              <a id="new-tipo-descarga" class="btn btn-default input-xs" disabled>Nuevo</a>
                          <?php endif; ?>
                          </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?=$this->Form->input('codigo_descarga', ['label' => 'Cód. Descarga', 'placeholder' => 'Ingrese el cod. del documento'])?>
                </div>
                <div class="col-md-4" id="fecha-pesca-div" style="display: none;">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha de Pesca</label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-sm-7">
                          <div class="input-group input-group-xs date-picker" id="fecha-pesca-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="fecha_pesca_date" id="fecha-pesca-date" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="input-group input-group-xs time-picker" id="fecha-pesca-time-container">
                            <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                            <input name="fecha_pesca_time" id="fecha-pesca-time" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4" id="fecha-primer-lance-div" style="display: none;">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha de Primer Lance</label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-sm-7">
                          <div class="input-group input-group-xs date-picker" id="fecha-primer-lance-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="fecha_primer_lance_date" id="fecha-primer-lance-date" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="input-group input-group-xs time-picker" id="fecha-primer-lance-time-container">
                            <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                            <input name="fecha_primer_lance_time" id="fecha-primer-lance-time" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Inicio de Desembarque</label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-sm-7">
                          <div class="input-group input-group-xs date-picker" id="inicio-desembarque-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="inicio_desembarque_date" id="inicio-desembarque-date" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="input-group input-group-xs time-picker" id="inicio-desembarque-time-container">
                            <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                            <input name="inicio_desembarque_time" id="inicio-desembarque-time" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Termino de Desembarque</label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-sm-7">
                          <div class="input-group input-group-xs date-picker" id="termino-desembarque-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="termino_desembarque_date" id="termino-desembarque-date" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="input-group input-group-xs time-picker" id="termino-desembarque-time-container">
                            <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                            <input name="termino_desembarque_time" id="termino-desembarque-time" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="col-md-12 no-padding">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Movimiento</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" style="width: 100%" name="movimiento_id" id="movimiento-id" data-placeholder="Seleccione un movimiento" placeholder="Seleccione un movimiento" style="width:100%" lang="es">
                                    <option value></option>
                                    <?php foreach($movimientos as $id => $movimiento): ?>
                                        <option value="<?=$id?>"><?=$movimiento?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                <?php if(array_in_array(['admin_movimiento_add'], $current_user['privilegios'])): ?>
                                  <a id="new-movimiento" class="btn btn-default input-xs">Nuevo</a>
                                <?php else: ?>
                                  <a id="new-movimiento" class="btn btn-default input-xs" disabled>Nuevo</a>
                                <?php endif; ?>
                                </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div id="primer-lance-div" class="form-group" style="display:none;">
                  <div class="control-label col-sm-3">Primer Lance</div>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-sm-4 form-element">
                        <input type="text" name="zona_primer_lance" class="form-control input-xs input-active" placeholder="Zona" id="zona-primer-lance">
                      </div>
                      <div class="col-sm-4 form-element">
                        <input type="text" name="latitud" class="form-control input-xs input-active" placeholder="Latitud" id="latitud">
                      </div>
                      <div class="col-sm-4 form-element">
                        <input type="text" name="longitud" class="form-control input-xs input-active" placeholder="Longitud" id="longitud">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Observaciones</label>
                  <div class="col-sm-9">
                    <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <legend>Descarga Detalles</legend>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="checkbox">
                    <label>
                      <input type="hidden" name="sin_pesca" value="0">
                      <input id="descarga-sin-pesca" type="checkbox" name="sin_pesca" value="1"/>
                      <span class="text">Sin pesca</span>
                    </label>
                  </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-xs" id="new-detalle-descarga"><i class="fa fa-plus"></i> Agregar Detalle</button>
                    <?php if(array_in_array(['admin_especie_add'], $current_user['privilegios'])): ?>
                      <a id="new-especie" class="btn input-xs">Nueva Especie</a>
                    <?php else:?>
                      <a id="new-especie" class="btn input-xs" disabled>Nueva Especie</a>
                    <?php endif; ?>
                    <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                      <a id="new-destinatario" class="btn input-xs">Nuevo Destino</a>
                    <?php else:?>
                      <a id="new-destinatario" class="btn input-xs" disabled>Nuevo Destino</a>
                    <?php endif; ?>
                    <?php foreach($unidades as $unidad): ?>
                      <input type="text"
                            data-unidad-id="<?=$unidad->id?>"
                            data-precision="<?=$unidad->precision?>"
                            data-abreviacion="<?=$unidad->abreviacion?>"
                            value="0 <?=$unidad->abreviacion?>"
                            readonly="readonly"
                            class="input-xs"
                            id="detalles-<?= $unidad->id ?>-suma"
                            style="text-align: right"/>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-12" id="descarga_detalles-container">
                    <input type="hidden" name="descarga_detalles[]" />
                    <?php
                        $this->Form->templates([
                            'formGroup' => '{{input}}',
                        ]);
                    ?>
                <table class="table table-hover table-condensed" id="detalles-table">
                    <thead>
                        <tr>
                            <th class="col-sm-2">Especie</th>
                            <?php foreach($unidades as $unidad): ?>
                              <th class="col-sm-1"><?= $unidad->abreviacion ?></th>
                            <?php endforeach; ?>
                            <th class="sol-sm-1">Zona Pesca</th>
                            <th class="col-sm-3">Destino</th>
                            <th class="col-sm-3">Titular Contrato Suministro</th>
                            <th class="col-sm-1">Resolución</th>
                            <th class="col-sm-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                              <select name="descarga_detalles[0][especie_id]" required="required" class="form-control input-xs" data-placeholder="Especie" placeholder="Especie" lang="es" style="width:100%">
                                <option value></option>
                              </select>
                            </td>
                            <?php $unidadesIdx = 0; ?>
                            <?php foreach($unidades as $unidad): ?>
                              <td>
                                  <input type="text" name="descarga_detalles[0][unidades][<?= $unidadesIdx ?>][_joinData][cantidad]"
                                  required="required"
                                  class="input-xs"
                                  placeholder="Cantidad"
                                  data-unidad-id="<?=$unidad->id?>">
                                  <span></span>
                                  <?= $this->Form->input('descarga_detalles.0.unidades.'.$unidadesIdx.'.id', ['type' => 'hidden', 'value' => $unidad->id]); ?>
                              </td>
                              <?php $unidadesIdx++; ?>
                            <?php endforeach; ?>
                            <td>
                                <!--<select name="descarga_detalles[0][zona_pesca_id]" required="required" class="form-control input-xs" data-placeholder="Zona" placeholder="Zona" disabled="true" lang="es" style="width: 100%">
                                  <option value></option>
                              </select>-->
                                <input type="number" name="descarga_detalles[0][zona_pesca]" required="required" class="input-xs" placeholder="Zona">
                            </td>
                            <td>
                                <select name="descarga_detalles[0][destinatario_id]" required="required" class="form-control input-xs" data-placeholder="Destinatario" placeholder="Destinatatio" lang="es" style="width:100%">
                                  <?php foreach($destinatarios as $id => $destinatario):?>
                                    <option value="<?=$id?>"<?=$id==$camanchaca_id?' selected="selected"':null;?>><?=$destinatario?></option>
                                  <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                              <select name="descarga_detalles[0][tcs_id]" required="required" class="form-control input-xs" data-placeholder="Titular de Contrato de Suministro" placeholder="Titular de Contrato de Suministro" lang="es" style="width:100%">
                                <?php foreach($tcss as $id => $tcs):?>
                                  <option value="<?=$id?>"<?=$id==$camanchaca_id?' selected="selected"':null;?>><?=$tcs?></option>
                                <?php endforeach; ?>
                              </select>
                            </td>
                            <td>
                                <!--<select name="descarga_detalles[0][resolucion_id]" class="form-control input-xs" data-placeholder="Nº Res." placeholder="Nº Res." disabled="true" lang="es" style="width:100%">
                                  <option value></option>
                              </select>-->
                                <input type="text" name="descarga_detalles[0][resolucion]" class="input-xs" placeholder="Nº Res.">
                            </td>
                            <td class="centered">
                                <button class="btn btn-warning btn-xs btn-delete-detalle" id="del-detalle-descarga"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
          </form>
    </div>
</div>
<script>
 $(document).ready(function () {
     $thisModal = $('#<?=$hash_id?>');
     $('#tipo-descarga-id, #movimiento-id', $thisModal).select2({
       dropdownParent: $thisModal,
       sortResults: function(results, container, query) {
         return results.sort(function(a,b){return a.text.localeCompare(b.text) > 0; });
       }
     });
     especies = []
     $.ajax({
       url: '/api/especies/listar.json',
       type: 'GET',
       dataType: 'json'
     }).done(function (data) {
       $.each(data.especies, function (i, especie) {
         especies.push({id: especie.id, text: especie.nombre});
       });
       $('select[name$="[especie_id]"]', $('#detalles-table', $thisModal)).select2({
         data: especies,
         dropdownParent: $thisModal
       });
     })
     $('select[name$="[especie_id]"]', $('#detalles-table', $thisModal)).select2({dropdownParent: $thisModal});
     // $('select[name$="[zona_pesca_id]"]', $('#detalles-table', $thisModal)).select2();
     // $('select[name$="[resolucion_id]"]', $('#detalles-table', $thisModal)).select2();

     $('select[name$="[destinatario_id]"], select[name$="[tcs_id]"]', $('#detalles-table', $thisModal)).select2();

     $('#fecha-pesca-date', $thisModal).val(moment.utc(fechaRecalada).format('DD-MMM-YYYY'));
     $('#fecha-pesca-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
     $('#fecha-pesca-date-container', $thisModal).data('DateTimePicker').minDate( moment.utc(fechaMarea).set({'hour':0, 'minute':0}) );
     $('#fecha-pesca-date-container', $thisModal).data('DateTimePicker').maxDate( moment.utc(fechaRecalada).set({'hour':0, 'minute':0}) );
     $('#fecha-pesca-time', $thisModal).val(moment.utc(fechaRecalada).format('HH:mm'));
     $('#fecha-pesca-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));
     $('#fecha-primer-lance-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
     $('#fecha-primer-lance-date-container', $thisModal).datetimepicker(dateOptions(moment()));
     //$('#fecha-primer-lance-date-container', $thisModal).data('DateTimePicker').minDate( moment.utc(fechaMarea).set({'hour':0, 'minute':0}) );
     //$('#fecha-primer-lance-date-container', $thisModal).data('DateTimePicker').maxDate( moment.utc(fechaRecalada).set({'hour':0, 'minute':0}) );
     $('#fecha-primer-lance-time', $thisModal).val(moment().format('HH:mm'));
     $('#fecha-primer-lance-time-container', $thisModal).datetimepicker(timeOptions(moment()));
     $('#inicio-desembarque-date', $thisModal).val(moment.utc(fechaRecalada).format('DD-MMM-YYYY'));
     $('#inicio-desembarque-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
     $('#inicio-desembarque-date-container', $thisModal).data('DateTimePicker').minDate( moment.utc(fechaRecalada).set({'hour':0, 'minute':0}) );
     $('#inicio-desembarque-time', $thisModal).val(moment.utc(fechaRecalada).format('HH:mm'));
     $('#inicio-desembarque-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));
     $('#termino-desembarque-date', $thisModal).val(moment.utc(fechaRecalada).format('DD-MMM-YYYY'));
     $('#termino-desembarque-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
     $('#termino-desembarque-date-container', $thisModal).data('DateTimePicker').minDate( moment.utc(fechaRecalada).set({'hour':0, 'minute':0}) );
     $('#termino-desembarque-time', $thisModal).val(moment.utc(fechaRecalada).format('HH:mm'));
     $('#termino-desembarque-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));;

     $("#inicio-desembarque-date-container", $thisModal).on('dp.change', function() {
       $('#termino-desembarque-date-container', $thisModal).data("DateTimePicker")
       .minDate($('#inicio-desembarque-date-container', $thisModal).data("DateTimePicker").date())
       .date($('#inicio-desembarque-date-container', $thisModal).data("DateTimePicker").date());
     });

     $('[name^="descarga_detalles[0][zona_pesca]"]').val(zonaPesca);


     $('#descarga-sin-pesca', $thisModal).on('change', function (e) {
         if ($(this).is(':checked')) {
             $('[name^="descarga_detalles"]').prop('disabled', true);
             $('.btn-delete-detalle').prop('disabled', true);
             $('#new-detalle-descarga').prop('disabled', true);
         } else {
             $('[name^="descarga_detalles"], #new-detalle-descarga, .btn-delete-detalle').prop('disabled', false);
         }
     });

     // Se comprueba el cambio del tipo de documento de descarga
     $('#tipo-descarga-id', $thisModal).val(tipoDescargaSelected).trigger('change');
     $('#tipo-descarga-id', $thisModal).on('change', function (e) {
       console.log($(this).val());
       if ( $(this).val() == '1' ) { // Industriales
         $('#fecha-pesca-div', $thisModal).hide();
         $('#fecha-primer-lance-div', $thisModal).show();
         $('#primer-lance-div', $thisModal).show();
       } else if ( $(this).val() == '2' ) { // Artesanales
         $('#fecha-pesca-div', $thisModal).show();
         $('#fecha-primer-lance-div', $thisModal).hide();
         $('#primer-lance-div', $thisModal).hide();
       } else {  // Otros
         $('#fecha-pesca-div', $thisModal).hide();
         $('#fecha-primer-lance-div', $thisModal).hide();
         $('#primer-lance-div', $thisModal).hide();
       }
     });
     if (tipoDescargaSelected == 1) {
         $('#fecha-primer-lance-div', $thisModal).show();
         $('#primer-lance-div', $thisModal).show();
     } else if (tipoDescargaSelected == 2) {
       $('#fecha-pesca-div', $thisModal).show();
     }

     var updateTotal = function () {
       var total = {};
       <?php foreach($unidades as $unidad): ?>
         total[<?=$unidad->id?>] = 0;
       <?php endforeach; ?>

         $('input[name$="[cantidad]"]').each(function (i, e) {
             var tempNum = $(this).val();
             tempNum = tempNum.replace('.', '').replace(',','.');
             total[ $(this).data('unidadId') ] += Number(tempNum);
         });

         $('[id^=detalles][id$=suma]').each(function (i, e) {
           var tmptotal = total[$(this).data('unidadId')];
           if(isNaN(tmptotal)) {
               $(this).val('ERROR');
           } else {
               tmptotal = tmptotal.toFixed( $(this).data('precision') ).toString().replace('.', ',');
               $(this).val(tmptotal+' '+$(this).data('abreviacion'));
           }
         });

         /*$.each(total, function(i, value) {
           if(isNaN(value)) {
               $('#detalles-'+ Object.keys(total)[i] +'-suma').val('ERROR');
           } else {
               value = value.toFixed(3).toString().replace('.', ',');
               $('#detalles-'+ Object.keys(total)[i] +'-suma').val(value+' TON');
           }
         });*/
     }

     $('#detalles-table', $thisModal).on('change keyup blur', 'input[name$="[cantidad]"]', function () {
         updateTotal()
     });

     <?php if(array_in_array(['admin_tipoDescarga_add'], $current_user['privilegios'])): ?>
     $('#new-tipo-descarga', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Tipo de Descarga', '/tipo_descargas/add', {
             successCallback: function ( data ) {
                 var $select = $('#tipo-descarga-id', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_movimiento_add'], $current_user['privilegios'])): ?>
     $('#new-movimiento', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Movimiento', '/movimientos/add', {
             successCallback: function ( data ){
                 var $select = $('#movimiento-id', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_especie_add'], $current_user['privilegios'])): ?>
     $('#new-especie', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Especie', '/especies/add', {
             successCallback: function ( data ){
               especies.push({id: data.data.id, text: data.data.nombre})
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
     $('#new-destinatario', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Destinatario', '/auxiliares/add/destinatario', {
             successCallback: function ( data ){
                 var $select = $('select[name^="descarga_detalles"][name$="[destinatario_id]"]', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
             }
         });
     });
     <?php endif; ?>

     var numRow = 1;
     $("#new-detalle-descarga", $thisModal).click(function (e) {
         e.preventDefault();
         var delButton = '<button class="btn btn-warning btn-xs btn-delete-detalle" id="del-detalle-descarga"><i class="fa fa-trash-o"></i></button>';
         var specieSelect = '\
         <select name="descarga_detalles['+ numRow +'][especie_id]" required="required" style="width: 100%" class="input-xs" data-placeholder="Especie" placeholder="Especie" lang="es" style="width:100%">\
           <option value></option>\
         </select>';
         var quantityInputs = '';
         <?php $unidadesIdx = 0?>;
         <?php foreach($unidades as $unidad): ?>
           quantityInputs += '<td><input type="text"';
           quantityInputs += 'name="descarga_detalles['+numRow+'][unidades][<?=$unidadesIdx?>][_joinData][cantidad]"';
           quantityInputs += 'required="required" class="input-xs"';
           quantityInputs += 'placeholder="Cantidad"';
           quantityInputs += 'data-unidad-id="<?=$unidad->id?>"><span></span>';
           quantityInputs += '<?= $this->Form->input('descarga_detalles.\'+ numRow +\'.unidades.'.$unidadesIdx.'.id', ['type' => 'hidden', 'value' => $unidad->id]); ?></td>';
           <?php $unidadesIdx++; ?>
         <?php endforeach; ?>
         var zoneInput = '<input type="number" name="descarga_detalles['+numRow+'][zona_pesca]" required="required" class="input-xs" placeholder="Zona" value="'+zonaPesca+'">';
         // var zoneInput = '<select name="descarga_detalles['+numRow+'][zona_pesca_id]" required="required" class="inpu-xs" data-placeholder="Zona" placeholder="Zona" disabled="true" lang="es" style="width: 100%"><option value></option></select>';
         var destinationSelect = '\
         <select name="descarga_detalles['+numRow+'][destinatario_id]" required="required" class="form-control input-xs" data-placeholder="Destinatario" placeholder="Destinatatio" lang="es" style="width:100%">\
           <?php foreach($destinatarios as $id => $destinatario):?>\
             <option value="<?=$id?>"<?=$id==$camanchaca_id?' selected="selected"':null;?>><?=$destinatario?></option>\
           <?php endforeach; ?>\
         </select>';
         var tcsSelect = '\
         <select name="descarga_detalles['+numRow+'][tcs_id]" required="required" class="form-control input-xs" data-placeholder="Titular de Contrato de Suministro" placeholder="Titular de Contrato de Suministro" lang="es" style="width:100%">\
           <?php foreach($tcss as $id => $tcs):?>\
             <option value="<?=$id?>"<?=$id==$camanchaca_id?' selected="selected"':null;?>><?=$tcs?></option>\
           <?php endforeach; ?>\
         </select>';
         var resolutionInput = '<input type="text" name="descarga_detalles['+numRow+'][resolucion]" class="input-xs" placeholder="Nº Res.">';
         // var resolutionInput = '<select name="descarga_detalles['+numRow+'][resolucion_id]" class="input-xs" data-placeholder="Nº Res." placeholder="Nº Res." disabled="true" lang="es" style="width:100%"><option value></option></select>';

         var $tmptr = $('<tr><td>'+specieSelect+'</td>'+quantityInputs+'<td>'+zoneInput+'</td><td>'+destinationSelect+'</td><td>'+tcsSelect+'</td><td>'+resolutionInput+'</td><td class="centered">'+delButton+'</td></tr>');
         $('#detalles-table tbody').append($tmptr);
         $('select[name$="[especie_id]"]', $tmptr).select2({
           data: especies,
           dropdownParent: $thisModal
         });
         $('select:not([name$="[especie_id]"])', $tmptr).select2({
             sortResults: function(results, container, query) {
                 return results.sort(function(a,b){return a.text.localeCompare(b.text) > 0; });
             }
         });
         numRow++;
     });

     updatePrecision = function ($input) {
       var precision = $('[data-unidad-id="'+$input.data('unidadId')+'"]', $thisModal).data('precision');
       var tmpValue = Number($input.val().replace('.', '').replace(',','.')).toFixed( precision );
       if (!isFinite(tmpValue)) {
         tmpValue = 'ERROR';
       } else {
         tmpValue = tmpValue.toString().replace('.', ',');
       }
       $input.val( tmpValue );
     }

     $('#detalles-table tbody', $thisModal).on('blur', 'input[name$="[cantidad]"]', function() {
       updatePrecision( $(this) );
     });

     <?php if( count($unidades) > 1 && $recurso->id == '2'): ?>

     var updateConversion = function (unidadId, $row) {
       var conversionUnidades = '';
       var proportionAmount = 0;
       var unidad1Cantidad = 1;
       var unidad2Cantidad = 1;

       <?php foreach( $unidades as $unidad ): ?>
       if (unidadId != <?=$unidad->id?>) {
         conversionUnidades += '<b><?=$unidad->abreviacion?>/'+$('[data-unidad-id="'+unidadId+'"]').data('abreviacion')+'</b> ';
         unidad1Cantidad = Number($('[data-unidad-id="<?=$unidad->id?>"]', $row).val().replace('.', '').replace(',','.'));
         unidad2Cantidad = Number($('[data-unidad-id="'+unidadId+'"]', $row).val().replace('.', '').replace(',','.'));
         if ( !unidad1Cantidad || !unidad2Cantidad ){
           conversionUnidades += '0<br>';
         } else {
           proportionAmount = Number(unidad1Cantidad/unidad2Cantidad).toFixed(5);
           if ( !isFinite(proportionAmount) ) {
             conversionUnidades += 'ERROR<br>';
           } else {
             conversionUnidades += Number(unidad1Cantidad/unidad2Cantidad).toFixed(5).toString().replace('.', ',')+'<br>';
           }
         }
       }
       <?php endforeach; ?>

       return conversionUnidades;
     };

     var updateConversion2 = function ($row) {
       var conversionUnidades = '';
       var cantidadToneladas = Number($('[data-unidad-id="1"]', $row).val().replace('.', '').replace(',','.'));
       var cantidadCajas = Number($('[data-unidad-id="2"]', $row).val().replace('.', '').replace(',','.'));
       proportionAmount = Number(cantidadToneladas/cantidadCajas).toFixed(5);

       if ( !isFinite(proportionAmount) ) {
         conversionUnidades += 'ERROR<br>';
       } else {
         conversionUnidades += Number(cantidadToneladas*1000/cantidadCajas).toFixed(3).toString().replace('.', ',')+'<br>';
       }

       return '<b>KLS/CJS</b> ' + conversionUnidades;
     };

     $('#detalles-table tbody', $thisModal).on('focus keyup', 'tr input[name$="[cantidad]"]', function() {
       if ( $(this).data('unidadId') == 2 ) {
        var conversionText = updateConversion2( $(this).parents('tr') );
        $(this).siblings('span').html( conversionText ).show();
       }
     });
     $('#detalles-table tbody', $thisModal).on('blur', 'input[name$="[cantidad]"]', function () {
       $(this).siblings('span').hide();
     });
     <?php endif; ?>

     $('#detalles-table', $thisModal).on('click', '.btn-delete-detalle', function (e) {
         var $row = $(this).parents('tr');
         e.preventDefault();
         BootstrapDialog.confirm({
             message: "¿Seguro de borrar un detalle de descarga?",
             size: BootstrapDialog.SIZE_SMALL,
             callback: function (result) {
                 if (result) {
                     $row.remove();
                     updateTotal();
                 }
             }
         });
     });

     $('#descarga-form', $thisModal).validate({
         rules: {
             tipo_descarga_id: {
                 required: true
             },
             codigo_descarga: {
                 required: true,
                 digits: true
             },
             fecha_pesca_date: {
                 required: true
             },
             fecha_pesca_time: {
                 required: true
             },
             inicio_desembarque_date: {
                 required: true,
             },
             inicio_desembarque_time: {
                 required: true
             },
             termino_desembarque_date: {
                 required: true
             },
             termino_desembarque_time: {
                 required: true
             },
             movimiento_id: {
                 required: true,
             },
             fecha_primer_lance_date: {
                 required: false
             },
             fecha_primer_lance_time: {
                 required: false
             },
             latitud: {
               required: function (){return $('#longitud', $thisModal).val() > '' || $('#zona-primer-lance', $thisModal).val() > '';},
               latlong: true,
             },
             longitud: {
               required: function (){return $('#latitud', $thisModal).val() > '' || $('#zona-primer-lance', $thisModal).val() > '';},
               latlong: true,
             },
             zona_primer_lance: {
               required: function (){return $('#latitud', $thisModal).val() > '' || $('#longitud', $thisModal).val() > '';},
               digits: true,
             }
         }
     });
     $('[name^="descarga_detalles"]', $thisModal).rules('add', {
         required: true
     });
     $('[name^="descarga_detalles"][name$="[cantidad]"]', $thisModal).rules('add', {
         number: true
     });
     /*$('[name^="descarga_detalles"][name$="[zona_pesca_id]"]', $thisModal).rules('add', {
         required: true
     });
     $('[name^="descarga_detalles"][name$="[resolucion_id]"]', $thisModal).rules('add', {
         required: true
     });*/

     /** Activa casillas con info cuando se selecciona**/
     $('#detalles-table', $thisModal).on('change', 'select[name$="[especie_id]"]', function(e) {
       return true; // XXX: mientras no se implemente las nuevas zonas
       var $trParent = $(this).parents('tr');
       $('select[name$="[zona_pesca_id]"]', $trParent).prop("disabled", true);
       $('select[name$="[resolucion_id]"]', $trParent).prop("disabled", true);
       $.ajax({
         url: '/api/zonas_pesca/obtenerPorEspecie.json?especie=' + $(this).val(),
         type: 'GET',
         dataType: 'json'
       })
       .done(function (data) {
         var zonasPesca = [];
         $.each(data.zonas_pesca, function(i, zona_pesca) {
           zonasPesca.push({id: zona_pesca.id, text: zona_pesca.nombre});
         });
         if (zonasPesca.length) {
           $('select[name$="[zona_pesca_id]"]', $trParent).prop("disabled", false);
           $('select[name$="[zona_pesca_id]"]', $trParent).select2({
             data: zonasPesca,
             dropdownParent: $thisModal,
           });
         } else {
           errorNotify("No existen Zonas de Pesca disponibles para la especie seleccionada.");
         }
       });
     });
     $('#detalles-table', $thisModal).on('change', 'select[name$="[zona_pesca_id]"]', function() {
         var $trParent = $(this).parents('tr');
         var especie_id = $('select[name$="[especie_id]"]', $trParent).val();
         $('select[name$="[resolucion_id]"]', $trParent).prop('disabled', true);
         $.ajax({
           url: '/api/licencias.json',
           type: 'GET',
           dataType: 'json',
           data: {
               estado: 'ACTIVO',
               especie: especie_id,
               zona_pesca: $(this).val(),
               disponible: true, // muestra solo licencias con cantidad disponible
               cantidad_disponible: true
           }
         })
         .done(function (data) {
           var resoluciones = [];
           $.each(data.licencias, function(i, licencia) {
             resoluciones.push({id: licencia.id,
                                text: '**' + licencia.display_name + '**\\Disp. ' + toggleNumberFormat(licencia.cantidad_disponible) + ' TON',
                                cantidad_disponible: licencia.cantidad_disponible});
           });
           if (resoluciones.length) {
             $('select[name$="[resolucion_id]"]', $trParent).prop("disabled", false);
             $('select[name$="[resolucion_id]"]', $trParent).select2({
               data: resoluciones,
               dropdownParent: $thisModal,
               dropdownCssClass : 'select2-bigdropdown',
               templateResult: formatSelect2Items,
               templateSelection: formatSelectionSelect2Items
             });
           } else {
             errorNotify("No existen Resoluciones disponibles para la especie y zona seleccionada.");
           }
         });
     });

     // Solo se pueden asignar resoluciones con suficiente cantidad disponible
     $('#detalles-table', $thisModal).on('change', 'select[name$="[resolucion_id]"]', function(e) {
         var licencia_id = $(this).val();
         var $trParent = $(this).parents('tr');
         var $cantidadInput = $('input[name$="[cantidad]"]', $trParent);
         if ($cantidadInput.val()) {
             var cantidad = toggleNumberFormat($cantidadInput.val());
             var cantidadDisponible = $(this).select2('data')[0].cantidad_disponible;

             if (cantidadDisponible < cantidad) {
                 errorNotify('No se puede asignar la resolucion seleccionada, pues no dispone de suficiente cuota disponible.');
                 $(this).val('').trigger('change');
             }
         }
     });

     $('#detalles-table', $thisModal).on('blur', 'input[name$="[cantidad]"]', function () {
         // TODO(@dcampos): queda pendiente validar en caso de ser necesario los cambios en la cantidad.
     });
 });
</script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $descargaEncabezado->errors(),
        'data' => $descargaEncabezado
    ]);
}
?>
