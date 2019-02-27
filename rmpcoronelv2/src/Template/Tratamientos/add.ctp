<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($tratamiento, ['id' => 'tratamiento-form']) ?>
            <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre del tratamiento']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function () {
         var $thisModal = $('#<?=$hash_id?>');

         $('#tratamiento-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2
                 }
             }
         });
     });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $tratamiento->errors(),
        'data' => $tratamiento
    ]);
}
?>
