<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
    ?>
<div class="row" id="<?=$hash_id?>">
    <form id="licencia-form" class="form-horizontal">
    <div class="col-md-12">
        <legend>Licencias de Pesca</legend>
    </div>
    <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Macro Zona</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <select class="form-control input-xs" name="macro_zona_id" id="macro-zona-id" data-placeholder="Seleccione una Macro Zona" lang="es" style="width: 100%;">
                                <option value></option>
                            </select>
                            <div class="input-group-btn">
                                <?php if (array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                                    <a id="new-macro-zona" class="btn btn-default input-xs">Nueva</a>
                                <?php else: ?>
                                    <a id="new-macro-zona" class="btn btn-default input-xs" disabled>Nueva</a>
                                <?php endif;?>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Fecha de Estado</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-xs date-picker" id="fecha-estado-date-container">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input name="fecha_estado" id="fecha-estado-date" type="text" class="form-control" placeholder="Ingrese Fecha de Info. del Estado">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Especie</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="especie_id" id="especie-id" data-placeholder="Seleccione una Especie" lang="es" style="width: 100%;">
                                    <option value></option>
                                </select>
                                <div class="input-group-btn">
                                    <?php if (array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                                        <a id="new-especie" class="btn btn-default input-xs">Nueva</a>
                                    <?php else: ?>
                                        <a id="new-especie" class="btn btn-default input-xs" disabled>Nueva</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cantidad</label>
                        <div class="col-sm-9">
                          <input type="hidden" name="unidades[0][id]" value="1" />
                          <input type="hidden" name="unidades[0][_joinData][unidad_id]" value="1" />
                          <div class="input-container">
                            <input type="text" name="unidades[0][_joinData][cantidad]" class="form-control input-xs" placeholder="Ingrese la cantidad" />
                            <label>TON</label>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal
    especies = []
    $.ajax({
        url: '/api/especies.json',
        type: 'GET',
        dataType: 'json'
    })
    .done(function (data) {
        $.each(data.especies, function (i, val) {
            especies.push({id: val.id, text: val.nombre});
        });
        $('#especie-id', $thisModal).select2({
            data: especies,
            dropdownParent: $thisModal
        });
    });
    $('#especie-id', $thisModal).select2();

    macro_zonas = []
    $.ajax({
        url: '/api/macro_zonas.json',
        type: 'GET',
        dataType: 'json'
    })
    .done(function (data) {
        $.each(data.macro_zonas, function (i, val) {
            macro_zonas.push({id: val.id, text: val.nombre});
        });
        $('#macro-zona-id', $thisModal).select2({data: macro_zonas});
    });
    $('#macro-zona-id', $thisModal).select2({dropdownParent: $thisModal});

    $('#fecha-estado-date-container', $thisModal).datetimepicker(dateOptions(false, moment()));
     $('#estado-cuota-form', $thisModal).validate({
         rules: {
             macro_zona_id: {
                 required: true
             },
             fecha_estado: {
                 required: true
             },
             especie_id: {
                 required: true
             },
             "unidades[0][_joinData][cantidad]": {
                 required: true,
                 number: true
             }
         }
     });

     /*** BOTONES NEW ***/
     $('#new-especie', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Especie', '/especies/add', {
             successCallback: function ( data ){
                 var $select = $('select[name="especie_id"]', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });
     $('#new-macro-zona', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Macro Zona', '/macro_zonas/add', {
             successCallback: function ( data ){
                 var $select = $('select[name="macro_zonas[_ids][]"]', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });


 });
</script>
<?php

} else {
    echo json_encode([
        'status' => $status,
        'errors' => $marea->errors(),
        'data' => $marea,
    ]);
}
?>
