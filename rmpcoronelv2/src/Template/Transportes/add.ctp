<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($transporte, ['id' => 'transporte-form']) ?>
            <?php
                echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre de la empresa']);
            ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $('#<?=$hash_id?>').ready(function() {
         var $thisModal = $(this);

         $('#transporte-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2
                 }
             }
         })
     });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $transporte->errors(),
        'data' => $transporte
    ]);
}
?>
