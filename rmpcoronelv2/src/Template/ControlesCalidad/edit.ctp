<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
        $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-md-12">
            <?= $this->Form->create($controlesCalidad, ['id' => 'calidad-form']) ?>
            <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3 control-label">Tratamiento</label>
                <div class="col-sm-9">
                        <div class="input-group">
                        <select class="form-control input-xs" name="tratamiento_id" id="tratamiento-id" placeholder="Seleccione un Tratamiento">
                            <option></option>
                            <?php foreach($tratamientos as $id => $tratamiento): ?>
                                <option value="<?=$id?>"<?=$id==$controlesCalidad->tratamiento_id?' selected="selected"':''?>><?=$tratamiento?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-btn">
                          <?php if (array_in_array(['admin_tratamiento_add'], $current_user['privilegios'])):?>
                            <a id="new-tratamiento" class="btn btn-default input-xs">Nuevo</a>
                          <?php else: ?>
                            <a id="new-tratamiento" class="btn btn-default input-xs" disabled="disabled">Nuevo</a>
                          <?php endif; ?>
                        </div>
                        </div>
                </div>
            </div>
            <?= $this->Form->input('tvn', ['label' => 'TVN', 'placeholder' => 'Ingrese TVN']) ?>
            <?= $this->Form->input('agua', ['label' => '% Agua', 'type' => 'text', 'placeholder' => 'Ingrese % de Agua', 'value' => $this->Number->precision($controlesCalidad->agua)]) ?>
            <?= $this->Form->input('ph', ['label' => 'pH', 'placeholder' => 'Ingrese nivel de pH']) ?>
            <?= $this->Form->input('c', ['label' => 'ºC', 'placeholder' => 'Ingrese ºC']) ?>
            </div>
            <div class="col-md-6">
            <?= $this->Form->input('n_litro', ['label' => 'Nº/Litro', 'placeholder' => 'Ingrese número por litro']) ?>
            <?= $this->Form->input('talla', ['placeholder' => 'Ingrese talla']) ?>
            <?= $this->Form->input('peso', ['placeholder' => 'Ingrese peso']) ?>
            <?= $this->Form->input('moda', ['placeholder' => 'Ingrese Moda']) ?>
            <?= $this->Form->input('cms', ['label' => '< 10 cms', 'placeholder' => 'Ingrese menores a 10 cms']) ?>
            </div>
            <?= $this->Form->input('observaciones') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function () {
         var $thisModal = $('#<?=$hash_id?>');
         $thisModal.parents('.modal-dialog').addClass('modal-lg');
         $('select', $thisModal).select2({
             sortResults: function(results, container, query) {
                 return results.sort(function(a,b){return a.text.localeCompare(b.text) > 0; });
             }
         });

         <?php if (array_in_array(['admin_tratamiento_add'], $current_user['privilegios'])):?>
         $('#new-tratamiento', $thisModal).on('click', function(e) {
             e.stopPropagation();
             newEntity('Nuevo Tratamiento', '/tratamientos/add', {
                 successCallback: function ( data ){
                     var $select = $('#tratamiento-id', $thisModal);
                     $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                     $select.val(data.data.id);
                 }
             });
         });
         <?php endif; ?>

         $('#calidad-form', $thisModal).validate({
             rules: {
                 tratamiento_id: {
                     required: true
                 },
                 tvn: {
                     required: true
                 },
                 agua: {
                     required: true
                 },
                 ph: {
                     required: true
                 },
                 c: {
                     required: true
                 },
                 n_litro: {
                     required: true
                 },
                 talla: {
                     required: true
                 },
                 peso: {
                     required: true
                 },
                 moda: {
                     required: true
                 },
                 cms: {
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
        'errors' => $controlesCalidad->errors(),
        'data' => $controlesCalidad
    ]);
}
?>
