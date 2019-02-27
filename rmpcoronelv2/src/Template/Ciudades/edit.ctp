<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($ciudad, ['id' => 'ciudad-form']) ?>
            <legend>Ciudad - <?=$ciudad->nombre?></legend>
            <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre de la ciudad']) ?>
            <?= $this->Form->input('estado_id', ['options' => $estados])?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');
         $('#ciudad-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
                 },
                 estado_id: {
                     required: true,
                 }
             }
         })
     });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $ciudad->errors(),
        'data' => $ciudad
    ]);
}
?>
