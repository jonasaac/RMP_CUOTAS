<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
        <?= $this->Form->create($usuario, ['id' => 'usuario-form']) ?>
        <legend>Usuario</legend>
        <?php
        echo $this->Form->input('uid', ['type' => 'text', 'placeholder' => 'Ingrese el login']);
        echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre del usuario']);
        echo $this->Form->input('grupos._ids', ['options' => $grupos, 'class' => 'form-control', 'style' => 'width: 100%']);
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
     $('#usuario-form', $thisModal).validate({
         rules: {
             uid: {
                 required: true
             },
             nombre: {
                 required: true,
                 minlength: 2,
             },
             'grupos[_ids][]': {
                 required: true
             }
         }
     });
 });
</script>
<?php
    } else {
        echo json_encode([
            'status' => $status,
            'data' => $usuario
        ]);
    }
?>
