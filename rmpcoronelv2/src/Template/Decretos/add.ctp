<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
    ?>
<div class="row" id="<?=$hash_id?>">
    <form id="decreto-form" class="form-horizontal">
    <div class="col-md-12">
        <legend>Decretos de Pesca</legend>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Código Resolución</label>
                    <div class="col-sm-9">
                        <input name="codigo_resolucion" id="codigo-resolucion" type="text" class="form-control input-xs" placeholder="Ingrese el Código de Resolución">
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha de Promulgación</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-xs date-picker" id="fecha-promulgacion-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="fecha_promulgacion" id="fecha-promulgacion-date" type="text" class="form-control" placeholder="Ingrese Fecha de Promulgación">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha de Inicio</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-xs date-picker" id="fecha-inicio-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="fecha_inicio_vigencia" id="fecha-inicio-date" type="text" class="form-control" placeholder="Ingrese Fecha de Inicio">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha de Término</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-xs date-picker" id="fecha-termino-date-container">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            <input name="fecha_termino_vigencia" id="fecha-termino-date" type="text" class="form-control" placeholder="Ingrese Fecha de Término">
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
                    <label class="col-sm-3 control-label">Adjunto</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control input-xs" id="adjunto-text-container" readonly="" placeholder="Seleccione un archivo">
                            <span class="input-group-btn">
                                <span class="btn btn-file">
                                    Seleccionar <input type="file" name="adjunto_file" id="adjunto-file">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Observaciones</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="observaciones" id="observaciones"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="periodo-div">
        <div class="col-md-12">
            <legend>Periodos</legend>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <button class="btn" id="add-periodo-btn">Agregar Periodo</button>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-xs-10">
                      <div class="input-container">
                        <input type="text" id="total-cuota" readonly="readonly" class="form-control input-xs" placeholder="Total Cuota"/>
                        <label>TON</label>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="periodos-div" style="padding-top: 5px;">
        </div>
    </div>
</form>
</div>
<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal

    $('#adjunto-file', $thisModal).on('change', function() {
        $('#adjunto-text-container', $thisModal).val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });

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
    });

    $('#fecha-promulgacion-date-container', $thisModal).datetimepicker(dateOptions(false, moment()));
    $('#fecha-inicio-date-container', $thisModal).datetimepicker(dateOptions(false));
    $('#fecha-termino-date-container', $thisModal).datetimepicker(dateOptions(false));

    $("#fecha-inicio-date-container", $thisModal).on('dp.change', function() {
      $('#fecha-termino-date-container', $thisModal).data("DateTimePicker")
      .minDate($('#fecha-inicio-date-container', $thisModal).data("DateTimePicker").date());
    });

    /** Manejo de UMD **/
    idx_num = 0;
    $('#add-periodo-btn', $thisModal).on('click', function (e){
        e.preventDefault();

        var tmp_html = '<div class="row" role="periodo-row"><div class="col-md-3">';
        // fecha inicio
        tmp_html += '<div class="input-group input-group-xs date-picker fecha-inicio">';
        tmp_html += '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        tmp_html += '<input type="text" class="form-control" name="periodos['+idx_num+'][fecha_inicio]" placeholder="Fecha Inicio"/>';
        tmp_html += '</div>';
        tmp_html += '</div><div class="col-md-3">';
        // fecha termino
        tmp_html += '<div class="input-group input-group-xs date-picker fecha-termino">';
        tmp_html += '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        tmp_html += '<input type="text" class="form-control input-xs" name="periodos['+idx_num+'][fecha_termino]" placeholder="Fecha Termino"/>';
        tmp_html += '</div>';
        tmp_html += '</div><div class="col-md-2">';
        // macro_zona
        tmp_html += '<select class="form-control input-xs macro-zona" name="periodos['+idx_num+'][macro_zona_id]" data-placeholder="Macro Zona" lang="es"><option value></option></select>';
        tmp_html += '</div><div class="col-md-3">';
        // cantidad
        tmp_html += '<input type="hidden" name="periodos['+idx_num+'][unidades][0][id]" value="1"/>';
        tmp_html += '<input type="hidden" name="periodos['+idx_num+'][unidades][0][_joinData][unidad_id]" value="1"/>';
        tmp_html += '<div class="input-container">';
        tmp_html += '<input type="text" class="form-control input-xs cantidad" name="periodos['+idx_num+'][unidades][0][_joinData][cantidad]" placeholder="Cantidad"/>';
        tmp_html += '<label>TON</label></div>';
        tmp_html += '</div><div class="col-md-1">';
        // delete
        tmp_html += '<button class="btn btn-danger delete-periodo-btn btn-26"><i class="fa fa-trash"></i></button>';
        tmp_html += '</div></div>';

        $('#periodos-div', $thisModal).append(tmp_html);
        idx_num++;

        var $lastRow = $('#periodos-div .row:last');
        $('select[name$="[macro_zona_id]"]', $lastRow).select2({dropdownParent: $thisModal, data: macro_zonas});

        $('.fecha-inicio', $lastRow).datetimepicker(dateOptions(false));
        $('.fecha-termino', $lastRow).datetimepicker(dateOptions(false));

        $('.fecha-inicio', $lastRow).on('dp.change', function() {
            $('.fecha-termino', $lastRow).data("DateTimePicker")
            .minDate($('.fecha-inicio', $lastRow).data("DateTimePicker").date())
            .date($('.fecha-inicio', $lastRow).data("DateTimePicker").date());
        });

        $('input[name$="[fecha_inicio]"]', $lastRow).rules('add', {
          required: true,
        });
        $('input[name$="[fecha_termino]"]', $lastRow).rules('add', {
          required: true,
        });
        $('select[name$="[macro_zona_id]"]', $lastRow).rules('add', {
          required: true,
        });

        $('.cantidad', $lastRow).rules('add', {
          required: true,
          number: true,
          numberMin: 0,
        });
    });

    $('#periodos-div', $thisModal).on('click', '.delete-periodo-btn', function(e) {
        e.preventDefault();

        var parentRow = $(this).parents('.row[role="periodo-row"]');
        parentRow.remove();
        idx_num--;

        updateTotalTON();
    });

    $($thisModal).on('blur', 'input[name$="[_joinData][cantidad]"]', function() {
        updateTotalTON();
    });

    function updateTotalTON() {
        /** Calculo UMD **/
        var total_ton = Number(0);
        $('#periodos-div .row', $thisModal).each(function(i, e) {
            var $thisRow = $(this);
            var cantidad = $('input[name$="[cantidad]"]', $thisRow).val();

            total_ton += Number(toggleNumberFormat(cantidad));
        });
        $('#total-cuota', $thisModal).val(toggleNumberFormat(total_ton));
    }

     $('#decreto-form', $thisModal).validate({
         rules: {
             codigo_resolucion: {
                 required: true
             },
             fecha_promulgacion: {
                 required: true
             },
             fecha_inicio_vigencia: {
                 required: true
             },
             fecha_termino_vigencia: {
                 required: true
             },
             especie_id: {
                 required: true
             }
         },
         messages: {
             "unidades[1][_joinData][cantidad]": {
                 equalTo: "La cantidad de UMD debe ser proporcinal al procentaje ingresado."
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
