<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
          <form class="form-horizontal" id="ponton-form">
            <legend>Pontón</legend>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre</label>
              <div class="col-sm-9">
                <input type="text"
                       name="nombre"
                       id="nombre"
                       class="form-control input-xs"
                       placeholder="Ingrese el nombre del pontón" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Puerto</label>
              <div class="col-sm-9">
                <select class="form-control input-xs" name="puerto_id" id="puerto-id" data-placeholder="Seleccione un puerto" placeholder="Seleccione un puerto" lang="es" style="width: 100%;">
                    <option value></option>
                    <?php foreach($puertos as $id => $puerto): ?>
                      <option value="<?=$id?>"><?=$puerto?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

          </form>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         $thisModal = $('#<?=$hash_id?>');
         $('#puerto-id', $thisModal).select2({dropdownParent: $thisModal});
         $('#ponton-form', $thisModal).validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
                 },
                 puerto_id: {
                     required: true
                 }
             }
         })
     });
    </script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $ponton->errors(),
        'data' => $ponton
    ]);
}
?>
