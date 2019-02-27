<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
        <?= $this->Form->create($area, ['id' => 'area-form']) ?>
        <legend>Area</legend>
        <?php
        echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre del area']);
        echo $this->Form->input('recursos._ids', ['placeholder' => 'Seleccione los recursos asociados', 'options' => $recursos, 'multiple' => 'multiple', 'class' => 'input-xs form-control', 'style' => 'width: 100%'])
        ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $('select').select2({
         dropdownParent : $thisModal
     })
     $('#area-form', $thisModal).validate({
         rules: {
             nombre: {
                 required: true,
                 minlength: 2,
             }
         }
     });
 });
</script>
<?php
    } else {
        echo json_encode([
            'status' => $status,
            'data' => $area
        ]);
    }
?>
