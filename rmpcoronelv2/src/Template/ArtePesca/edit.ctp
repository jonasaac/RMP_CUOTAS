<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
  $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
      <div class="col-sm-12">
        <legend>Arte de Pesca - <?=$artePesca->nombre?></legend>
      </div>
        <div class="col-lg-12">
            <?= $this->Form->create($artePesca, ['id' => 'artePesca-form']) ?>
            <?= $this->Form->input('nombre') ?>
            <?= $this->Form->input('recurso_id', ['options' => $recursos, 'style' => 'width: 100%']) ?>
            <?= $this->Form->input('estado_id', ['options' => $estados, 'style' => 'width: 100%']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
$thisModal = $('#<?=$hash_id?>');
       $('#estado-id, #recurso-id', $thisModal).select2({
           dropdownParent: $thisModal,
           sortResults: function(results, container, query) {
               return results.sort(function(a,b){return a.text.localeCompare(b.text) > 0; });
           }
       });
         $('#estado_id').select2({
             dropdownParent: $thisModal
         });
            $('#artePesca-form').validate({
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
