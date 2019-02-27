<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-lg-12">
        <form id="especie-form" class="form-horizontal">
            <legend>Especie - <?=$especie->nombre?></legend>
          <div class="form-group">
              <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input
                    class="form-control input-xs"
                    name="nombre"
                    id="nombre"
                    value = "<?=$especie->nombre?>"
                    placeholder="Ingrese el Nombre"/>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label">Sujeto a LTP</label>
                <div class="col-sm-9">
                    <div class="checkbox">
                        <input type="hidden" name="ltp" value="0">
                        <label>
                            <input type="checkbox" value="1" name="ltp" id="ltp" <?= $especie->ltp ? ' checked="checked"': ''?>>
                            <span class="text"></span>
                        </label></div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label">Estado</label>
                <div class="col-sm-9">
                    <select style="width: 100%" class="form-control input-xs" name="estado_id" id="estado-id" data-placeholder="Seleccione el Estado" lang="es">
                      <option></option>
                      <?php foreach($estados as $id => $estado): ?>
                        <option value="<?=$id?>" <?= $especie->estado_id == $id ? 'selected="selected"':'' ?>><?=$estado?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php
              $recursos_ids = [];
              foreach ($especie->recursos as $recurso) {
                $recursos_ids[] = $recurso->id;
                }
            ?>
            <div class="form-group">
                <label class="col-sm-3 control-label">Recursos</label>
                <div class="col-sm-9">
                    <select
                    class="form-control input-xs"
                    name="recursos[_ids][]"
                    id="recursos-ids"
                    lang="es"
                    style="width: 100%"
                    multiple="multiple"
                    data-placeholder="Seleccione los recuros a los que pertenece la especie"
                    placeholder="Seleccione los recuros a los que pertenece la especie">
                    <option></option>
                    <?php foreach($recursos as $id => $recurso): ?>
                      <option "<?=$id?>"<?=in_array($id, $recursos_ids)?' selected="selected"':''?>><?=$recurso?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </form>
        </div>
    </div>
    <script>
     $(document).ready(function() {
         var $thisModal = $('#<?=$hash_id?>');

         $('#recursos-ids').select2({dropdownParent: $thisModal});
         $('#estado-id').select2({dropdownParent: $thisModal});
         $('#especie-form').validate({
             rules: {
                 nombre: {
                     required: true,
                     minlength: 2,
                 },
                 estado_id: {
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
        'errors' => $especie->errors(),
        'data' => $especie
    ]);
}
?>
