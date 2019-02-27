<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
  <div class="col-md-12">
    <form id="nave-form" class="form-horizontal">
      <legend>Nave - <?=$nave->nombre?></legend>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-9">
              <input
                class="form-control input-xs"
                name="nombre" id="nombre"
                style="width: 100%"
                placeholder="Ingrese el Nombre" value="<?=$nave->nombre?>"/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Régimen</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="regimen_id"
                    style="width: 100%"
                    id="regimen-id"
                    data-placeholder="Seleccione el régimen de la nave">
                  <option value></option>
                  <?php foreach($regimenes as $id => $regimen): ?>
                      <option value="<?=$id?>"<?=$id==$nave->regimen_id?' selected="selected"':''?>><?=$regimen?></option>
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
              <input class="form-control input-xs" name="matricula"
                style="width: 100%"
                id="matricula" placeholder="Ingrese el matricula"
                value="<?=$nave->matricula?>"/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <?php
            $senal_distintiva = explode('-', $nave->senal_distintiva);
          ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Señal Distintiva</label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-5">
                  <select id="senal-tipo" name="senal_tipo" style="width: 100%"
                    class="input-xs form-control" data-placeholder="Tipo">
                    <option value></option>
                    <?php foreach(['CB', 'CA'] as $senal):?>
                      <option value="<?=$senal?>"<?=$senal==$senal_distintiva['0']?' selected="selected"':''?>><?=$senal?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="col-sm-7">
                  <input name="senal_nro" id="senal-nro"
                    type="text" class="input-xs form-control" style="width: 100%"
                   value="<?=$senal_distintiva['1']?>"  placeholder="Ingrese la señal distintiva">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">RPI/RPA</label>
            <div class="col-sm-9">
              <input class="form-control input-xs" name="registro_pesca"
              id="registro-pesca" style="width: 100%"
              placeholder="Ingrese el registro de pesca"
              value="<?=$nave->registro_pesca?>"/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Zona de Operación</label>
            <div class="col-sm-9">
              <select class="form-control input-xs"
                name="zona_operacion_id" style="width: 100%"
                id="zona-operacion-id" data-placeholder="Seleccione la zona de operación">
                  <option value></option>
                  <?php foreach($zonaOperaciones as $id => $zonaOperacion): ?>
                      <option value="<?=$id?>"<?=$nave->zona_operacion_id==$id?' selected="selected"':null;?>><?=$zonaOperacion?></option>
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
                <select class="form-control input-xs" name="armador_id"
                id="armador-id"
                style="width: 100%"
                data-placeholder="Seleccione el armador de la nave">
                  <option value></option>
                  <?php foreach($armadores as $id => $armador): ?>
                      <option value="<?=$id?>"<?=$id==$nave->armador_id?' selected="selected"':''?>><?=$armador?></option>
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
                <select class="form-control input-xs"
                name="representante_id"
                style="width: 100%"
                id="representante-id" data-placeholder="Seleccione el representante de la nave">
                  <option value></option>
                  <?php foreach($representantes as $id => $representante): ?>
                      <option value="<?=$id?>"<?=$id==$nave->representante_id?' selected="selected"':''?>><?=$representante?></option>
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
                <select class="form-control input-xs" name="capitan_id"
                style="width: 100%"
                id="capitan-id" data-placeholder="Seleccione el capitán de la nave">
                  <option value></option>
                  <?php foreach($capitanes as $id => $capitan): ?>
                      <option value="<?=$id?>"<?=$id==$nave->capitan_id?' selected="selected"':''?>><?=$capitan?></option>
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
                        <select class="form-control input-xs"
                        style="width: 100%"
                        name="sindicato_id" id="sindicato-id" data-placeholder="Seleccione el sindicato de la nave">
                            <option value></option>
                            <?php foreach($sindicatos as $id => $sindicato): ?>
                                <option value="<?=$id?>"<?=$id==$nave->sindicato_id?' selected="selected"':''?>><?=$sindicato?></option>
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
                     '<input type="checkbox" name="recursos[_ids][]" value="'.$id.'" id="recursos-ids-'.$id.'"'.
                         (in_array($id, $nave->recursos_ids) ? ' checked="checked"' : '').
                     '>'.
                     '<span class="text">'.$recurso.'</span></label></div>';
              endforeach;
              ?>
              <span class="form-control-feedback"></span><p class="help-block"></p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3 control-label">Estado</label>
                <div class="col-sm-9">
                    <select class="form-control input-xs"
                    style="width: 100%"
                    name="estado_id" id="estado-id" placeholder="Seleccione una Ciudad" lang="es">
                      <option></option>
                      <?php foreach($estados as $id => $estado): ?>
                        <option value="<?=$id?>" <?= $nave->estado_id == $id ? 'selected="selected"':'' ?>><?=$estado?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
          <?php
            $areas_ids = [];
            foreach ($nave->areas as $area) {
              $areas_ids[] = $area->id;
              }
          ?>
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
                      style="width: 100%"
                      data-placeholder="Seleccione las areas"
                      multiple="multiple" lang="es">
                  <option value></option>
                  <?php foreach($areas as $id => $area): ?>
                    <option "<?=$id?>"<?=in_array($id, $areas_ids)?' selected="selected"':''?>><?=$area?></option>
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
            <?php
            $numUnidades = 0;
            if(!empty($nave->unidades)):
              foreach ($nave->unidades as $unidad): ?>
                <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Capacidad</label>
                        <div class="col-sm-9">
                          <input class="form-control input-xs"
                                    id = "unidades-<?=$numUnidades?>-joindata-capacidad"
                                    name = "unidades[<?=$numUnidades?>][_joinData][capacidad]"
                                    placeholder="Ingrese una capacidad"
                                    value="<?=$unidad->_joinData->capacidad?>"/>
                        </div>
                      </div>
                    </div>
                <div class="col-md-5">
                <?php
                echo $this->Form->input('unidades.'.$numUnidades.'.id', ['label' => 'Unidad', 'type' => 'select', 'options' => $unidades]);
                echo '</div><div class="col-md-2">';
                echo $this->Form->button('<i class="fa fa-trash-o"></i>', ['class' => 'btn btn-warning btn-delete-unidad']);
                echo '</div></div>';
                $numUnidades++;
                ?>
            <?php endforeach; endif;?>
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
                          style="width: 100%"
                          name="nro_bodegas"
                          id="nro-bodegas">
                      <?php foreach(range(0, 15) as $bodegas): ?>
                          <option value="<?=$bodegas?>"<?=$bodegas==count($nave->bodegas)?' selected="selected"':null?>><?=$bodegas?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

          <div class="col-md-8" id="bodegas-div">
            <?php
            $bodegasIdx = 0;
            if(!empty($nave->bodegas))
              foreach ($nave->bodegas as $bodega){
                echo '<div class="row">';
                echo '<div class="col-md-3">';
                echo $this->Form->input('bodegas.'.$bodegasIdx.'.id');
                echo $this->Form->input('bodegas.'.$bodegasIdx.'.nro', ['type' => 'hidden', 'value' => $bodega->nro]);
                echo 'Bod. '.$bodega->nro;
                echo '</div><div class="col-md-7">';
                echo $this->Form->input('bodegas.'.$bodegasIdx.'.capacidad', ['type' => 'text', 'value' => $this->Number->precision($bodega->capacidad,3)]);
                echo '</div><div class="col-md-1"><strong>M<sup>3</sup></strong></div></div>';
                $bodegasIdx++;
              }
            ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $('select').select2({
         dropdownParent : $thisModal
     })
     $thisModal.parents('.modal-dialog').addClass('modal-lg');

     $('#regimen-id, #armador-id, #representante-id, #senal-tipo', $thisModal).select2({dropdownParent: $thisModal, language: "es"});
     $('select[id^="unidad"], #nro-bodegas', $thisModal).select2({dropdownParent: $thisModal, language: "es"});
     $('#capitan-id, #zona-operacion-id, #sindicato-id', $thisModal).select2({dropdownParent: $thisModal, language: "es", allowClear: true});
     $('#areas-ids', $thisModal).select2({dropdownParent: $thisModal, language: "es"})

     if ($('#regimen-id').val() == '1') {
         $('#zona-operacion-id').parents('div:has(>.form-group)').hide();
         $('#sindicato-id').parents('div:has(>.form-group)').hide();
         $('.capacidad-div, .bodegas-div').show();
     } else if($('#regimen-id').val() == '2') {
         $('#zona-operacion-id').parents('div:has(>.form-group)').show();
         $('#sindicato-id').parents('div:has(>.form-group)').show();
         $('.capacidad-div, .bodegas-div').hide();
     }

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

     var numUnidades = <?=count($nave->unidades)?>;
     $('#addUnidadBtn').click(function (event) {
         event.preventDefault();
         var inputCapacidad = '<div class="form-group">\
             <label class="col-sm-3 control-label">Capacidad</label>\
             <div class="col-sm-9">\
               <input class="form-control input-xs"\
                         id = "unidades-'+numUnidades+'-joindata-capacidad"\
                         name = "unidades['+numUnidades+'][_joinData][capacidad]"\
                         placeholder="Ingrese una capacidad"/>\
             </div>\
           </div>';
         var inputUnidad = '<div class="form-group"><label class="col-sm-3 control-label">Unidad</label><div class="col-sm-9"><select class="form-control input-xs" name="unidades['+numUnidades+'][id]" id="unidades-'+numUnidades+'-id" data-placeholder="Seleccione una unidad">';
         inputUnidad += '<option value></option>';
         <?php foreach($unidades as $id => $unidad): ?>
         inputUnidad += '<option value="<?=$id?>"><?=$unidad?></option>';
         <?php endforeach; ?>
         inputUnidad += '</select></div></div>';
         var deleteBtn = '<?= $this->Form->button('<i class="fa fa-trash-o"></i>', ['class' => 'btn btn-warning btn-delete-unidad']) ?>';
         $('#unidades-div').append('<div class="row"><div class="col-md-5">'+inputCapacidad+'</div><div class="col-md-5">'+inputUnidad+'</div><div class="col-md-2">'+deleteBtn+'</div></div>');
         numUnidades++;

         $('#unidades-div select', $thisModal).select2({dropdownParent: $thisModal, language: 'es'});
         $('[id^="unidades"][id$="capacidad"]', $thisModal).rules('add', {
             required: true,
             number: true
         });
         $('[id^="unidades"][id$="id"]', $thisModal).rules('add', {
             required: true
         });
     });

     $('#unidades-div').on('click', '.btn-delete-unidad', function (event) {
         event.preventDefault();
         $(this).parents('#unidades-div > .row').remove();
         numUnidades--;
     });

     var nroBodegas = $('#nro-bodegas').val();
     var nroBodega = <?= count($nave->bodegas) ?>;
     var bodegaIdx = <?= isset($bodegasIdx)?$bodegasIdx:0 ?>;
     $('#nro-bodegas').change(function () {
         var newNroBodegas = $(this).val();
         if (nroBodegas !== newNroBodegas) {
             if(nroBodegas > newNroBodegas) {
                 for( var i=0; i<nroBodegas-newNroBodegas; i++) {
                     bodegaIdx -= 1;
                     $('#bodegas-div > div:last-child').remove();
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

                 $('[id^="bodegas"][id$="capacidad"]', $thisModal).rules('add', {
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
             sindicato_id: {
                 required: function () {
                     return $('#regimen-id').val() == '2';
                 }
             },
             armador_id: {
                 required: true
             },
             representante_id: {
                 required: true
             }
         }
     });

     <?php if(count($nave->unidades) > 0): ?>
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
     <?php endif; ?>
     <?php if(count($nave->bodegas) > 0): ?>
     $('input[name^="bodegas"]', $thisModal).rules('add', {
         required: true,
         number: true
     });
     <?php endif; ?>
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
