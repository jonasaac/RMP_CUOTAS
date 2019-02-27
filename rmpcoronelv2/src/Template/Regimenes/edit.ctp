<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
?>
    <?= $this->Form->create($regimen, ['id' => 'regimen-form']) ?>
    <div class="row">
        <div class="col-lg-12">
        <?php
            echo $this->Form->input('nombre');
        ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
    <script>
        $(document).ready(function() {
            $('#regimen-form').validate({
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
        'errors' => $regimen->errors(),
        'data' => $regimen
    ]);
}
?>
