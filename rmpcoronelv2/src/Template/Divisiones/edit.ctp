<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
?>
    <?= $this->Form->create($division) ?>
    <div class="row">
        <div class="col-lg-12">
            <?php
                echo $this->Form->input('nombre');
            echo $this->Form->input('estado_id', ['options' => $estados]);
            ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $division->errors(),
        'data' => $division
    ]);
}
?>
