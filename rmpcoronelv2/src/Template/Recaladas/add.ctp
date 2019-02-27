<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-md-12">
          <form class="form-horizontal" id="recalada-form">
            <legend>Recalada</legend>
            <div class="form-group">
              <label class="col-sm-3 control-label">Fecha de Recalada</label>
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-sm-7">
                    <div class="input-group input-group-xs date-picker" id="fecha-recalada-date-container">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                      <input name="fecha_recalada_date" id="fecha-recalada-date" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="input-group input-group-xs time-picker" id="fecha-recalada-time-container">
                      <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                      <input name="fecha_recalada_time" id="fecha-recalada-time" type="text" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Pónton Recalada</label>
                <div class="col-sm-9">
                  <div class="input-group">
                  <select class="form-control input-xs" style="width: 100%" name="ponton_id" id="ponton-id" data-placeholder="Seleccione un pónton de recalada" placeholder="Seleccione un pónton de recalada" lang="es">
                      <option value></option>
                  </select>
                  <div class="input-group-btn">
                    <?php if(array_in_array(['admin_ponton_add'], $current_user['privilegios'])): ?>
                      <a id="new-ponton" class="btn btn-default input-xs">Nuevo</a>
                    <?php else: ?>
                      <a id="new-ponton" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                    <?php endif; ?>
                  </div>
                  </div>
                </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Observaciones</label>
              <div class="col-sm-9">
                <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
              </div>
            </div>
          </form>
        </div>
    </div>
<script>
$(document).ready(function () {
   var $thisModal = $('#<?=$hash_id?>');
   pontones = [];
   $.ajax({
     url: '/api/pontones/listar_filtrado.json',
     type: 'GET',
     dataType: 'json'
   }).done(function (data) {
     $.each(data.puertos, function(i, puerto) {
       var tmp_pontones = [];
       $.each(puerto.pontones, function(i, ponton) {
         tmp_pontones.push({id: ponton.id, text: ponton.nombre});
       });
       pontones.push({text: puerto.nombre, children: tmp_pontones});
     });
     $("#ponton-id", $thisModal).select2({
       dropdownParent: $thisModal,
       data: pontones
     });
   });
   $("#ponton-id", $thisModal).select2();
   $('#fecha-recalada-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
   $('#fecha-recalada-date-container', $thisModal).datetimepicker(dateOptions(moment.utc()));
   $('#fecha-recalada-date-container', $thisModal).data('DateTimePicker').minDate( moment.utc(fechaMarea).set({'hour':0, 'minute':0}) );
   $('#fecha-recalada-time', $thisModal).val(moment().format('HH:mm'));
   $('#fecha-recalada-time-container', $thisModal).datetimepicker(timeOptions(moment.utc()));

   <?php if(array_in_array(['admin_ponton_add'], $current_user['privilegios'])): ?>
   $('#new-ponton', $thisModal).click(function(e) {
       e.stopPropagation();
       newEntity('Nuevo Ponton', '/pontones/add', {
           successCallback: function( data ){
               var $select = $('#ponton-id', $thisModal);
               $select.find('optgroup[data-puerto-id="'+data.data.puerto_id+'"]').append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
           }
       });
   });
   <?php endif; ?>

   $('#recalada-form').validate({
       rules: {
           fecha: {
               required: true
           },
           ponton_id: {
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
        'errors' => $recalada->errors(),
        'data' => $recalada
    ]);
    }
?>
