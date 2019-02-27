<?php
$this->layout = 'ajax';
if (!$this->request->is(['patch', 'post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <?= $this->Form->create($marea, ['id' => 'marea-form']) ?>
        <legend>Marea - <?=$marea->nave->nombre?> - <?=ConvertirFecha($marea->fecha_zarpe->toUnixString())?></legend>
        <div class="form-group">
            <label class="col-sm-3 control-label">Nave</label>
            <div class="col-sm-9">
                    <div class="input-group">
                    <select class="form-control input-xs" name="nave_id" id="nave-id" placeholder="Seleccione una Nave">
                        <option></option>
                        <?php foreach($naves as $nave): ?>
                            <option value="<?=$nave->id?>"<?=$nave->id==$marea->nave_id ? ' selected="selected"':''?>
                              data-recursos="<?= '['.implode(',', $nave->recursos_ids).']'?>">
                              <?=$nave->nombre?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-btn">
                    <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                        <a id="new-nave" class="btn btn-default input-xs">Nueva</a>
                      <?php else: ?>
                        <a id="new-nave" class="btn btn-default input-xs" disabled>Nueva</a>
                    <?php endif; ?>
                    </div>
                    </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Arte de Pesca</label>
            <div class="col-sm-9">
                    <div class="input-group">
                <select class="form-control input-xs" name="arte_pesca_id" id="arte-pesca-id" placeholder="Seleccione el arte de pesca">
                    <option></option>
                    <?php foreach($artePesca as $arte_pesca): ?>
                        <option value="<?=$arte_pesca->id?>"<?=$arte_pesca->id==$marea->arte_pesca_id ? 'selected="selected"':''?>
                          data-recurso-id="<?=$arte_pesca->recurso_id?>">
                          <?=$arte_pesca->nombre?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="recurso-id" name="recurso_id" value="<?=$marea->recurso_id?>">
                    <div class="input-group-btn">
                <?php if(array_in_array(['admin_artePesca_add'], $current_user['privilegios'])): ?>
                        <a id="new-arte-pesca" class="btn btn-default input-xs">Nuevo</a>
                      <?php else: ?>
                        <a id="new-arte-pesca" class="btn btn-default input-xs" disabled>Nuevo</a>
                <?php endif; ?>
                    </div>
                    </div>
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Fecha de Zarpe</label>
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-7">
                <div class="input-group input-group-xs date-picker" id="fecha-zarpe-date-container">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input name="fecha_zarpe_date" id="fecha-zarpe-date" type="text" class="form-control">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="input-group input-group-xs time-picker" id="fecha-zarpe-time-container">
                  <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                  <input name="fecha_zarpe_time" id="fecha-zarpe-time" type="text" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
     <div class="form-group">
            <label class="col-sm-3 control-label">Capitán</label>
            <div class="col-sm-9">
                    <div class="input-group">
                    <select class="form-control input-xs" name="capitan_id" id="capitan-id" placeholder="Seleccione un Capitán">
                        <option></option>
                        <?php foreach($capitanes as $id => $capitan): ?>
                            <option value="<?=$id?>"<?=$id==$marea->capitan_id ? ' selected="selected"':''?>><?=$capitan?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-btn">
                    <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                        <a id="new-capitan" class="btn btn-default input-xs">Nuevo</a>
                      <?php else: ?>
                        <a id="new-capitan" class="btn btn-default input-xs" disabled>Nuevo</a>
                    <?php endif; ?>
                    </div>
                    </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Puerto Zarpe</label>
            <div class="col-sm-9">
                    <div class="input-group">
                    <select class="form-control input-xs" name="puerto_id" id="puerto-id" placeholder="Seleccione un Puerto">
                        <option></option>
                        <?php foreach($puertos as $id => $puerto): ?>
                            <option value="<?=$id?>"<?=$id==$marea->puerto_id ? ' selected="selected"':''?>><?=$puerto?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-btn">
                    <?php if(array_in_array(['admin_puerto_add'], $current_user['privilegios'])): ?>
                        <a id="new-puerto" class="btn btn-default input-xs">Nuevo</a>
                      <?php else: ?>
                        <a id="new-puerto" class="btn btn-default input-xs" disabled>Nuevo</a>
                    <?php endif; ?>
                    </div>
                    </div>
            </div>
        </div>
        <?php
        echo $this->Form->input('observaciones');
        ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $('#nave-id, #capitan-id, #puerto-id, #arte-pesca-id', $thisModal).select2();

     $('#fecha-zarpe-date', $thisModal).val( moment.utc('<?=$marea->fecha_zarpe->format(DateTime::ISO8601)?>').format('DD-MMM-YYYY') );
     $('#fecha-zarpe-date-container', $thisModal).datetimepicker(dateOptions());
     $('#fecha-zarpe-time', $thisModal).val( moment.utc('<?=$marea->fecha_zarpe->format(DateTime::ISO8601)?>').format('HH:mm') );
     $('#fecha-zarpe-time-container', $thisModal).datetimepicker(timeOptions());

     <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
     $('#new-nave', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Nave', '/naves/add', {
             successCallback: function ( data ){
                 var $select = $('#nave-id');
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_artePesca_add'], $current_user['privilegios'])): ?>
     $('#new-arte-pesca', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Arte de Pesca', '/arte_pesca/add', {
             successCallback: function ( data ){
                 var $select = $('#arte-pesca-id', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
     $('#new-capitan', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Capitan', '/auxiliares/add/capitan', {
             successCallback: function ( data ){
                 var $select = $('[name="capitan_id"]');
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_puerto_add'], $current_user['privilegios'])): ?>
     $('#new-puerto', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Puerto', '/puertos/add', {
             successCallback: function ( data ){
                 var $select = $('#puerto-id');
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>

     /**
      * Al cambiar una nave se habilitan y/o desabilitan
      * los tipos de arte de pesca correspondientes
      */
     $('#nave-id', $thisModal).on('change', function (e) {
         var naveRecursos = $(this).find(':selected').data('recursos');
         $('select#arte-pesca-id option', $thisModal).each(function (i, val) {
           if ( $(this).text().length == 0 || $.inArray($(this).data('recursoId'), naveRecursos) !== -1 ) {
             $(this).prop('disabled', false);
           } else {
             $(this).prop('disabled', 'disabled');
           }
         });
     });
     $('#nave-id', $thisModal).trigger('change');

     $('#arte-pesca-id').on('change', function (e) {
       $('#recurso-id').val( $('option:selected', $(this)).data('recursoId') );
     });

     $('#marea-form', $thisModal).validate({
         rules: {
             nave_id: {
                 required: true
             },
             arte_pesca_id: {
                 required: true
             },
             fecha_zarpe_date: {
                 required: true
             },
             fecha_zarpe_time: {
                 required: true
             },
             capitan_id: {
                 required: true
             },
             puerto_id: {
                 required: true
             }
         }
     });
 });
</script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $marea->errors(),
        'data' => $marea
    ]);
}
?>
