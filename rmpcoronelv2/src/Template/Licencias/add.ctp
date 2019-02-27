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
                        <label class="col-sm-3 control-label">Tipo de Licencia</label>
                        <div class="col-sm-9">
                            <select class="form-control input-xs" name="tipo_licencia_id" id="tipo-licencia-id" data-placeholder="Seleccione un Tipo de Licencia" lang="es" style="width: 100%;">
                                <option value></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Modifica Licencia</label>
                        <div class="col-sm-9">
                            <select class="form-control input-xs" name="modifica_licencia_id" id="modifica-licencia-id" data-placeholder="Seleccione una Licencia" lang="es"  style="width: 100%;">
                            </select>
                        </div>
                    </div>
                </div>
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
                        <label class="col-sm-3 control-label">Titular Licencia</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="auxiliar_id" id="auxiliar-id" data-placeholder="Seleccione al Titular de la Licencia" lang="es" style="width: 100%;">
                                </select>
                                <div class="input-group-btn">
                                    <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                                        <a id="new-auxiliar" class="btn btn-default input-xs">Nuevo</a>
                                    <?php else: ?>
                                        <a id="new-auxiliar" class="btn btn-default input-xs" disabled>Nuevo</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="nave-titular-div" class="col-xs-12" style="display: none;">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nave Titular</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control input-xs" name="nave_id" id="nave-id" data-placeholder="Seleccione la Nave Titular" lang="es" style="width: 100%;">
                                    <option value=""></option>
                                </select>
                                <div class="input-group-btn">
                                    <?php if (array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                                        <a id="new-nave" class="btn btn-default input-xs">Nuevo</a>
                                    <?php else: ?>
                                        <a id="new-nave" class="btn btn-default input-xs" disabled>Nuevo</a>
                                    <?php endif;?>
                                </div>
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
                                    <?php if (array_in_array(['admin_especie_add'], $current_user['privilegios'])): ?>
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
                        <label class="col-sm-3 control-label">Macro Zona</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="hidden" name="macro_zonas[_ids][]" />
                                <select class="form-control input-xs" name="macro_zonas[_ids][]" id="macro-zonas-ids" data-placeholder="Seleccione las Macro Zonas" lang="es" multiple="multiple">
                                    <option value></option>
                                </select>
                                <div class="input-group-btn">
                                    <?php if (array_in_array(['admin_zona_add'], $current_user['privilegios'])): ?>
                                        <a id="new-macro-zona" class="btn btn-default input-xs">Nueva</a>
                                    <?php else: ?>
                                        <a id="new-macro-zona" class="btn btn-default input-xs" disabled>Nueva</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Costo de la Licencia</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input id="costo" type="text" name="costo" class="form-control input-xs" placeholder="Ingrese el costo de la licencia." style="text-align: right;">
                                </div>
                                <div class="col-sm-3">
                                    <select id="costo-unidad-id" name="costo_unidad_id" data-placeholder="Divisa" placeholder="Seleccione la moneda" lang="es" style="width: 100%;" class="form-control input-xs">
                                        <option value=""></option>
                                        <?php foreach ($monedas as $moneda): ?>
                                            <option value="<?=$moneda->id?>"><?=$moneda->abreviacion?></option>
                                        <?php endforeach;?>
                                    </select>
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
                                <input type="text" class="form-control input-xs file-input" id="adjunto-text-container" readonly="" placeholder="Seleccione un archivo">
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
    <div class="col-md-12">
        <legend>Porcentaje Cuota</legend>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Porcentaje</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="unidades[0][id]" value="5"> <!--Porcentaje-->
                        <input type="hidden" name="unidades[0][_joinData][unidad_id]" value="5"> <!--Porcentaje-->
                        <div class="input-container">
                          <input name="unidades[0][_joinData][cantidad]" id="porcentaje" type="text" class="form-control input-xs" placeholder="Ingrese el Porcentaje">
                          <label>%</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="numeracion-div">
        <div class="col-md-12">
            <legend>Numeración UMD</legend>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn" id="add-numeracion-btn">Agregar Númeración</button>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="unidades[1][id]" value="6"> <!-- umd -->
                    <input type="hidden" name="unidades[1][_joinData][unidad_id]" value="6"> <!-- umd -->
                    <div class="input-container">
                      <input type="text" id="umd-total" readonly="readonly" class="form-control input-xs" placeholder="UMD" name="unidades[1][_joinData][cantidad]"/>
                      <label for="">UMD</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="unidades[2][id]" value="7"> <!-- umr -->
                    <input type="hidden" name="unidades[2][_joinData][unidad_id]" value="7"> <!-- umr -->
                    <div class="input-container">
                      <input type="text" id="umr-total" class="form-control input-xs" placeholder="UMR" name="unidades[2][_joinData][cantidad]"/>
                      <label>UMR</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="numeraciones-div" style="padding-top: 5px;">
        </div>
    </div>
</form>
</div>
<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal

    $('#adjunto-file', $thisModal).on('change', function() {
        $('#adjunto-text-container', $thisModal).val($(this).val().replace(/C:\\fakepath\\/i, '...\\'));
    });

    tipos_licencia = []
    $.ajax({
        url: '/api/tipos_licencia.json',
        type: 'GET',
        dataType: 'json'
    })
    .done(function (data) {
        $.each(data.tipos_licencia, function (i, val) {
            tipos_licencia.push({id: i, text: val});
        });
        $('#tipo-licencia-id', $thisModal).select2({
            data: tipos_licencia,
            dropdownParent: $thisModal
        });
    });
    $('#tipo-licencia-id', $thisModal).select2();

    $('#tipo-licencia-id', $thisModal).on('change', function() {
        if ($(this).val() == 3) { //PEP
            $('#numeracion-div', $thisModal).hide();
            $('#numeracion-div input', $thisModal).prop('disabled', true);
        } else {
            $('#numeracion-div', $thisModal).show();
            $('#numeracion-div input', $thisModal).prop('disabled', false);
        }

        if ($(this).val() == 4) { // RAE
            $('#nave-titular-div').show();
            // Se cargan las naves al select2 de naves
            $('#nave-id').prop('disabled', true);
            $('#nave-id').select2();
            $.ajax({
                url: '/api/naves/listar_filtrado.json',
                type: 'GET',
                dataType: 'json'
            })
            .done(function (data) {
                var naves = [];
                $.each(data.naves, function (i, nave) {
                    naves.push({id: nave.id, text: nave.nombre});
                });
                $('#nave-id').select2({
                    dropdownParent: $thisModal,
                    data: naves
                });
                $('#nave-id').prop('disabled', false);
            });
        } else{
            $('#nave-titular-div').hide();
        }
    });

    $('#modifica-licencia-id', $thisModal).select2({
        dropdownParent: $thisModal,
        allowClear: true,
        ajax: {
            url: '/api/licencias.json',
            type: 'GET',
            dataType: 'json',
            delay: 350,
            cache: true,
            processResults: function(data, page) {
                var results = [];
                $.each(data.licencias, function(i, val) {
                    results.push({id: val.id, text: val.codigo_resolucion});
                });
                return {
                    results: results
                };
            }
        }
    });

    $('#auxiliar-id', $thisModal).select2({
        dropdownParent: $thisModal,
        ajax: {
            url: function() {
                return '/api/auxiliares.json?licencia=' + $('#tipo-licencia-id', $thisModal).val();
            },
            type: 'GET',
            dataType: 'json',
            delay: 350,
            cache: true,
            data: function (query) {
                return {
                    q: query.term
                }
            },
            processResults: function(data, page) {
                var results = [];
                $.each(data.auxiliares, function(i, val) {
                    results.push({id: val.id, text: val.nombre_completo});
                });
                return {
                    results: results
                };
            }
        }
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
        $('#macro-zonas-ids', $thisModal).select2({data: macro_zonas});
    });
    $('#macro-zonas-ids', $thisModal).select2({dropdownParent: $thisModal});

    $('#fecha-promulgacion-date-container', $thisModal).datetimepicker(dateOptions(false, moment()));
    $('#fecha-inicio-date-container', $thisModal).datetimepicker(dateOptions(false));
    $('#fecha-termino-date-container', $thisModal).datetimepicker(dateOptions(false));

    $("#fecha-inicio-date-container", $thisModal).on('dp.change', function() {
      $('#fecha-termino-date-container', $thisModal).data("DateTimePicker")
      .minDate($('#fecha-inicio-date-container', $thisModal).data("DateTimePicker").date())
      .date($('#fecha-inicio-date-container', $thisModal).data("DateTimePicker").date());
    });

    $('#costo-unidad-id', $thisModal).select2();

    /** Manejo de UMD **/
    idx_num = 0;
    $('#add-numeracion-btn', $thisModal).on('click', function (e){
        e.preventDefault();

        var tmp_html = '<div class="row" role="numeracion-row"><div class="col-md-5">';
        tmp_html += '<input class="form-control input-xs inicio" name="numeraciones['+idx_num+'][inicio]" placeholder="Inicio"/>';
        tmp_html += '</div><div class="col-md-5">';
        tmp_html += '<input class="form-control input-xs fin" name="numeraciones['+idx_num+'][fin]" placeholder="Fin"/>';
        tmp_html += '</div><div class="col-md-2">';
        tmp_html += '<button class="btn btn-danger delete-numeracion-btn btn-26"><i class="fa fa-trash"></i></button>';
        tmp_html += '</div></div>';

        $('#numeraciones-div', $thisModal).append(tmp_html);
        idx_num++;

        $('#numeraciones-div .row:last input[name$="[inicio]"]', $thisModal).rules('add', {
            required: true,
            digits: true,
            min: function(e) {
                var $prevRow = $(e).parents('.row[role="numeracion-row"]').prev();
                if($prevRow) {
                    var cantidad_fin = $('input[name$="[fin]"]', $prevRow).val();
                    return cantidad_fin?+(cantidad_fin)+1:undefined;
                }
                return undefined;
            },
            max: function(e) {
                var $thisRow = $(e).parents('.row[role="numeracion-row"]');
                var cantidad_fin = $('input[name$="[fin]"]', $thisRow).val();
                var limit = cantidad_fin>0?+(cantidad_fin)-1:0;
                return cantidad_fin?limit:undefined;
            }
        });
        $('#numeraciones-div .row:last input[name$="[fin]"]', $thisModal).rules('add', {
            required: true,
            digits: true,
            min: function(e) {
                var $thisRow = $(e).parents('.row[role="numeracion-row"]');
                var cantidad_inicio = $('input[name$="[inicio]"]', $thisRow).val();
                return cantidad_inicio?+(cantidad_inicio)+1:undefined;
            },
            max: function(e) {
                var $nextRow = $(e).parents('.row[role="numeracion-row"]').next();
                if($nextRow) {
                    var cantidad_inicio = $('input[name$="[inicio]"]', $nextRow).val();
                    var limit = cantidad_inicio>0?+(cantidad_inicio)-1:0;
                    return cantidad_inicio?limit:undefined;
                }
                return undefined;
            },
        });
    });

    $('#numeraciones-div', $thisModal).on('click', '.delete-numeracion-btn', function(e) {
        e.preventDefault();

        var parentRow = $(this).parents('.row[role="numeracion-row"]');
        parentRow.remove();
        idx_num--;

        updateUMD();
    });

    $($thisModal).on('blur', 'input.inicio, input.fin', function() {
        updateUMD();
    });
    $($thisModal).on('blur', '#porcentaje', function() {
        updateUMR();
    });

    /**
     * Actualiza la cantidad UMDs totales segun los tramos ingresados en el
     * Formulario
     */
    function updateUMD() {
        /** Calculo UMD **/
        var umd_total = 0;
        $('#numeraciones-div .row', $thisModal).each(function(i, e) {
            var $thisRow = $(this);
            var cantidad_inicio = $('input[name$="[inicio]"]', $thisRow).val();
            var cantidad_fin = $('input[name$="[fin]"]', $thisRow).val();

            // El valor de las UMDs debe ser corregido agregando 1 pues se
            // incluyen los extremos
            umd_total += cantidad_fin - cantidad_inicio + 1;
        });
        $('#umd-total', $thisModal).val(umd_total);
    }

    function updateUMR() {
        var cantidad = toggleNumberFormat($('#porcentaje', $thisModal).val(), 7);
        var umr_total = toggleNumberFormat(cantidad % 0.00001, 7)
        console.log(cantidad % 0.00001);
        $('#umr-total', $thisModal).val(umr_total);
    }

     $('#licencia-form', $thisModal).validate({
         rules: {
             tipo_licencia_id: {
                 required: true
             },
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
             auxiliar_id: {
                 required: true
             },
             especie_id: {
                 required: true
             },
             "macro_zonas[_ids]": {
                 required: true
             },
             costo: {
                required: true,
                number: true
             },
             costo_unidad_id: {
                 required: true
             },
             adjunto_file: {
               fileExtension: ['pdf']
             },
             "unidades[0][_joinData][cantidad]": {
                 required: true,
                 number: true,
                 numberrange: [0, 100]
             },
             "unidades[1][_joinData][cantidad]": {
                 numberEqual: function(e) {
                     var cantidad = toggleNumberFormat($('#porcentaje', $thisModal).val(), 7);
                     var umd_total = toggleNumberFormat(cantidad / 0.00001, 0)
                     console.log("total umd calculado", umd_total);
                     return umd_total
                 }
             }
         },
         messages: {
             "unidades[1][_joinData][cantidad]": {
                 equalTo: "La cantidad de UMD debe ser proporcinal al procentaje ingresado."
             }
         }
     });

     /*** BOTONES NEW ***/
     $('#new-auxiliar', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Auxiliar', '/auxiliares/add/sindicato', {
             successCallback: function ( data ){
                 $.each(data.data.funciones, function (i, v) {
                     var $select = $('select[name="'+v+'_id"]');
                     $select.append('<option value="'+data.auxiliar.id+'">'+data.auxiliar.nombre_completo+'</option>');
                 });
             }
         });
     });
     $('#new-nave', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Auxiliar', '/naves/add', {
             successCallback: function ( data ){
                 $.each(data, function (i, v) {
                     var $select = $('select[name="'+v+'_id"]');
                     $select.append('<option value="'+data.nave.id+'">'+data.nave.nombre+'</option>');
                 });
             }
         });
     });
     $('#new-especie', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Especie', '/especies/add', {
             successCallback: function ( data ){
                 var $select = $('select[name="especie_id"]', $thisModal);
                 $select.append('<option value="'+data.especie.id+'">'+data.especie.nombre+'</option>');
             }
         });
     });
     $('#new-macro-zona', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Macro Zona', '/macro_zonas/add', {
             successCallback: function ( data ){
                 var $select = $('select[name="macro_zonas[_ids][]"]', $thisModal);
                 $select.append('<option value="'+data.macro_zona.id+'">'+data.macro_zona.nombre+'</option>');
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
