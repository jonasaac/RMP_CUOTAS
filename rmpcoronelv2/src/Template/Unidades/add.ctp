<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
?>
    <?= $this->Form->create($unidad, ['id' => 'unidad-form']) ?>
    <div class="row">
        <div class="col-lg-12">
        <?php
        echo $this->Form->input('nombre', ['placeholder' => 'Ingrese el nombre de la unidad']);
        echo $this->Form->input('abreviacion', ['placeholder' => 'Ingrese la abreviación']);
        echo $this->Form->input('grupo', ['placeholder' => 'Seleccine un Grupo', 'options' => $grupos]);
        ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
    <script>
        $(document).ready(function() {
            $('#unidad-form').validate({
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
        'errors' => $unidad->errors(),
        'data' => $unidad
    ]);
}
?>
