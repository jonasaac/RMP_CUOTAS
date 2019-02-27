<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($tipoDescarga, ['id' => 'tipoDescarga-form']) ?>
            <legend>Tipo de Documento de Descarga - <?=$tipoDescarga->nombre?></legend>
            <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese el tipo de descarga']) ?>
            <?= $this->Form->input('estado_id', ['options' => $estados, 'placeholder' => 'Seleccione el estado', 'style' => 'width: 100%']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');
         $('select', $thisModal).select2({
             dropdownParent: $thisModal
         });
         $('#tipoDescarga-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
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
        'errors' => $tipoDescarga->errors(),
        'data' => $tipoDescarga
    ]);
}
?>
