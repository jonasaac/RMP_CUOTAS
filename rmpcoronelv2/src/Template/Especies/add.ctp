<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
            <form id="especie-form" class="form-horizontal">
            <legend>Especie</legend>
            <div class="form-group">
              <label class="col-sm-3 control-label">
                Nombre
              </label>
              <div class="col-sm-9">
                <input name="nombre" id="nombre" class="form-control input-xs" placeholder="Ingrese un nombre para la especie"/>
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    Sujeto a LTP
                    <strong data-toggle="tooltip" data-placement="right" data-original-title="Marque si la especie ingresada está sujeta a LTP">?</strong>
                </label>
                <div class="col-md-9">
                    <div class="checkbox">
                        <input type="hidden" name="ltp" value="0">
                        <label>
                            <input type="checkbox" value="1" name="ltp" id="ltp">
                            <span class="text"></span>
                        </label></div>
                </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">
                Recursos
              </label>
              <div class="col-sm-9">
                <input type="hidden" name="recursos[_ids]"/>
                <select style="width: 100%" class="form-control input-xs" lang="es" multiple="multiple" name="recursos[_ids][]" id="recursos-ids" data-placeholder="Seleccione los recuros a los que pertenece la especie" placeholder="Seleccione los recuros a los que pertenece la especie">
                  <?php foreach($recursos as $id => $recurso): ?>
                    <option value="<?=$id?>"><?=$recurso?></option>
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
         $('#recursos-ids').select2({dropdownParent: $thisModal});

         $('#especie-form', $thisModal).validate({
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
        'errors' => $especie->errors(),
        'data' => $especie
    ]);
}
?>
