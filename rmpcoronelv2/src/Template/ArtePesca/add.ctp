<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
      <div class="col-sm-12">
        <legend>Arte de Pesca</legend>
      </div>
        <div class="col-lg-12">
            <?= $this->Form->create($artePesca, ['id' => 'artePesca-form']) ?>
            <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese un nombre']) ?>
            <?= $this->Form->input('recurso_id', ['placeholder' => 'Seleccione un Recurso', 'options' => $recursos, 'style' => 'width: 100%']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         $thisModal = $('#<?=$hash_id?>');

         $('#recurso-id', $thisModal).select2({
             sortResults: function(results, container, query) {
                 return results.sort(function(a,b){return a.text.localeCompare(b.text) > 0; });
             },
             dropdownParent: $thisModal
         });

         $('#artePesca-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
                 }
             }
         })
        });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $artePesca->errors(),
        'data' => $artePesca
    ]);
}
?>
