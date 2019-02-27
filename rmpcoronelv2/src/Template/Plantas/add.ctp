<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <?= $this->Form->create($planta, ['id' => 'planta-form']) ?>
            <legend>Planta</legend>
            <?php
            echo $this->Form->input('codigo', ['label' => 'Código', 'placeholder' => 'Ingrese el código de la planta']);
            echo $this->Form->input('seccion', ['placeholder' => 'Ingrese la sección de la planta']);
            echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre de la planta']);
            echo $this->Form->input('recinto.areas._ids', ['options' => $areas, 'multiple' => 'multiple', 'class' => 'input-xs form-control', 'style' => 'width: 100%']);
            ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');
         $('select').select2({
             dropdownParent : $thisModal
         })
         $('#planta-form', $thisModal).validate({
             rules: {
                 codigo: {
                     required: true,
                     digits: true
                 },
                 seccion: {
                     required: true
                 },
                 nombre: {
                     required: true,
                     minlength: 2
                 },
                 'recinto[areas][_ids]': {
                   minlength: 1
                 }
             }
         });
     });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $planta->errors(),
        'data' => $planta
    ]);
}
?>
