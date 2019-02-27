<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
  $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
          <?= $this->Form->create($recurso) ?>
          <legend>Recurso - <?=$recurso->nombre?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('estado_id', ['options' => $estados]);
            echo $this->Form->input('unidad_principal_id', ['options' => $unidades]);
            echo $this->Form->input('unidades._ids', ['options' => $unidades, 'multiple' => 'multiple', 'class' => 'input-xs form-control']);
            echo $this->Form->input('especies._ids', ['options' => $especies, 'multiple' => 'multiple', 'class' => 'input-xs form-control']);
        ?>
        <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
    $(document).ready(function () {
      var $thisModal = $('#<?=$hash_id?>')
      $('#estado-id, #unidad-principal-id', $thisModal).select2();
    });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $recurso->errors(),
        'data' => $recurso
    ]);
}
?>
