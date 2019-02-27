<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($movimiento, ['id' => 'movimiento-form']) ?>
            <legend>Movimiento - <?= $movimiento->nombre ?></legend>
            <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese un nombre']) ?>
            <?= $this->Form->input('tipo', ['options' => [1 => 'ENTRADA', 2 => 'SALIDA'], 'placeholder' => 'Seleccione un tipo de movimiento', 'style' => 'width: 100%'])?>
            <?= $this->Form->input('estado_id', ['options' => $estados, 'placeholder' => 'Seleccione el estado', 'style' => 'width: 100%'])?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');

         $('#tipo, #estado-id', $thisModal).select2({
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
                 },
                 estado_id: {
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
