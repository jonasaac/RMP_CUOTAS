<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
?>
    <?= $this->Form->create($recurso) ?>
    <div class="row">
        <div class="col-lg-12">
          <legend>Recurso</legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('unidades._ids', ['options' => $unidades, 'multiple' => 'multiple', 'class' => 'input-xs form-control']);
            echo $this->Form->input('especies._ids', ['options' => $especies, 'multiple' => 'multiple', 'class' => 'input-xs form-control']);
        ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $recurso->errors(),
        'data' => $recurso
    ]);
}
?>
