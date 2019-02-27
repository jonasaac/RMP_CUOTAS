<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($ponton, ['id' => 'ponton-form']) ?>
            <?php
                echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre del pontón']);
            echo $this->Form->input('puerto_id', ['options' => $puertos, 'empty' => true, 'placeholder' => 'Seleccione un puerto']);
            echo $this->Form->input('estado_id', ['options' => $estados])
            ?>
            <?=$this->Form->submit()?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         $thisModal = $('#<?=$hash_id?>');
         $('select', $thisModal).select2();
         $('#ponton-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
                 },
                 puerto_id: {
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
        'errors' => $ponton->errors(),
        'data' => $ponton
    ]);
}
?>
