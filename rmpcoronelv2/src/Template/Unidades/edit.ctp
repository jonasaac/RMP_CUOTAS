<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
?>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->Form->create($unidad, ['id' => 'unidad-form']) ?>
        <?php
        echo $this->Form->input('nombre');
        echo $this->Form->input('abreviacion');
        echo $this->Form->input('grupo', ['placeholder' => 'Seleccine un Grupo', 'options' => $grupos]);
        echo $this->Form->input('recursos._ids', ['class' => 'input-xs form-control']);
        echo $this->Form->input('estado_id', ['options' => $estados]);
        ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#unidad-form').parents('.modal-dialog');
         $('#unidad-form').validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 2,
                    },
                    estado_id: {
                        required: true,
                    }
                }
            })
        });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $unidad->errors(),
        'data' => $unidad
    ]);
}
?>
