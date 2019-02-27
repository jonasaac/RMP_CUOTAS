<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($movimiento, ['id' => 'movimiento-form']) ?>
            <legend>Movimiento</legend>
            <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese un nombre']) ?>
            <?= $this->Form->input('tipo', ['options' => [1 => 'ENTRADA', 2 => 'SALIDA'], 'empty' => true, 'placeholder' => 'Seleccione un tipo de movimiento', 'style' => 'width: 100%'])?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');
         $('#tipo', $thisModal).select2({
             dropdownParent: $thisModal
         });
         $('#movimiento-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
                 },
                 tipo: {
                     required: true
                 }
             }
         })
     });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $movimiento->errors(),
        'data' => $movimiento
    ]);
}
?>
