<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
    ?>
    <div class="row" id="<?=$hash_id?>">
        <form id="operacion-form" class="form-horizontal">
            <div class="col-md-12">
                <legend>Operación</legend>
            </div>
            <div class="col-md-12">
                <div class="row">
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
                                            <a class="btn btn-default input-xs" onclick="newEspecie(event);">Nueva</a>
                                        <?php else: ?>
                                            <a class="btn btn-default input-xs" disabled onlick="return false;">Nueva</a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Licencia</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <select class="form-control input-xs" name="licencia_id" id="licencia-id" data-placeholder="Seleccione una Licencia" placeholder="Seleccione una Licencia" lang="es"  style="width: 100%;">
                                    </select>
                                    <div class="input-group-btn">
                                        <?php if (array_in_array(['cuotas_licencia_add'], $current_user['privilegios'])): ?>
                                            <a class="btn btn-default input-xs" onclick="newLicencia(event);">Nueva</a>
                                        <?php else: ?>
                                            <a class="btn btn-default input-xs" disabled onclick="return false;">Nueva</a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha de Promulgación</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-xs date-picker" id="fecha-promulgacion-date">
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
                                <div class="input-group input-group-xs date-picker" id="fecha-inicio-date">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input name="fecha_inicio" id="fecha-inicio-date" type="text" class="form-control" placeholder="Ingrese Fecha de Inicio">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha de Término</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-xs date-picker" id="fecha-termino-date">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input name="fecha_termino" id="fecha-termino-date" type="text" class="form-control" placeholder="Ingrese Fecha de Término">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Macro Zona</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <select class="form-control input-xs" name="macro_zona_id" id="macro-zona-id" data-placeholder="Seleccione la Macro Zona" lang="es" style="width: 100%;">
                                    </select>
                                    <div class="input-group-btn">
                                        <?php if (array_in_array(['admin_zona_add'], $current_user['privilegios'])): ?>
                                            <a class="btn btn-default input-xs" onclick="newMacroZona(event);">Nueva</a>
                                        <?php else: ?>
                                            <a class="btn btn-default input-xs" disabled onclick="return false;">Nueva</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="unidad_id" value="1" />
                                <div class="input-container">
                                    <input name="cantidad" type="text" class="form-control input-xs" value="" placeholder="0,000"/>
                                    <label>TON</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo de Operación</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <select class="form-control input-xs" name="tipo_operacion_id" id="tipo-operacion-id" data-placeholder="Seleccione el Tipo de Operación" lang="es" style="width: 100%;">
                                        <option value></option>
                                    </select>
                                    <div class="input-group-btn">
                                        <?php if (array_in_array(['admin_tipoOperacion_add'], $current_user['privilegios'])): ?>
                                            <a class="btn btn-default input-xs" onclick="newTipoOperacion(event);">Nueva</a>
                                        <?php else: ?>
                                            <a class="btn btn-default input-xs" disabled onlick="return false;">Nueva</a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Resolución</label>
                            <div class="col-sm-9">
                                <input name="resolucion" class="form-control input-xs" placeholder="Ingrese el Nº Resolución"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Contraparte</label>
                        <div class="col-sm-9">
                            <select class="form-control input-xs" name="auxiliar_id" id="auxiliar-id" data-placeholder="Seleccione la Contraparte" lang="es" style="width:100%;">
                              <option value></option>
                            </select>
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
        </form>
    </div>
    <script>
    $(document).ready(function() {
        var $thisModal = $('#<?=$hash_id?>');
        $('#especie-id', $thisModal).select2({
            dropdownParent: $thisModal,
            data: especies // cargadas de index.
        });

        $('#licencia-id', $thisModal).select2({
            dropdownParent: $thisModal,
            ajax: {
                url: '/api/licencias.json',
                type: 'GET',
                dataType: 'json',
                delay: 350,
                data: function (query, page) {
                    var especieId = $('#especie-id', $thisModal).val();
                    return {
                        q: query.term,
                        especie: especieId?especieId:-1
                    }
                },
                processResults: function(data, page) {
                    var results = [];
                    $.each(data.licencias, function(i, licencia) {
                        results.push({text: licencia.display_name, id: licencia.id})
                    });
                    return {
                        results: results
                    };
                }
            }
        });

        $('#fecha-promulgacion-date', $thisModal).datetimepicker(dateOptions(false, moment()));
        $('#fecha-inicio-date', $thisModal).datetimepicker(dateOptions(false));
        $('#fecha-termino-date', $thisModal).datetimepicker(dateOptions(false));

        $("#fecha-inicio-date", $thisModal).on('dp.change', function() {
          $('#fecha-termino-date', $thisModal).data("DateTimePicker")
          .minDate($('#fecha-inicio-date', $thisModal).data("DateTimePicker").date())
          .date($('#fecha-inicio-date', $thisModal).data("DateTimePicker").date());
        });

        $('#macro-zona-id', $thisModal).select2({
            dropdownParent: $thisModal,
            ajax: {
                url: '/api/macro_zonas.json',
                type: 'GET',
                dataType: 'json',
                delay: 350,
                data: function (query, page) {
                    return {
                        q: query.term,
                    }
                },
                processResults: function(data, page) {
                    var results = [];
                    $.each(data.macro_zonas, function(i, val) {
                        results.push({id: val.id, text: val.nombre});
                    });
                    return {
                        results: results
                    };
                }
            }
        });

        $('#tipo-operacion-id', $thisModal).select2({
            dropdownParent: $thisModal,
            ajax: {
                url: '/api/tipo_operaciones.json',
                type: 'GET',
                dataType: 'json',
                delay: 350,
                data: function (query, page) {
                    return {
                        q: query.term,
                    }
                },
                processResults: function(data, page) {
                    var results = [];
                    $.each(data.tipo_operaciones, function(i, val) {
                        results.push({id: val.id, text: val.nombre});
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
                url: '/api/auxiliares.json',
                type: 'GET',
                dataType: 'json',
                delay: 350,
                data: function (query, page) {
                    return {
                        q: query.term,
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

        $('#adjunto-file', $thisModal).on('change', function() {
            $('#adjunto-text-container', $thisModal).val($(this).val().replace(/C:\\fakepath\\/i, '...\\'));
        });

        $('#operacion-form', $thisModal).validate({
            rules: {
                especie_id: {
                    required: true
                },
                licencia_id: {
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
                macro_zona_id: {
                    required: true
                },
                cantidad: {
                    required: true,
                    number: true,
                },
                especie_id: {
                    required: true
                },
                tipo_operacion_id: {
                    required: true
                },
                resolucion: {
                    required: true
                },
                adjunto_file: {
                  fileExtension: ['pdf']
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
        'data' => $marea,
    ]);
}
?>
