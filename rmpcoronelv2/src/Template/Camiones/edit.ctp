<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($camion, ['id' => 'camion-form']) ?>
            <legend>Camión - <?=$camion->patente?></legend>
            <?= $this->Form->input('patente', ['placeholder' => 'Ingrese la patente. ej: AABB11']) ?>
            <div class="form-group">
                <label class="col-sm-3 control-label">Empresa Transportes</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <select class="form-control input-xs" style="width: 100%" name="transporte_id" id="transporte-id" placeholder="Seleccione la empresa de transporte">
                            <option></option>
                            <?php foreach($transportes as $id => $transporte): ?>
                                <option value="<?=$id?>"<?=$id==$camion->transporte_id?' selected="selected"':''?>><?=$transporte?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-btn">
                          <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                            <a id="new-transporte" class="btn btn-default input-xs">Nueva</a>
                          <?php else: ?>
                            <a id="new-transporte" class="btn btn-default input-xs" disabled="disabled">Nueva</a>
                          <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->input('tipo_camion', ['label' => 'Tipo de Camión','placeholder' => 'Ingrese el tipo de camión'])?>
            <?= $this->Form->input('estado_id', ['options' => $estados, 'style' => 'width: 100%'])?>
            <?= $this->Form->input('areas._ids', ['options' => $areas, 'multiple' => 'multiple', 'class' => 'input-xs form-control', 'style' => 'width: 100%'])?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');
         $('select', $thisModal).select2({
             dropdownParent: $thisModal
         });

         <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
         $('#new-transporte').click(function (e) {
           e.stopPropagation();
           newEntity('Nueva Empresa de Transporte', '/auxiliares/add/transporte', {
               successCallback: function ( data ){
                   var $select = $('#transporte-id', $thisModal);
                   $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
                   $select.select2('val', data.data.id);
               }
           });
         });
         <?php endif; ?>

         $('#camion-form', $thisModal).validate({
             rules: {
                 patente: {
                     required: true,
                     exactlength: 6
                 },
                 transporte_id: {
                     required: true
                 },
                 tipo_camion: {
                     required: true
                 },
                 estado_id: {
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
        'errors' => $camion->errors(),
        'data' => $camion
    ]);
}
?>
