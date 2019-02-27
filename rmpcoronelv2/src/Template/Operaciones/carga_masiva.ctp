<?php
$hash_id = hash('md5', time());
?>
<div class="row" id="<?= $hash_id?>">
    <div class="col-md-12"><legend>Carga Masiva</legend></div>
    <div class="col-md-12" style="margin-bottom: 15px;">
        <button id="btn-guarda-correctos" class="btn">Cargar Correctos</button>
    </div>

    <div class="col-md-12">
        <div id="div-paste"
             contenteditable="true"
             class="centered"
             style="min-height: 39px; border: 1px solid #ccc; margin-bottom: 15px; font-size: 18px;"
             data-placeholder="Carga (Pegar aquí datos desde Excel)">
                 <h4 style="color: #ccc;">Carga (Pegar aquí datos desde Excel)</h4>
             </div>
    </div>

    <div class="col-md-12">
        <table id="carga-table" class="table table-striped table-hover table-bordered">
            <thead>
                <th></th>
                <th>Especie
                    <?php if (array_in_array(['admin_especie_add'], $current_user['privilegios'])): ?>
                      <button class="btn pull-right" onclick="newEspecie(event);">Nueva</button>
                    <?php else: ?>
                      <button class="btn pull-right" disabled>Nueva</button>
                    <?php endif; ?>
                </th>
                <th>Licencia
                    <?php if (array_in_array(['cuotas_licencia_add'], $current_user['privilegios'])): ?>
                      <button class="btn pull-right" onclick="newLicencia(event);">Nueva</button>
                    <?php else: ?>
                      <button class="btn pull-right" disabled>Nueva</button>
                    <?php endif; ?>
                </th>
                <th>Fecha de Promulgación</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Termino</th>
                <th>Macro Zona
                    <?php if (array_in_array(['admin_zona_add'], $current_user['privilegios'])): ?>
                      <button class="btn pull-right" onclick="newMacroZona(event);">Nueva</button>
                    <?php else: ?>
                      <button class="btn pull-right" disabled>Nueva</button>
                    <?php endif; ?>
                </th>
                <th>Cantidad</th>
                <th>Tipo de Operación
                    <?php if (array_in_array(['admin_tipoOperacion_add'], $current_user['privilegios'])): ?>
                      <button class="btn pull-right" onclick="newTipoOperacion(event);">Nueva</button>
                    <?php else: ?>
                      <button class="btn pull-right" disabled>Nueva</button>
                    <?php endif; ?>
                </th>
                <th>Resolución</th>
                <th>Contraparte</th>
                <th>Observaciones</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $thisModal = $('#<?=$hash_id?>');
        /**
         * Configuracion de DataTable
         */
        var cargaOptions = {
            loadUrl: false, // no carga datos.
            selectable: false,
            dataColumns: [
                {
                    "className": "centered",
                    "defaultContent": '\
                    <button class="btn btn-xs btn-delete-operacion"><i class="fa fa-minus"></i></button>\
                    <button class="btn btn-xs btn-save-operacion"><i class="fa fa-plus"></i></button>',
                    "data": function (row) {
                        return null;
                    }
                }, {
                    "className": "especie centered",
                    "defaultContent": "<b>-</b>",
                    "data": function (row) {
                        if (row.licencia && !row.licencia.error) {
                            return row.licencia.especie.nombre;
                        } else if (row.licencia.error) {
                            return null;
                            //return '<select class="select-carga-especie"><option value="" style="width: 100%;"></option></select>';
                        }
                    },
                }, {
                    "className": "licencia",
                    "data": function (row) {
                        display = row.licencia.display_name;
                        if (row.licencia.error) {
                            return '<b>' + display + '</b>';
                        }
                        return '<input type="hidden" name="licencia_id" value="'+row.licencia.id+'"/>' + display;
                    },
                }, {
                    "data": function (row) {
                        return row.fecha_promulgacion?'<input type="hidden" name="fecha_promulgacion" value="'+moment.utc(row.fecha_promulgacion).format('DD-MMM-YYYY')+'"/>'+moment.utc(row.fecha_promulgacion).format('DD-MMM-YYYY'):null;
                    },
                }, {
                    "data": function (row) {
                        return row.fecha_inicio?'<input type="hidden" name="fecha_inicio" value="'+moment.utc(row.fecha_inicio).format('DD-MMM-YYYY')+'"/>'+moment.utc(row.fecha_inicio).format('DD-MMM-YYYY'):null;
                    },
                }, {
                    "data": function (row) {
                        return row.fecha_termino?'<input type="hidden" name="fecha_termino" value="'+moment.utc(row.fecha_termino).format('DD-MMM-YYYY')+'"/>'+moment.utc(row.fecha_termino).format('DD-MMM-YYYY'):null;
                    },
                }, {
                    "className": "macro-zona",
                    "data": function (row) {
                        display = row.macro_zona.nombre;
                        if (row.macro_zona.error) {
                            return '<b>' + display + '</b>';
                        }
                        return '<input type="hidden" name="macro_zona_id" value="'+row.macro_zona.id+'"/>' + display;
                    },
                }, {
                    "data": function (row) {
                        return row.cantidad?'<input type="hidden" name="unidad_id" value="1"><input type="hidden" name="cantidad" value="'+row.cantidad+'"/>'+row.cantidad:null;
                    },
                }, {
                    "className": "tipo-operacion",
                    "data": function (row) {
                        display = row.tipo_operacion.nombre;
                        if (row.tipo_operacion.error) {
                            return '<b>' + display + '</b>';
                        }
                        return '<input type="hidden" name="tipo_operacion_id" value="'+row.tipo_operacion.id+'"/>' + display;
                    },
                }, {
                    "data": function (row) {
                        return row.resolucion?'<input type="hidden" name="resolucion" value="'+row.resolucion+'"/>'+row.resolucion:null;
                    },
                }, {
                    "className": "auxiliar",
                    "data": function (row) {
                        if (row.auxiliar.error) {
                            display = '<b>' + row.auxiliar.rut + '</b>';
                        } else {
                            if (!row.auxiliar.rut) {
                                display = "-";
                            } else {
                                var newrut = row.auxiliar.rut.split('').reverse('').join('').match(/.{1,3}/g).join('.');
                                newrut = newrut.split('').reverse('').join('');
                                display = newrut + '-' + row.auxiliar.verificador;
                            }
                        }
                        return '<input type="hidden" name="auxiliar_id" value="'+row.auxiliar.id+'"/>' + display;
                    },
                }, {
                    "className": "centered",
                    "defaultContent": '<input type="hidden" name="observaciones" value=""/><button class="btn btn-xs btn-observaciones"><i class="fa fa-edit"></i></button>',
                    "data": function (row) {
                        return row.observaciones?'<input type="hidden" name="observaciones" value="'+row.observaciones+'"/><button class="btn btn-xs btn-observaciones"><i class="fa fa-edit"></i></button>':null;
                    },
                }
            ],
            rowCallback: function (row, data, index) {
                if (data.licencia.error || data.macro_zona.error || data.tipo_operacion.error || data.auxiliar.error) {
                    $(row).addClass('danger');

                    $(row).find('select.select-carga-especie').select2({
                        placeholder: 'Especie',
                        data: especies,
                    });
                } else {
                    $(row).addClass('success');
                }
            }
        };
        dataTableEntityInit($('#carga-table', $thisModal), cargaOptions);

        /**
         * Control para el pegado de los datos en la carga masiva
         */
        $('#div-paste', $thisModal).on('paste', function (e) {e.preventDefault();});
        $('#div-paste', $thisModal).on('click', function () {
            $(this).html('');

            $(this).one('paste', function (e) {
                $(this).blur();
                var pasteText = e.originalEvent.clipboardData.getData('text');
                var lines = pasteText.replace(/^\s+|\s+$/g, '').split("\n");
                var len = lines.length;
                $.each(lines, function(i, line) {
                    console.log(line);
                    var values = line.split("\t"); // Se obtienen valores para cada linea
                    if (values.length < 9) { // Deben haber al menos nueve valores
                      errorNotify('Linea mal ingresada, se omite linea ' + (i+1) + '.<br/>Se ha intentado cargar ' + values.length + ' columna(s) para esta operación.');
                      if (i+1 == len) { successNotify('Carga lista para revisión.'); }
                      return true;
                    }

                    var cargaEspecie = values[0];
                    var cargaLicencia = values[1];
                    var cargaFechaPromulgacion = values[2];
                    var cargaFechaInicio = values[3];
                    var cargaFechaTermino = values[4];
                    var cargaMacroZona = values[5];
                    var cargaCantidad = values[6];
                    var cargaTipoOperacion = values[7];
                    var cargaresolucion = values[8];

                    var cargaAuxiliar = ''
                    if (values.length >= 10) {
                        cargaAuxiliar = values[9].trim();
                    }
                    var cargaObservaciones = ''
                    if (values.length >= 11) {
                        cargaObservaciones = values[10].trim();
                    }

                    var licencia = {};
                    var macro_zona = {};
                    var tipo_operacion = {};

                    errorMessage = '';
                    if (!pattLicencias.test(cargaLicencia)) {
                      errorMessage += '&bull; Licencia mal ingresada<br/>';
                    }
                    if (!pattFecha.test(cargaFechaPromulgacion)) {
                      errorMessage += '&bull; Fecha de Promulgación mal ingresada<br/>';
                    }
                    if (!pattFecha.test(cargaFechaInicio)) {
                      errorMessage += '&bull; Fecha de Inicio mal ingresada<br/>';
                    }
                    if (!pattFecha.test(cargaFechaTermino)) {
                      errorMessage += '&bull; Fecha de Termino mal ingresada<br/>';
                    }
                    if (!pattCantidad.test(cargaCantidad)) {
                      errorMessage += '&bull; Cantidad mal ingresada<br/>';
                    }
                    if ( values.length < 9 || (cargaAuxiliar != "" && cargaAuxiliar != "-" && !pattRut.test(cargaAuxiliar)) ) {
                      errorMessage += '&bull; Rut de Contraparte mal ingresado<br/>';
                    }

                    if (errorMessage.length) {
                        errorNotify(errorMessage + '<br/>Se omite linea ' + (i+1));
                        if (i+1 == len) { successNotify('Carga lista para revisión.'); }
                        return true;
                    }

                    // Se verifican los datos por el lado del servidor
                    $.ajax({
                        url: '/api/operaciones/comprobarNuevaOperacion.json',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            nombreEspecie: cargaEspecie,
                            nombreLicencia: cargaLicencia,
                            nombreMacroZona: cargaMacroZona,
                            nombreTipoOperacion: cargaTipoOperacion.replace(/\s+$/g, ''),
                            rutAuxiliar: cargaAuxiliar
                        }
                    })
                    .always(function (data) {
                        var operacionErrorMessage = '';
                        // Chequeo de Licencia
                        if (data.operacion.licencia != null) {
                          licencia = data.operacion.licencia;
                          licencia.error = false;
                        } else {
                          operacionErrorMessage += '<br/>&bull; Licencia';
                          licencia.display_name = cargaLicencia;
                          licencia.error = true;
                        }

                        // Chequeo de Macro Zona
                        if (data.operacion.macro_zona != null) {
                          macro_zona = data.operacion.macro_zona;
                          macro_zona.error = false;
                        } else {
                          operacionErrorMessage += '<br/>&bull; Macro Zona';
                          macro_zona.nombre = cargaMacroZona;
                          macro_zona.error = true;
                        }

                        // Chequeo Tipo Operacion
                        if (data.operacion.tipo_operacion != null) {
                          tipo_operacion = data.operacion.tipo_operacion;
                          tipo_operacion.error = false;
                        } else {
                           operacionErrorMessage += '<br/>&bull; Tipo Operación';
                           tipo_operacion.nombre = cargaTipoOperacion;
                           tipo_operacion.error = true;
                        }

                        // Chequeo Auxiliar
                        if (cargaAuxiliar == "" ||cargaAuxiliar == "-" || data.operacion.auxiliar != null) {
                          if (cargaAuxiliar == "" || cargaAuxiliar == "-") {
                            auxiliar = {"id": null, "rut": null, "verificador": null};
                          } else {
                            auxiliar = data.operacion.auxiliar;
                          }
                          auxiliar.error = false;
                        } else {
                           operacionErrorMessage += '<br/>&bull; Contraparte';
                           auxiliar = {
                               rut: cargaAuxiliar,
                               error: true
                           }
                        }

                        if (operacionErrorMessage.length) {
                            errorNotify('La linea ' + (i+1) + ' contiene errores en:<br/>' + operacionErrorMessage);
                        }

                        // Agrega fila a tabla de operaciones
                        var tmp_data = {
                          licencia: licencia,
                          fecha_promulgacion: moment.utc(cargaFechaPromulgacion, 'DD-MMM-YYYY'),
                          fecha_inicio: moment.utc(cargaFechaInicio, 'DD-MMM-YYYY'),
                          fecha_termino: moment.utc(cargaFechaTermino, 'DD-MMM-YYYY'),
                          macro_zona: macro_zona,
                          cantidad: cargaCantidad,
                          tipo_operacion: tipo_operacion,
                          resolucion: cargaresolucion,
                          auxiliar: auxiliar,
                          observaciones: cargaObservaciones
                        };

                        $('#carga-table', $thisModal).dataTable().DataTable().row.add(tmp_data).draw( false );

                        if (i+1 == len) { successNotify('Carga lista para revisión.'); }
                    });

                });
            });
        });
        $('#div-paste', $thisModal).on('blur', function (e) {
            $(this).html('<h4 style="color: #ccc;">' + $(this).data('placeholder') + '</h4>');
        });
        $('#div-paste', $thisModal).on('keypress', function (e) {e.preventDefault();});

        /** Actualizar observaciones **/
        $('#carga-table tbody').on('click', 'button.btn-observaciones', function(e) {
            e.stopPropagation();
            var $trParent = $(this).parents('tr[role="row"]');
            agregar_observacion($trParent, table=$(this).parents('table'), save=false);
        });

        /**
         * Control de carga de operaciones
         */
        // Borra operaciones
        $('#carga-table tbody', $thisModal).on('click', '.btn-delete-operacion', function(e) {
            var $trParent = $(this).parents('tr[role="row"]');
            BootstrapDialog.confirm({
              message: '¿Seguro de borrar?',
              type: BootstrapDialog.TYPE_DANGER,
              size: BootstrapDialog.SIZE_SMALL,
              callback: function (result) {
                if (result) {
                    $('#carga-table', $thisModal).dataTable().DataTable().row( $trParent ).remove().draw( false );
                }
              }
            });
        });
        obtenerDatosOperacion = function ($row) {
            var licencia_id = $('select[name="licencia_id"]', $row).val();
            if (!licencia_id) {
                licencia_id = $('input[name="licencia_id"]', $row).val();
            }
            var fecha_promulgacion = $('input[name="fecha_promulgacion"]', $row).val();
            var fecha_inicio = $('input[name="fecha_inicio"]', $row).val();
            var fecha_termino = $('input[name="fecha_termino"]', $row).val();
            var macro_zona_id = $('select[name="macro_zona_id"]', $row).val();
            if (!macro_zona_id) {
                macro_zona_id = $('input[name="macro_zona_id"]', $row).val();
            }
            var cantidad = $('input[name="cantidad"]', $row).val();
            var unidad_id = $('input[name="unidad_id"]', $row).val();
            var tipo_operacion_id = $('select[name="tipo_operacion_id"]', $row).val();
            if (!tipo_operacion_id) {
                tipo_operacion_id = $('input[name="tipo_operacion_id"]', $row).val();
            }
            var resolucion = $('input[name="resolucion"]', $row).val();
            var auxiliar_id = $('select[name="auxiliar_id"]', $row).val();
            if (!auxiliar_id) {
                auxiliar_id = $('input[name="auxiliar_id"]', $row).val();
            }
            var observaciones = $('input[name="observaciones"]', $row).val();

            operacion_data = {
                licencia_id: licencia_id,
                fecha_promulgacion: fecha_promulgacion,
                fecha_inicio: fecha_inicio,
                fecha_termino: fecha_termino,
                macro_zona_id: macro_zona_id,
                cantidad: cantidad,
                unidad_id: unidad_id,
                tipo_operacion_id: tipo_operacion_id,
                resolucion: resolucion,
                auxiliar_id: auxiliar_id,
                observaciones: observaciones
            }

            return operacion_data
        }
        comprobarDatosOperacion = function (operacion) {
            var errorMessage = '';

            if (!operacion.licencia_id) {errorMessage += '<br>&bull; Licencia';}
            if (!operacion.fecha_promulgacion) {errorMessage += '<br>&bull; Fecha Promulgación';}
            if (!operacion.fecha_inicio) {errorMessage += '<br>&bull; Fecha Inicio';}
            if (!operacion.fecha_termino) {errorMessage += '<br>&bull; Fecha Termino';}
            if (!operacion.macro_zona_id) {errorMessage += '<br>&bull; Macro Zona';}
            if (!operacion.cantidad) {errorMessage += '<br>&bull; Cantidad';}
            if (!operacion.tipo_operacion_id) {errorMessage += '<br>&bull; Tipo Operación';}
            if (!operacion.resolucion) {errorMessage += '<br>&bull; Resolución';}
            // Ahora no es requerida la presencia de un auxiliar de contraparte
            //if (!operacion.auxiliar_id) {errorMessage += '<br>&bull; Contraparte';}

            return errorMessage;
        };
        $('#carga-table tbody', $thisModal).on('click', '.btn-save-operacion', function(e) {
            e.stopPropagation();
            var $trParent = $(this).parents('tr[role="row"]');
            $trParent.find('button').prop('disabled', true);

            operacion_data = obtenerDatosOperacion($trParent);
            errorMessage = comprobarDatosOperacion(operacion_data);
            if (errorMessage.length) {
                errorNotify('Existen campos obligatorios vacios!<br/>' + errorMessage);
                $(this).prop("disabled", false);
                return;
            }

            $.ajax({
              url: '/operaciones/add',
              type: 'POST',
              dataType: 'json',
              data: operacion_data
            })
            .done(function(data) {
              $('#carga-table', $thisModal).dataTable().DataTable().row( $trParent ).remove().draw( false );
            })
            .fail(function (data) {
                $trParent.find('button').prop("disabled", false);
            });
        });

        /** Guardar todas las operaciones correctas **/
        $('#btn-guarda-correctos').on('click', function (e) {
            e.preventDefault();
            // Se recorren todas las filas de la tabla en busca de los correctos.
            $.each($('#carga-table').find('tr.success'), function (i, operacion) {
                $(operacion).find('button').prop('disabled', true);
                operacion_data = obtenerDatosOperacion($(operacion));
                errorMessage = comprobarDatosOperacion(operacion_data);
                if (errorMessage.length) {
                    errorNotify('Existen campos obligatorios vacios!<br/>' + errorMessage);
                    $(this).prop("disabled", false);
                    return;
                }

                $.ajax({
                  url: '/operaciones/add',
                  type: 'POST',
                  dataType: 'json',
                  data: operacion_data
                })
                .done(function (data) {
                  $('#carga-table', $thisModal).dataTable().DataTable().row( $(operacion) ).remove().draw( false );
                })
                .fail(function (data) {
                    $(operacion).find('button').prop('disabled', false);
                });
            });
            return true;
        });

        /**
         * Corrección de datos incorrectos
         */
        $('#carga-table tbody', $thisModal).on('click', '.select2', function (e) {e.stopPropagation();});
        $('#carga-table tbody', $thisModal).on('click', 'tr.danger td', function (e) {
            if (!$(this).find('b').length) {return true;}

            var $trParent = $(this).parents('tr[role="row"]');
            if ($(this).hasClass('especie')) {
                var especie_html = '\
                <select name="especie_id" lang="es" data-placeholder="Especie" class="form-control input-xs especie-id" style="width: 100%;">\
                <option value=""></option>\
                </select>\
                ';
                $(this).html(especie_html);
                $(this).find('.especie-id').select2({
                    dropdownParent: $thisModal,
                    data: especies
                });
            } else if ($(this).hasClass('licencia')) {
                var especie_id = $trParent.find('.especie-id').val();
                if (!especie_id) {
                    errorNotify('No se ha seleccionado una especie, no se entregaran resultados.');
                    return;
                }; // si no se ha seleccionado una especie no entrega ninguna búsqueda

                var licencia_html = '\
                <select name="licencia_id" lang="es" data-placeholder="Licencia" class="form-control input-xs licencia-id" style="width: 100%;">\
                    <option value=""></option>\
                </select>';
                $(this).html(licencia_html);
                $(this).find('.licencia-id').select2({
                    dropdownParent: $thisModal,
                    ajax: {
                        url: '/api/licencias.json',
                        type: 'GET',
                        dataType: 'json',
                        delay: 350,
                        data: function (query, page) {
                            return {
                                q: query.term,
                                especie: especie_id
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
            } else if ($(this).hasClass('macro-zona')) {
                var macro_zona_html = '\
                <select name="macro_zona_id" lang="es" data-placeholder="Macro Zona" class="form-control input-xs macro-zona-id" style="width: 100%;">\
                    <option value=""></option>\
                </select>';
                $(this).html(macro_zona_html);
                $(this).find('.macro-zona-id').select2({
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
            } else if ($(this).hasClass('tipo-operacion')) {
                var tipo_operacion_html = '\
                <select name="tipo_operacion_id" lang="es" data-placeholder="Tipo Operación" class="form-control input-xs tipo-operacion-id" style="width: 100%;">\
                    <option value=""></option>\
                </select>';
                $(this).html(tipo_operacion_html);
                $(this).find('.tipo-operacion-id').select2({
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
            } else if ($(this).hasClass('auxiliar')) {
                console.log('holash');
                var auxiliar_html = '\
                <select name="auxiliar_id" lang="es" data-placeholder="Contraparte" class="form-control input-xs auxiliar-id" style="width: 100%;">\
                    <option value=""></option>\
                </select>';
                $(this).html(auxiliar_html);
                $(this).find('.auxiliar-id').select2({
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
            }
        });
    });
</script>
