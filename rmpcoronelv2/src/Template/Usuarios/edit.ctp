<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
        <?= $this->Form->create($usuario, ['id' => 'usuario-form']) ?>
        <legend>Usuario - <?=$usuario->nombre?></legend>
        <?php
        echo $this->Form->input('uid', ['type' => 'text', 'readonly' => 'readonly', 'placeholder' => 'Ingrese el login']);
        echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre del usuario']);
        echo $this->Form->input('estado_id', ['options' => $estados, 'style' => 'width: 100%']);
        ?>
        <div class="form-group">
          <label class="col-sm-3 control-label">Lista de Cambios</label>
          <div class="col-sm-9 m-b">
            <div class="checkbox">
              <label>
                <?=$this->Form->checkbox('change_log')?>
                <span class="text"> Ver</span>
              </label>
            </div>
          </div>
        </div>
        <?php
        echo $this->Form->input('grupos._ids', ['options' => $grupos, 'class' => 'form-control', 'style' => 'width: 100%']);
        ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $('select', $thisModal).select2({
         dropdownParent : $thisModal
     });

     $('#usuario-form', $thisModal).validate({
         rules: {
             uid: {
                 required: true
             },
             nombre: {
                 required: true,
                 minlength: 2,
             },
             estado_id: {
                 required: true
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
