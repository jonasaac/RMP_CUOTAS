<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
        <?= $this->Form->create($calibre, ['id' => 'calibre-form']) ?>
        <legend>Calibre - <?=$calibre->nombre?></legend>
        <?= $this->Form->input('nombre', ['placeholder' => 'Ingrese el rango del calibre']); ?>
        <?= $this->Form->input('estado_id', ['placeholder' => 'Seleccione un estado', 'style' => 'width: 100%']); ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
 $(document).ready(function() {
     $thisModal = $('#<?=$hash_id?>');
     $('select', $thisModal).select2({
         dropdownParent: $thisModal
     });
     $('#calibre-form', $thisModal).validate({
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
        'errors' => $calibre->errors(),
        'data' => $calibre
    ]);
}
?>
