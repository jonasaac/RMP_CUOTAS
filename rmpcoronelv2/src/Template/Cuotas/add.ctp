<?php
$this->layout = 'ajax';
if(!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <legend>Resoluciones</legend>
        <?= $this->Form->create($cuota, ['id' => 'resoluciones-form']) ?>

        <div class="form-group">
          <label class="col-sm-3 control-label">Fecha de Inicio</label>
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-7">
                <div class="input-group input-group-xs date-picker" id="fecha-inicio-date-container">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input name="fecha_inicio_date" id="fecha-inicio-date" type="text" class="form-control">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="input-group input-group-xs time-picker" id="fecha-inicio-time-container">
                  <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                  <input name="fecha_inicio_time" id="fecha-inicio-time" type="text" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">Fecha de Término</label>
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-7">
                <div class="input-group input-group-xs date-picker" id="fecha-temino-date-container">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input name="fecha_termino_date" id="fecha-termino-date" type="text" class="form-control">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="input-group input-group-xs time-picker" id="fecha-termino-time-container">
                  <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                  <input name="fecha_termino_time" id="fecha-termino-time" type="text" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Especie</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="nave_id" id="nave-id" placeholder="Seleccione una Especie">
                  <option></option>
                </select>
                  <div class="input-group-btn">
                    <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                      <a id="new-nave" class="btn btn-default input-xs">Nueva</a>
                    <?php else: ?>
                      <a id="new-nave" class="btn btn-default input-xs" disabled>Nueva</a>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Zona de Pesca</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="nave_id" id="nave-id" placeholder="Seleccione una Zona">
                  <option></option>
                </select>
                  <div class="input-group-btn">
                    <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                      <a id="new-nave" class="btn btn-default input-xs">Nueva</a>
                    <?php else: ?>
                      <a id="new-nave" class="btn btn-default input-xs" disabled>Nueva</a>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Código Resolución</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="nave_id" id="nave-id" placeholder="Ingese Código">
                  <option></option>
                </select>
                  <div class="input-group-btn">
                    <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                      <a id="new-nave" class="btn btn-default input-xs">Nuevo</a>
                    <?php else: ?>
                      <a id="new-nave" class="btn btn-default input-xs" disabled>Nuevo</a>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
        </div>

        <?= $this->Form->input('observaciones') ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal
    $('#nave-id, #capitan-id, #puerto-id, #arte-pesca-id', $thisModal).select2();


    $('#fecha-inicio-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
    $('#fecha-inicio-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
    $('#fecha-inicio-time', $thisModal).val(moment().format('HH:mm'));
    $('#fecha-inicio-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));

    $('#fecha-termino-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
    $('#fecha-termino-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
    $('#fecha-termino-time', $thisModal).val(moment().format('HH:mm'));
    $('#fecha-termino-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));

     $('#resoluciones-form', $thisModal).validate({
         rules: {
             fecha_zarpe_date: {
                 required: true
             },
             fecha_zarpe_time: {
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
        'errors' => $marea->errors(),
        'data' => $marea
    ]);
}
?>
