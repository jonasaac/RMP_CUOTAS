<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-md-12">
          <form id="nave-form" class="form-horizontal">
            <legend>Nave</legend>
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control input-xs" name="nombre" id="nombre" placeholder="Ingrese el nombre"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Régimen</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="regimen_id" id="regimen-id" data-placeholder="Seleccione el régimen de la nave" style="width:100%">
                                    <option value></option>
                                    <?php foreach($regimenes as $id => $regimen): ?>
                                        <option value="<?=$id?>"><?=$regimen?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                  <?php if (array_in_array(['admin_regimen_add'], $current_user['privilegios'])): ?>
                                    <a id="new-regimen" class="btn btn-default input-xs">Nuevo</a>
                                  <?php else: ?>
                                    <a id="new-regimen" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Matricula</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control input-xs" name="matricula" id="matricula" placeholder="Ingrese el matricula"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Señal Distintiva</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-5">
                                <select id="senal-tipo" name="senal_tipo" class="input-xs form-control" data-placeholder="Tipo" style="width:100%">
                                    <option value></option>
                                    <option value="CB">CB</option>
                                    <option value="CA">CA</option>
                                </select>
                                </div>
                                <div class="col-sm-7">
                                    <input name="senal_nro" id="senal-nro" type="text" class="input-xs form-control" placeholder="Ingrese la señal distintiva">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">RPI/RPA</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control input-xs" name="registro_pesca" id="registro-pesca" placeholder="Ingrese el registro de pesca"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Zona de Operación</label>
                    <div class="col-sm-9">
                      <select class="form-control input-xs" name="zona_operacion_id" id="zona-operacion-id" data-placeholder="Seleccione la zona de operación" style="width:100%">
                          <option value></option>
                          <?php foreach($zonaOperaciones as $id => $zonaOperacion): ?>
                              <option value="<?=$id?>"><?=$zonaOperacion?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Armador</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="armador_id" id="armador-id" data-placeholder="Seleccione el armador de la nave" style="width:100%">
                                    <option value></option>
                                    <?php foreach($armadores as $id => $armador): ?>
                                        <option value="<?=$id?>"><?=$armador?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                  <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                                    <a id="new-armador" class="btn btn-default input-xs">Nuevo</a>
                                  <?php else: ?>
                                    <a id="new-armador" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Representante</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="representante_id" id="representante-id" data-placeholder="Seleccione el representante de la nave" style="width:100%">
                                    <option value></option>
                                    <?php foreach($representantes as $id => $representante): ?>
                                        <option value="<?=$id?>"><?=$representante?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                  <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                                    <a id="new-representante" class="btn btn-default input-xs">Nuevo</a>
                                  <?php else: ?>
                                    <a id="new-representante" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Capitán</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="capitan_id" id="capitan-id" data-placeholder="Seleccione el capitán de la nave" style="width:100%">
                                    <option value></option>
                                    <?php foreach($capitanes as $id => $capitan): ?>
                                        <option value="<?=$id?>"><?=$capitan?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                  <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                                    <a id="new-capitan" class="btn btn-default input-xs">Nuevo</a>
                                  <?php else: ?>
                                    <a id="new-capitan" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sindicato</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="sindicato_id" id="sindicato-id" data-placeholder="Seleccione el sindicato de la nave" style="width:100%">
                                    <option value></option>
                                    <?php foreach($sindicatos as $id => $sindicato): ?>
                                        <option value="<?=$id?>"><?=$sindicato?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                  <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                                    <a id="new-sindicato" class="btn btn-default input-xs">Nuevo</a>
                                  <?php else: ?>
                                    <a id="new-sindicato" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Recursos</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="recursos[_ids]" class="form-control input-xs" value="">
                            <?php
                            foreach ($recursos as $id => $recurso):
                            echo '<div class="checkbox"><label for="recursos-ids-'.$id.'">'.
                                 ($id == $this->request->session()->read('recurso.id') ? '<input type="hidden" name="recursos[_ids][]" value="'.$id.'">' : '').
                                 '<input type="checkbox" name="recursos[_ids][]" value="'.$id.'" id="recursos-ids-'.$id.'"'.
                                 ($id == $this->request->session()->read('recurso.id') ? ' checked="checked" disabled="disabled"' : '').
                                 '>'.
                                 '<span class="text">'.$recurso.'</span></label></div>';
                            endforeach;
                            echo '<span class="form-control-feedback"></span>';?>
                        </div>
                    </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-md-12 areas-div">
                    <legend>Areas</legend>
                  </div>
                  <div class="col-md-12 areas-div">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Areas</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="areas[_ids]" value="">
                        <select class="form-control input-xs"
                                name="areas[_ids][]"
                                id="areas-ids"
                                data-placeholder="Seleccione las areas"
                                multiple="multiple"
                                lang="es"
                                style="width:100%">
                            <option value></option>
                            <?php foreach($areas as $id => $area): ?>
                                <option value="<?=$id?>"><?=$area?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 capacidad-div">
                      <legend>Capacidad</legend>
                  </div>
                  <div class="capacidad-div" id="capacidad">
                      <div class="col-md-12 button-group">
                          <?= $this->Form->button(__('Agregar Unidad'), ['id' => 'addUnidadBtn', 'class' => 'btn']) ?>
                          <?php if (array_in_array(['admin_unidad_add'], $current_user['privilegios'])): ?>
                          <a id="new-unidad" class="btn btn-default input-xs">Nueva Unidad</a>
                          <?php else: ?>
                            <a id="new-unidad" class="btn btn-default input-xs" disabled="disabled">Nueva Unidad</a>
                          <?php endif; ?>
                      </div>
                      <div id="unidades-div" class="col-md-12">
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Capacidad</label>
                              <div class="col-sm-9">
                                <input class="form-control input-xs"
                                       name="unidades[0][_joinData][capacidad]"
                                       id="unidades-0-joindata-capacidad"
                                       placeholder="Ingrese una capacidad"/>
                              </div>
                            </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Unidad</label>
                                <div class="col-sm-9">
                                  <select class="form-control input-xs"
                                          name="unidades[0][id]"
                                          id="unidades-0-id"
                                          data-placeholder="Seleccione una unidad">
                                      <option value></option>
                                      <?php foreach($unidades as $id => $unidad): ?>
                                          <option value="<?=$id?>"><?=$unidad?></option>
                                      <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                              </div><div class="col-md-2 centered">
                          <?php
                          echo $this->Form->button('<i class="fa fa-trash-o"></i>', ['class' => 'btn btn-warning btn-delete-unidad', 'escape' => false]);
                          ?>
                          </div>
                        </div>
                        <?php $numUnidades = 1; ?>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 bodegas-div">
                      <legend>Bodegas</legend>
                  </div>
                  <div class="bodegas-div">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Nro. Bodegas</label>
                          <div class="col-sm-9">
                            <select class="form-control input-xs"
                                    name="nro_bodegas"
                                    id="nro-bodegas">
                                <?php foreach(range(0, 15) as $bodegas): ?>
                                    <option value="<?=$bodegas?>"<?=$bodegas==1?' selected="selected"':null?>><?=$bodegas?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8" id="bodegas-div">
                          <div class="row">
                              <div class="col-md-4">
                                  <?php $nroBodega = 1; ?>
                                  <?= $this->Form->input('bodegas.0.nro', ['type' => 'hidden', 'value' => $nroBodega]) ?>
                                  <div class="control-label pull-right">
                                    <?= 'Bodega '.$nroBodega.': '?>
                                  </div>
                              </div>
                              <div class="col-md-8">
                                <div class="form-group">
                                  <label class="col-sm-3 control-label">Capacidad</label>
                                  <div class="col-sm-9">
                                    <div class="input-container">
                                    <input type="text" class="form-control input-xs"
                                           name="bodegas[0][capacidad]"
                                           id="bodegas-0-capacidad"
                                           placeholder="Ingrese una capacidad para la bodega"/>
                                           <label>M<sup>3</sup></label>
                                         </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $thisModal.parents('.modal-dialog').addClass('modal-lg');

     $('#regimen-id').on('change', function() {
         if ($(this).val() == '1') {
             $('#zona-operacion-id').parents('div:has(>.form-group)').hide();
             $('#sindicato-id').parents('div:has(>.form-group)').hide();
             $('.capacidad-div, .bodegas-div').show();
         } else if($(this).val() == '2') {
             $('#zona-operacion-id').parents('div:has(>.form-group)').show();
             $('#sindicato-id').parents('div:has(>.form-group)').show();
             $('.capacidad-div, .bodegas-div').hide();
         }
     })

     // new modals
     <?php if (array_in_array(['admin_regimen_add'], $current_user['privilegios'])): ?>
     $('#new-regimen', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Régimen', '/regimenes/add', {
             successCallback: function ( data ){
                 var $select = $('#regimen-id', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });
     <?php endif; ?>
     <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
     $('#new-armador', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Armador', '/auxiliares/add/armador', {
             successCallback: function ( data ){
                 $.each(data.data.funciones, function (i, v) {
                     var $select = $('[name="'+v+'_id"]');
                     $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
                 });
             }
         });
     });
     $('#new-representante', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Representante', '/auxiliares/add/representante', {
             successCallback: function ( data ){
                 $.each(data.data.funciones, function (i, v) {
                     var $select = $('[name="'+v+'_id"]');
                     $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
                 });
             }
         });
     });
     $('#new-capitan', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Capitán', '/auxiliares/add/capitan', {
             successCallback: function ( data ){
                 $.each(data.data.funciones, function (i, v) {
                     var $select = $('[name="'+v+'_id"]');
                     $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
                 });
             }
         });
     });
     $('#new-sindicato', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Sindicato', '/auxiliares/add/sindicato', {
             successCallback: function ( data ){
                 $.each(data.data.funciones, function (i, v) {
                     var $select = $('[name="'+v+'_id"]');
                     $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
                 });
             }
         });
     });
     <?php endif; ?>
     <?php if (array_in_array(['admin_unidad_add'], $current_user['privilegios'])): ?>
     $('#new-unidad', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Unidad', '/unidades/add', {
             successCallback: function ( data ){
                 var $select = $('select[name^="unidades"]', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });
     <?php endif; ?>
     // end new modals

     // Se convierten a select2 los inputs correspondientes

     $('#regimen-id, #armador-id, #representante-id, #senal-tipo', $thisModal).select2({dropdownParent: $thisModal, language: "es"});
     $('select[id^="unidad"], #nro-bodegas', $thisModal).select2({dropdownParent: $thisModal, language: "es"});
     $('#zona-operacion-id, #sindicato-id', $thisModal).select2({dropdownParent: $thisModal, language: "es", allowClear: true});
     $('#areas-ids', $thisModal).select2({dropdownParent: $thisModal, language: "es"})
     capitanes = [];
     $.ajax({
       url: '/api/auxiliares/listar_filtrado.json?funcion=capitan',
       type: 'GET',
       dataType: 'json'
     })
     .done(function (data) {
       $.each(data.auxiliares, function(i, capitan) {
         capitanes.push({id: i, text: capitan});
       });
       $('#capitan-id', $thisModal).select2({
         dropdownParent: $thisModal,
         data: capitanes
       });
     });
     $('#capitan-id', $thisModal).select2();

     var numUnidades = <?= $numUnidades ?>;
     $('#addUnidadBtn').click(function (event) {
         event.preventDefault();
         var inputCapacidad = '\
           <div class="form-group">\
             <label class="col-sm-3 control-label">Capacidad</label>\
             <div class="col-sm-9">\
               <input class="form-control input-xs"\
                      name="unidades['+numUnidades+'][_joinData][capacidad]"\
                      id="unidades-'+numUnidades+'-joindata-capacidad"\
                      placeholder="Ingrese una capacidad"/>\
             </div>\
           </div>';
         var inputUnidad = '<div class="form-group"><label class="col-sm-3 control-label">Unidad</label><div class="col-sm-9"><select class="form-control input-xs" name="unidades['+numUnidades+'][id]" id="unidades-'+numUnidades+'-id" data-placeholder="Seleccione una unidad">';
         inputUnidad += '<option value></option>';
         <?php foreach($unidades as $id => $unidad): ?>
         inputUnidad += '<option value="<?=$id?>"><?=$unidad?></option>';
         <?php endforeach; ?>
         inputUnidad += '</select></div></div>';
         var deleteBtn = '<?= $this->Form->button('<i class="fa fa-trash-o"></i>', ['class' => 'btn btn-warning btn-delete-unidad', 'escape' => false]) ?>';
         $('#unidades-div').append('<div class="row"><div class="col-md-5">'+inputCapacidad+'</div><div class="col-md-5">'+inputUnidad+'</div><div class="col-md-2 centered">'+deleteBtn+'</div></div>');
         numUnidades++;

         $('#unidades-div select', $thisModal).select2({dropdownParent: $thisModal, language: "es"});
         $('input[name^="unidades"][name$="[capacidad]"]', $thisModal).rules('add', {
             required: true,
             number: true
         });
         $('select[name^="unidades"]', $thisModal).rules('add', {
             required: function (element) {
                 return $('#regimen-id', $thisModal).val() == '1';
             }
         });
     });

     $('#unidades-div').on('click', '.btn-delete-unidad', function (event) {
         event.preventDefault();
         $(this).parents('#unidades-div > .row').remove();
         numUnidades--;
     });

     var nroBodegas = $('#nro-bodegas').val();
     var nroBodega = <?= $nroBodega ?>;
     var bodegaIdx = 0;
     $('#nro-bodegas').change(function () {
         var newNroBodegas = $(this).val();
         if (nroBodegas !== newNroBodegas) {
             if(nroBodegas > newNroBodegas) {
                 for( var i=0; i<nroBodegas-newNroBodegas; i++) {
                     bodegaIdx -= 1;
                     $('#bodegas-div > div:last-child').remove();
                     nroBodega -= 1;
                 }
             } else {
                 for( var i=0; i<newNroBodegas-nroBodegas; i++) {
                     bodegaIdx += 1;
                     nroBodega += 1;
                     var inputNro = '<?=$this->Form->input('bodegas.\'+bodegaIdx+\'.nro', ['type' => 'hidden', 'value' => '\'+nroBodega+\'', 'id' => 'bodegas-\'+bodegaIdx+\'-nro', 'escape' => false]) ?>';
                     var textNro = 'Bodega '+nroBodega+': ';
                     var inputCapacidad = '<?=$this->Form->input('bodegas.\'+bodegaIdx+\'.capacidad', ['type' => 'text', 'required' => 'required', 'id' => 'bodegas-\'+bodegaIdx+\'-capacidad', 'escape' => false, 'placeholder' => 'Ingrese una capacidad para la bodega']) ?>';
                     var inputCapacidad = '\
                      <div class="form-group">\
                        <label class="col-sm-3 control-label">Capacidad</label>\
                         <div class="col-sm-9">\
                           <div class="input-container">\
                           <input type="text"\
                                  class="form-control input-xs"\
                                  name="bodegas['+bodegaIdx+'][capacidad]"\
                                  id="bodegas-'+bodegaIdx+'-capacidad"\
                                  placeholder="Ingrese una capacidad para la bodega"/>\
                                  <label>M<sup>3</sup></label>\
                                </div>\
                         </div>\
                       </div>';
                     $('#bodegas-div').append('<div class="row"><div class="col-md-4">'+inputNro+'<div class="control-label pull-right">'+textNro+'</div></div><div class="col-md-8">'+inputCapacidad+'</div></div>');
                 }

                 $('input[name^="bodegas"]').rules('add', {
                     required: true,
                     number: true
                 });
             }
             nroBodegas = newNroBodegas;
         }
     });

     $('[id^="recursos"]').helptooltip({
         'title': 'Recursos a los que estará asociada la nave'
     });
     $('[id^="unidades"][id$="capacidad"]').helptooltip({
         'title': 'Capacidad escrita con tres decimales. ej: 123,456'
     });

     // validacion formulario
     $('#nave-form', $thisModal).validate({
         rules: {
             nombre: {
                 required: true,
                 minlength: 2
             },
             regimen_id: {
                 required: true
             },
             matricula: {
                 required: true,
                 minlength: 4 // TODO: Revisar puede que tenga un largo especifico
             },
             senal_tipo: {
                 required: true
             },
             senal_nro: {
                 required: true,
                 minlength: 2
             },
             registro_pesca: {
                 minlength: 2
             },
             zona_operacion_id: {
                 required: function () {
                     return $('#regimen-id').val() == '2';
                 }
             },
             armador_id: {
                 required: true
             },
             sindicato_id: {
                 required: function () {
                     return $('#regimen-id').val() == '2';
                 }
             },
             representante_id: {
                 required: true
             }
         }
     });
     $('input[name^="unidades"][name$="[capacidad]"]', $thisModal).rules('add', {
         required: function() {
             return $('#regimen-id').val() == '1';
         },
         number: true
     });
     $('select[name^="unidades"]', $thisModal).rules('add', {
         required: function (element) {
             return $('#regimen-id', $thisModal).val() == '1';
         }
     });
     $('input[name^="bodegas"]', $thisModal).rules('add', {
         required: true,
         number: true
     });
 });
</script>
<?php
    } else {
        echo json_encode([
            'status' => $status,
            'errors' => $nave->errors(),
            'data' => $nave
        ]);
    }
?>
