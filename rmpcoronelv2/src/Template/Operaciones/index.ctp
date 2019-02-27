<?php
$this->extend('/Common/view');
$this->assign('title', 'Administración Operaciones');
$this->Html->addCrumb('Control Cuotas', ['controller' => 'Home', 'action' => 'index', '#' => 'cuotas']);
$this->Html->addCrumb('Administración de Operaciones');
?>
  <?php
$this->Form->templates([
  'formGroup' => '{{input}}',
  'select' => '<select name="{{name}}" {{attrs}}>{{content}}</select>',
]);
?>
<div class="col-lg-12">
  <div class="widget">
    <div class="widget-header">
      <span class="widget-caption">Operaciones en Cuotas</span>
      <div class="widget-buttons">
        <a href="#" data-toggle="maximize">
          <i class="fa fa-expand"></i>
        </a>
        <a href="#" data-toggle="collapse">
          <i class="fa fa-minus"></i>
        </a>
      </div>
    </div>
    <div class="widget-body">
      <div class="table-toolbar">
        <div class="row">
          <div class="col-md-8 col-sm-6">
            <?php if (array_in_array(['cuotas_operacion_add'], $current_user['privilegios'])): ?>
            <button id="new-operacion" onclick="nuevaOperacion();" class="btn btn-default pull-left">
              Nueva Operación
            </button>
            <?php else: ?>
            <button id="new-operacion" onclick="return false;" class="btn btn-default" disabled="disabled">
              Nueva Operación
            </button>
            <?php endif; ?>

            <?php if (array_in_array(['cuotas_operacion_add'], $current_user['privilegios'])): ?>
            <button id="new-traspaso" class="btn btn-default pull-left">
              Nuevo Traspaso
            </button>
            <?php else: ?>
            <button id="new-traspaso" class="btn btn-default" disabled="disabled">
              Nuevo Traspaso
            </button>
            <?php endif; ?>
            <button id="export-excel" class="btn btn-default">
              Exportar Excel
            </button>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-group input-small pull-right">
              <select name="especie" id="especie-select" class="input-xs form-control" data-placeholder="Especie (Todas)" lang="es">
                <option value></option>
                <?php foreach($especies as $especie): ?>
                  <option value="<?=$especie->Especies->id?>"><?=$especie->Especies->nombre?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group input-small pull-right">
              <select name="year" id="year-select" class="input-xs form-control" data-placeholder="Especie" lang="es">
                <?php foreach($years as $year): ?>
                  <option value="<?=$year?>"><?=$year?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered" id="operaciones-table">
              <thead>
                <tr role="row">
                  <th>id</th>
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
                  <th>Fecha Promulgación</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Termino</th>
                  <th>Macro Zona
                    <?php if (array_in_array(['admin_zona_add'], $current_user['privilegios'])): ?>
                      <button class="btn pull-right" onclick="newMacroZona(event);">Nueva</button>
                    <?php else: ?>
                      <button class="btn pull-right" disabled>Nueva</button>
                    <?php endif; ?>
                  </th>
                  <th>Cantidad</th>
                  <th>Tipo Operación
                    <?php if (array_in_array(['admin_tipoOperacion_add'], $current_user['privilegios'])): ?>
                      <button class="btn pull-right" onclick="newTipoOperacion(event);">Nueva</button>
                    <?php else: ?>
                      <button class="btn pull-right" disabled>Nueva</button>
                    <?php endif; ?>
                  </th>
                  <th>Resolución</th>
                  <th>Contraparte</th>
                  <th>Observaciones</th>
                  <th>Adjunto</th>
                  <th>_sort</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?= $this->start('jquery'); ?>
<script>
$(document).ready(function() {
    especie_query = '';
    especie_id = '';

    /** Patrones para la verificacion de datos del lado del cliente**/
    pattLicencias = /^\d{4}\-[a-z0-9_]+$/i;
    pattFecha = /^\d{2}-(ene|feb|mar|abr|may|jun|jul|ago|sep|oct|nov|dic)-\d{4}$/i
    pattCantidad = /^-?\d+(,\d+)?$/i;
    pattRut = /^\d{1,2}\.\d{3}\.\d{3}-(\d|K)$/i;
  // se cargan datos y crea select2 para especies
  especies = [];
  $.ajax({
    url: '/api/especies.json',
    dataType: 'json',
    type: 'GET',
    data: {
        tieneLicencias: true
    }
  }).done(function(data) {
    $.each(data.especies, function(i, val) {
      especies.push({id: val.id, text: val.nombre});
    });
    $('#especie-select').select2({
      data: especies,
      allowClear: true,
    });
  });
  $('#especie-select').select2({allowClear: true});
  // Se crean select2 para años
  $('#year-select').select2();

  $('#especie-select').on('change', function() {
    especie_query = '';
    if ($('#especie-select').val()) {
      especie_query = '&especie=' + $('#especie-select').val();
    }
    $('#operaciones-table').dataTable().DataTable().ajax.reload();
  });

  $('#year-select').on('change', function() {
    $('#operaciones-table').dataTable().DataTable().ajax.reload();
  });

  operacionesOptions = {
    "serverSide": true,
    "processing": true,
    "scrollY": false,
    ajax: {
      'url': function() {return '/api/operaciones/listar.json?year=' + $('#year-select').val() + especie_query;},
      'type': 'POST',
      'dataType': 'json',
      'dataSrc': 'operaciones'
    },
    actionButtons:
    <?php if (array_in_array(['cuotas_operacion_edit'], $current_user['privilegios'])): ?>
    '<button onclick="cargaMasiva();return false;" id="carga-masiva-btn" class="btn btn-xs"><i class="fa fa-database"></i> Carga Masiva</button>' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Carga Masiva</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['cuotas_operacion_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteRowTable();" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "name": "Operaciones.id",
        "className": "id",
        "defaultContent": "",
        "data": "id"
      }, {
        "name": "Operaciones.Licencias.especie",
        "className": "especie",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
            if (row.licencia && !row.licencia.error) {
                return row.licencia.especie.nombre
            } else {
                return null
            }
        }
      }, {
        "name": "Licencias.fecha_promulgacion",
        "className": "licencia",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
            var display = null;
            if (row.licencia) {
                display = row.licencia.display_name;
            }
            return display;
        },
      }, {
        "name": "Operaciones.fecha_promulgacion",
        "className": "fecha_promulgacion",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
          return row.fecha_promulgacion?moment.utc(row.fecha_promulgacion).format('DD-MMM-YYYY'):null;
        },
      }, {
        "name": "Operaciones.fecha_inicio",
        "className": "fecha_inicio",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
          return row.fecha_inicio?moment.utc(row.fecha_inicio).format('DD-MMM-YYYY'):null;
        },
      }, {
        "name": "Operaciones.fecha_termino",
        "className": "fecha_termino",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
          return row.fecha_termino?moment.utc(row.fecha_termino).format('DD-MMM-YYYY'):null;
        },
      }, {
        "name": "Operaciones.macro_zona",
        "className": "macro_zona",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
          return row.macro_zona?row.macro_zona.nombre:null;
        },
      }, {
        "name": "Operaciones.cantidad",
        "className": "cantidad",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
          return row.cantidad?toggleNumberFormat(row.cantidad):null;
        },
      }, {
        "name": "Operaciones.tipo_operacion",
        "className": "tipo_operacion",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
          return row.tipo_operacion?row.tipo_operacion.nombre:null;
        },
      }, {
        "name": "Operaciones.resolución",
        "className": "resolucion",
        "defaultContent": '<span class="empty">Click!</span>',
        "data": function (row) {
            return row.resolucion?row.resolucion:null;
        }
      }, {
          "name": "Auxiliares.rut",
          "className": "auxiliar",
          "defaultContent": '<span class="empty">Click!</span>',
          "data": function (row) {
              if (row.auxiliar) {
                  var newrut = row.auxiliar.rut.split('').reverse('').join('').match(/.{1,3}/g).join('.');
                  newrut = newrut.split('').reverse('').join('');
                  return newrut+'-'+row.auxiliar.verificador;
              } else {
                  return null;
              }
          }
      }, {
        "name": "Operaciones.observaciones",
        "className": "observaciones centered",
        "defaultContent": '<input type="hidden" name="observaciones" value=""/><button class="btn btn-xs"><i class="fa fa-edit"></i></button>',
        "data": function (row) {
            return row.observaciones?'<input type="hidden" name="observaciones" value="'+row.observaciones+'"/><button class="btn btn-xs"><i class="fa fa-edit"></i></button>':null;
        }
      }, {
        "defaultContent": '<button disabled="disabled" class="btn btn-xs"><i class="fa fa-upload"></i></button>',
        "class": "centered",
        "data": function (row) {
            if (row.id) {
                if (row.licencia) {
                    if (row.adjunto) {
                        return '<a href="/uploads/'+row.adjunto+'" class="btn btn-xs" target="_blank" label="Descarga Adjunto"><i class="fa fa-download"></i></a>'
                    } else {
                        return '<button class="upload-file btn-xs btn" label="Adjuntar Archivo"><i class="fa fa-upload"></i></button>'
                    }
                }
                return null
            } else {
                return null;
            }
        },
      }, {
        "name": "sort",
        "defaultContent": "1",
        "className": "sort",
        "data": "sort",
        "visible": false
      }
    ],
    "orderFixed": {
      "pre": [[ 2, 'asc']]
    },
    rowCallback: function(row, data, index) {
      if ( data.nueva_operacion ) {
        $(row).addClass('nuevo');
        $('td.id', $(row)).addClass('save').html('<span class="btn btn-xs send-operacion-btn"><i class="fa fa-plus"></i></span>');
      }
      $(row).addClass('cargado');
    }
  };

  dataTableEntityInit($('#operaciones-table'), operacionesOptions);

  $('#operaciones-table tbody').on('click', 'td select, td input, td span.select2', function(e) {
    e.stopPropagation();
  });

  // especie
  $('#operaciones-table tbody').on('dblclick', 'tr.nuevo td.especie, tr.danger td.especie', function(e) {
      // Si esta vacio o no es una nueva fila
      if ( $(this).find('select:disabled').length) {e.stopPropagation(); return;}

      e.stopPropagation();
      var $trParent = $(this).parents('tr[role="row"]');
      var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

      // Se cre el select
      var tmp_html = '<select name="especie_id" lang="es" data-placeholder="Especie" class="form-control input-xs" style="width: 100%;">\
      <option value></option>\
      </select>';
      $(this).html(tmp_html);

      $('select', $(this)).select2({
          data: especies
      });
  });

  // licencia
  $('#operaciones-table tbody').on('dblclick', 'td.licencia', function(e) {
    // Si esta vacio
    if ( $(this).find('select:disabled').length ) {e.stopPropagation(); return;}

    e.stopPropagation();
    var $trParent = $(this).parents('tr[role="row"]');
    var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

    var tmp_html = '<select name="licencia_id" lang="es" data-placeholder="Licencia" class="form-control input-xs" style="width: 100%;">';
    if (dataRow.licencia) {
      tmp_html += '<option value="'+dataRow.licencia.id+'">'+dataRow.licencia.display_name+'</option>'
    } else {
      tmp_html += '<option value></option>'
    }
    tmp_html += '</select>';
    $(this).html(tmp_html);

    var especie_id = -1;
    if ($trParent.hasClass('nuevo') || !dataRow.licencia.especie) {
        var selectEspecie = $trParent.find('select[name="especie_id"]');
        if (selectEspecie.length) {
            especie_id = selectEspecie.val();
        } else {
            especie_id = -1;
        }
        especie_id = !especie_id ? -1 : especie_id;
    } else {
        especie_id = dataRow.licencia.especie.id;
    }

    if (especie_id == -1) {
        $('select', $(this)).prop('disabled', true);
    }

    $('select', $(this)).select2({
      dropdownParent: $(this),
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
  });
  // fecha_promulgacion
  $('#operaciones-table tbody').on('dblclick', 'td.fecha_promulgacion', function(e) {
    // Si esta vacio
    var tmp_html = '\
    <div class="input-group input-group-xs date-picker fecha-promulgacion-date">\
    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>\
    <input name="fecha_promulgacion" type="text" class="form-control" placeholder="Fecha de Promulgación">\
    </div>';
    if ($(this).find('span.empty').length) {
      e.stopPropagation();
      $(this).html(tmp_html);

      $('.fecha-promulgacion-date', $(this)).datetimepicker(dateOptions(false, moment(), $('body')));
    // si no esta vacio
    } else {
      if ($(this).find('select, input[type="text"]').length) {
        e.stopPropagation();
      } else {
        e.stopPropagation();
        $(this).html(tmp_html);

        var $trParent = $(this).parents('tr[role="row"]');
        var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

        $('.fecha-promulgacion-date', $(this)).datetimepicker(dateOptions(false, moment(), $('body')));
        $('.fecha-promulgacion-date', $(this)).data("DateTimePicker").date(moment.utc(dataRow.fecha_promulgacion));
      }
      return;
    }
  });
  // fecha_inicio
  $('#operaciones-table tbody').on('dblclick', 'td.fecha_inicio', function(e) {
    var tmp_html = '\
    <div class="input-group input-group-xs date-picker fecha-inicio-date">\
    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>\
    <input name="fecha_inicio" type="text" class="form-control" placeholder="Fecha de Inicio">\
    </div>';
    // Si esta vacio
    if ($(this).find('span.empty').length) {
      e.stopPropagation();
      $(this).html(tmp_html);

      $('.fecha-inicio-date', $(this)).datetimepicker(dateOptions(false, false, $('body')));

      var $parentRow = $(this).parents('tr');
      $('.fecha-inicio-date', $(this)).on('dp.change', function() {
        if ($('.fecha-termino-date', $parentRow).length) {
          $('.fecha-termino-date', $parentRow).data("DateTimePicker")
          .minDate($('.fecha-inicio-date', $parentRow).data("DateTimePicker").date());
        }
      });
    // si no esta vacio
    } else {
      if ($(this).find('select, input[type="text"]').length) {
        e.stopPropagation();
      } else {
        e.stopPropagation();
        $(this).html(tmp_html);

        var $trParent = $(this).parents('tr[role="row"]');
        var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

        $('.fecha-inicio-date', $(this)).datetimepicker(dateOptions(false, false, $('body')));
        $('.fecha-inicio-date', $(this)).data("DateTimePicker").date(moment.utc(dataRow.fecha_inicio));
      }
      return;
    }
  });
  // fecha_termino
  $('#operaciones-table tbody').on('dblclick', 'td.fecha_termino', function(e) {
    var tmp_html = '\
    <div class="input-group input-group-xs date-picker fecha-termino-date">\
    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>\
    <input name="fecha_termino" type="text" class="form-control" placeholder="Fecha de Termino">\
    </div>';
    // Si esta vacio
    if ($(this).find('span.empty').length) {
      e.stopPropagation();
      $(this).html(tmp_html);

      $('.fecha-termino-date', $(this)).datetimepicker(dateOptions(false, false, $('body')));
      var $parentRow = $(this).parents('tr');
      if ($('.fecha-inicio-date', $parentRow).length) {
        $('.fecha-termino-date', $parentRow).data("DateTimePicker")
        .minDate($('.fecha-inicio-date', $parentRow).data("DateTimePicker").date());
      }
    // si no esta vacio
    } else {
      if ($(this).find('select, input[type="text"]').length) {
        e.stopPropagation();
      } else {
        e.stopPropagation();
        $(this).html(tmp_html);

        var $trParent = $(this).parents('tr[role="row"]');
        var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

        $('.fecha-termino-date', $(this)).datetimepicker(dateOptions(false, false, $('body')));
        $('.fecha-termino-date', $(this)).data("DateTimePicker")
          .minDate(moment.utc(dataRow.fecha_inicio))
          .date(moment.utc(dataRow.fecha_termino));
      }
      return;
    }
  });
  // macro_zona
  $('#operaciones-table tbody').on('dblclick', 'td.macro_zona', function(e) {
    if ( $(this).find('select:disabled').length ) {e.stopPropagation(); return;}
    // Si esta vacio
    e.stopPropagation();
    var $trParent = $(this).parents('tr[role="row"]');
    var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();
    var tmp_html = '<select name="macro_zona_id" lang="es" data-placeholder="Macro Zona" class="form-control input-xs" style="width: 100%;">';

    if (dataRow.macro_zona.id) {
      tmp_html += '<option value="'+dataRow.macro_zona.id+'">'+dataRow.macro_zona.nombre+'</option>'
    } else {
      tmp_html += '<option value></option>'
    }
    tmp_html += '</select>';
    $(this).html(tmp_html);

    $('select', $(this)).select2({
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
  });
  // cantidad
  $('#operaciones-table tbody').on('dblclick', 'td.cantidad', function(e) {
    var tmp_html = '\
    <input type="hidden" name="unidad_id" value="1">\
    <div class="input-container">\
    <input type="text" name="cantidad" placeholder="Cantidad" class="form-control input-xs">\
    <label>TON</label>\
    </div>\
    ';
    // Si esta vacio
    if ($(this).find('span.empty').length) {
      e.stopPropagation();
      $(this).html(tmp_html);
    // si no esta vacio
    } else {
      if ($(this).find('select, input[type="text"]').length) {
        e.stopPropagation();
      } else {
        e.stopPropagation();
        $(this).html(tmp_html);

        var $trParent = $(this).parents('tr[role="row"]');
        var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

        $('[name="cantidad"]', $(this)).val(toggleNumberFormat(dataRow.cantidad));
      }
      return;
    }
  });
  // tipo_operacion
  $('#operaciones-table tbody').on('dblclick', 'td.tipo_operacion', function(e) {
    if ( $(this).find('select:disabled').length ) {e.stopPropagation(); return;}
    // Si esta vacio
    e.stopPropagation();
    var $trParent = $(this).parents('tr[role="row"]');
    var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

    var tmp_html = '<select name="tipo_operacion_id" lang="es" data-placeholder="Tipo Operación" class="form-control input-xs" style="width: 100%;">';
    if (dataRow.tipo_operacion.id) {
      tmp_html += '<option value="'+dataRow.tipo_operacion.id+'">'+dataRow.tipo_operacion.nombre+'</option>'
    } else {
      tmp_html += '<option value></option>'
    }
    tmp_html += '</select>';

    $(this).html(tmp_html);

    $('select', $(this)).select2({
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
  });
  // resolucion
  $('#operaciones-table tbody').on('dblclick', 'td.resolucion', function(e) {
      var tmp_html = '\
      <div>\
      <input type="text" name="resolucion" placeholder="Nº Res." class="form-control input-xs" style="width:100%;">\
      </div>\
      ';
      // Si esta vacio
      if ($(this).find('span.empty').length) {
        e.stopPropagation();
        $(this).html(tmp_html);
      // si no esta vacio
      } else {
        if ($(this).find('select, input[type="text"]').length) {
          e.stopPropagation();
        } else {
          e.stopPropagation();
          $(this).html(tmp_html);

          var $trParent = $(this).parents('tr[role="row"]');
          var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

          $('[name="resolucion"]', $(this)).val(toggleNumberFormat(dataRow.resolucion));
        }
        return;
      }
  });
  //auxiliar
  $('#operaciones-table tbody').on('dblclick', 'td.auxiliar', function(e) {
    if ( $(this).find('select:disabled').length ) {e.stopPropagation(); return;}
    // Si esta vacio
    e.stopPropagation();
    var $trParent = $(this).parents('tr[role="row"]');
    var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

    var tmp_html = '<select name="auxiliar_id" lang="es" data-placeholder="Contraparte" class="form-control input-xs" style="width: 100%;">';
    if (dataRow.auxiliar) {
      tmp_html += '<option value="'+dataRow.auxiliar.id+'">'+dataRow.auxiliar.nombre_completo+'</option>'
    } else {
      tmp_html += '<option value></option>'
    }
    tmp_html += '</select>';

    $(this).html(tmp_html);

    $('select', $(this)).select2({
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
  });

  // observaciones
  $('#operaciones-table tbody').on('click', 'td.observaciones button', function(e) {
      var $trParent = $(this).parents('tr[role="row"]');
      agregar_observacion($trParent, save=true);
  });

  agregar_observacion = function ($row, table=false, save=true) {
      var observaciones_text = $row.find('input[name="observaciones"]').val();
      if (!table) {
          var dataRow = $('#operaciones-table').DataTable().row( $row ).data();
      } else {
          var dataRow = table.DataTable().row( $row ).data();
      }
      var operacion_id = dataRow.id;

      BootstrapDialog.show({
        title: "Observaciones",
        closable: false,
        buttons: [
          {
            label: 'Guardar',
            cssClass: 'btn-success',
            action: function (dialog) {
                var new_observaciones_text = dialog.getModal().find('textarea').val();
                // console.log(new_observaciones_text);
                if (save) {
                    $.ajax({
                        url: '/operaciones/edit/' + operacion_id,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            observaciones: new_observaciones_text
                        }
                    })
                    .done(function (data) {
                        $('#operaciones-table').DataTable().row( $row ).remove();
                        $('#operaciones-table').DataTable().row.add(data.operacion).draw( false );
                        dialog.close();
                    });
                } else {
                    $row.find('input[name="observaciones"]').val(new_observaciones_text);
                    dialog.close();
                }
            }
          },
          {
            label: 'Cerrar',
            action: function(dialog) {
              BootstrapDialog.confirm({
                message: "¿Está seguro de descartar los cambios?",
                type: BootstrapDialog.TYPE_WARNING,
                size: BootstrapDialog.SIZE_SMALL,
                callback: function (result) {
                  if ( result )
                  dialog.close();
                }
              });
            }
          },
        ],
        message: function(dialog) {
          var $message = $('<div class="row">\
            <div class="col-md-12">\
              <div class="form-group">\
                  <label class="col-sm-3 control-label">Observaciones</label>\
                  <div class="col-sm-9">\
                    <textarea class="form-control">'+ observaciones_text +'</textarea>\
                  </div>\
              </div>\
             </div>\
          </div>');
          return $message;
        }
      });
  }

  /** Funciones de Operaciones **/
  nuevaOperacion = function() {
    newEntity('Nueva Operación', '/operaciones/add');
    if ($('#new-operacion').hasClass('active')) {
      cancelNuevaOperacion();
      return;
    }
  }

  $('#operaciones-table tbody').on('click', '.send-operacion-btn', function(e) {
      e.stopPropagation();
      $('#send-operacion').prop("disabled", true);
      $('#cancel-new-operacion').prop("disabled", true);
      var $newOperacionRow = $('#operaciones-table tbody tr:has(select, span.empty, input[type="text"])');

      if ($newOperacionRow.find('span.empty').length) {
        errorNotify('Todos los campos son obligatorios!');
        $('#send-operacion').prop("disabled", false);
        $('#cancel-new-operacion').prop("disabled", false);
        return;
      }

      var error = false
      $('select, input', $newOperacionRow).each(function(i, e) {
        if (!$(e).val()) {
          error = true;
        }
      });
      if (error) {
        errorNotify('Todos los campos son obligatorios!');
        return;
      }

      var licencia_id = $('select[name="licencia_id"]', $newOperacionRow).val();
      var fecha_promulgacion = $('input[name="fecha_promulgacion"]', $newOperacionRow).val();
      var fecha_inicio = $('input[name="fecha_inicio"]', $newOperacionRow).val();
      var fecha_termino = $('input[name="fecha_termino"]', $newOperacionRow).val();
      var macro_zona_id = $('select[name="macro_zona_id"]', $newOperacionRow).val();
      var cantidad = $('input[name="cantidad"]', $newOperacionRow).val();
      var unidad_id = $('input[name="unidad_id"]', $newOperacionRow).val();
      var tipo_operacion_id = $('select[name="tipo_operacion_id"]', $newOperacionRow).val();

      $.ajax({
        url: '/operaciones/add',
        type: 'POST',
        dataType: 'json',
        data: {
          licencia_id: licencia_id,
          fecha_promulgacion: fecha_promulgacion,
          fecha_inicio: fecha_inicio,
          fecha_termino: fecha_termino,
          macro_zona_id: macro_zona_id,
          cantidad: cantidad,
          unidad_id: unidad_id,
          tipo_operacion_id: tipo_operacion_id
        }
      })
      .done(function(data) {
        $('#operaciones-table').dataTable().DataTable().row( $newOperacionRow ).remove();
        $('#operaciones-table').dataTable().DataTable().row.add(data.operacion).draw( false );
        $('#send-operacion').hide();
        $('#cancel-new-operacion').hide();
        $('#new-operacion').show();
        $('#carga-masiva-btn').prop("disabled", false);
        $('#send-operacion').prop("disabled", false);
        $('#cancel-new-operacion').prop("disabled", false);
        $('#new-operacion').removeClass('active');
      });
  });

  /********* NUEVAS ENTIDADES **********/
  newEspecie = function (e) {
      e.stopPropagation();
      newEntity('Nueva Especie', '/especies/add');
  }
  newLicencia = function (e) {
      e.stopPropagation();
      newEntity('Nueva Licencia', '/licencias/add');
  }
  newMacroZona = function (e) {
      e.stopPropagation();
      newEntity('Nueva Macro Zona', '/macro_Zonas/add');
  }
  newTipoOperacion = function (e) {
      e.stopPropagation();
      newEntity('Nuevo Tipo de Operación', '/tipo_operaciones/add');
  }

  /********* CARGA MASIVA ***********/

  /**
   * La función crea un nuevo modal que permite realizar la copia y validación
   * de los datos que se desean subir como carga masiva
   */
  cargaMasiva = function() {
    BootstrapDialog.show({
        title: 'Carga Masiva de Operaciones',
        closable: false,
        size: BootstrapDialog.SIZE_WIDE,
        buttons: [{
            label: 'Cerrar',
            action: function( dialog ) {
                BootstrapDialog.confirm({
                    message: "Esta seguro de Cerrar la Carga Masiva",
                    type: BootstrapDialog.TYPE_WARNING,
                    size: BootstrapDialog.SIZE_SMALL,
                    callback: function (result) {
                        if ( result ) {
                            $('#new-operacion').prop("disabled", false);
                            $('#carga-masiva-btn').removeClass("active");
                            dialog.close();
                        }
                    }
                });
            }
        }],
        message: function (dialog) {
            var $message = $('<div></div>');
            $message.load( '/operaciones/carga_masiva', function () {
            });
            return $message;
        }
    });
  }

  /** Intenta guardar los datos cargados de la fila en cuestion **/
  $('#operaciones-table tbody').on('click', 'tr.cargado td.save span', function(e) {
    e.stopPropagation();
    if ($(this).hasClass('working')) return;
    var $trParent = $(this).parents('tr[role="row"]');

    if ($trParent.hasClass('success')) {
      $(this).addClass('working');
      $(this).removeClass('btn btn-xs').find('i').addClass('fa-spinner fa-spin fa-lg').removeClass('fa-plus');

      var licencia_id = $('[name="licencia_id"]:last', $trParent).val();
      var fecha_promulgacion = $('[name="fecha_promulgacion"]:last', $trParent).val();
      var fecha_inicio = $('[name="fecha_inicio"]:last', $trParent).val();
      var fecha_termino = $('[name="fecha_termino"]:last', $trParent).val();
      var macro_zona_id = $('[name="macro_zona_id"]:last', $trParent).val();
      var unidad_id = $('[name="unidad_id"]:last', $trParent).val();
      var cantidad = $('[name="cantidad"]:last', $trParent).val();
      var tipo_operacion_id = $('[name="tipo_operacion_id"]:last', $trParent).val();

      $.ajax({
        url: '/operaciones/add',
        type: 'POST',
        dataType: 'json',
        data: {
          licencia_id: licencia_id,
          fecha_promulgacion: fecha_promulgacion,
          fecha_inicio: fecha_inicio,
          fecha_termino: fecha_termino,
          macro_zona_id: macro_zona_id,
          cantidad: cantidad,
          unidad_id: unidad_id,
          tipo_operacion_id: tipo_operacion_id
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      })
      .done(function (data) {
        $('#operaciones-table').dataTable().DataTable().row.add(data.operacion);
        $('#operaciones-table').dataTable().DataTable().row( $trParent ).remove().draw( false );
      })
    } else if ( $trParent.hasClass('danger') ) {
      $(this).addClass('working');
      $(this).removeClass('btn btn-xs').find('i').addClass('fa-spinner fa-spin fa-lg').removeClass('fa-plus');

      // TODO: continuar aca, implementar validacion de datos
      var licencia_id = $('[name="licencia_id"]:last', $trParent).val();
      var macro_zona_id = $('[name="macro_zona_id"]:last', $trParent).val();
      var tipo_operacion_id = $('[name="tipo_operacion_id"]:last', $trParent).val();

      var fecha_promulgacion = $('[name="fecha_promulgacion"]:last', $trParent).val();
      var fecha_inicio = $('[name="fecha_inicio"]:last', $trParent).val();
      var fecha_termino = $('[name="fecha_termino"]:last', $trParent).val();
      var unidad_id = $('[name="unidad_id"]:last', $trParent).val();
      var cantidad = $('[name="cantidad"]:last', $trParent).val();

      console.log(licencia_id, macro_zona_id, tipo_operacion_id);

      if (licencia_id && macro_zona_id && tipo_operacion_id) {
        $trParent.removeClass('danger').addClass('success');
        $.ajax({
          url: '/operaciones/add',
          type: 'POST',
          dataType: 'json',
          data: {
            licencia_id: licencia_id,
            fecha_promulgacion: fecha_promulgacion,
            fecha_inicio: fecha_inicio,
            fecha_termino: fecha_termino,
            macro_zona_id: macro_zona_id,
            cantidad: cantidad,
            unidad_id: unidad_id,
            tipo_operacion_id: tipo_operacion_id
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
          }
        })
        .done(function (data) {
          $('#operaciones-table').dataTable().DataTable().row.add(data.operacion);
          $('#operaciones-table').dataTable().DataTable().row( $trParent ).remove().draw( false );
        })
      } else {
        errorNotify('Aun existen datos incompletos para la operación.');
        $(this).removeClass('working');
        $(this).addClass('btn btn-xs').find('i').removeClass('fa-spinner fa-spin fa-lg').addClass('fa-plus');
      }
    }
  });

  /*****   EDIT EN BLUR *****/

  $('#operaciones-table tbody').on('change', 'tr.nuevo td.especie select', function() {
      var especie_id = $(this).val();
      var $trParent = $(this).parents('tr[role="row"]');

      var $tdLicencia = $('td.licencia', $trParent);

      var tmp_html = '<select name="licencia_id" lang="es" data-placeholder="Licencia" class="form-control input-xs" style="width: 100%;">\
      <option value></option>\
      </select>';
      $tdLicencia.html(tmp_html);

      $('select', $tdLicencia).select2({
        ajax: {
            url: '/api/licencias.json',
            type: 'GET',
            dataType: 'json',
            delay: 350,
            data: {
                especie: especie_id
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
  });

  $('#operaciones-table tbody').on('change', 'tr td select', function(e) {
    var $trParent = $(this).parents('tr[role="row"]');

    if ($trParent.hasClass('danger') || $trParent.hasClass('success') || $trParent.hasClass('nuevo')) {
        e.stopPropagation();
        return;
    }

    var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();

    $(this).prop('disabled', true);

    var operacion_id = dataRow.id;

    var data = {}
    data[$(this).attr("name")] = $(this).val();
    $.ajax({
      url: '/operaciones/edit/' + operacion_id,
      type: 'POST',
      dataType: 'json',
      data: data
    })
    .done(function (data) {
      $('#operaciones-table').DataTable().row( $trParent ).remove();
      $('#operaciones-table').DataTable().row.add(data.operacion).draw( false );
    });
  });

  /** Edit input[text] (fechas y canitdad) onBlur **/
  $('#operaciones-table tbody').on('blur', 'tr td input[type="text"]', function() {
    var $trParent = $(this).parents('tr[role="row"]');
    if ($trParent.hasClass('danger') || $trParent.hasClass('success') || $trParent.hasClass('nuevo')) {
      return;
    }

    var dataRow = $('#operaciones-table').DataTable().row( $trParent ).data();
    $(this).prop('disabled', true);

    var operacion_id = dataRow.id;

    // Validacion
    if ($(this).attr("name") == "cantidad") {
        if (!pattCantidad.test($(this).val())) {
            $(this).prop('disabled', false);
            return;
        }
    }

    var data = {}
    data[$(this).attr("name")] = $(this).val();
    $.ajax({
      url: '/operaciones/edit/' + operacion_id,
      type: 'POST',
      dataType: 'json',
      data: data
    })
    .done(function (data) {
      $('#operaciones-table').DataTable().row( $trParent ).remove();
      $('#operaciones-table').DataTable().row.add(data.operacion).draw( false );
    });
  });
  /** FIN Edit input[text] (fechas y canitdad) onBlur **/

  /*** Nuevo Traspaso ***/
  $('#new-traspaso').on('click', function() {
    BootstrapDialog.show({
      title: "Nuevo Traspaso",
      closable: false,
      size: BootstrapDialog.SIZE_WIDE,
      buttons: [
        {
          label: 'Guardar',
          cssClass: 'btn-success',
          action: function (dialog) {
            var $form = $('form', dialog.getModal());
            if(!$form.valid()) {
              console.debug('FORMULARIO CON DATOS INVALIDOS');
              // var errorList = $form.validate().errorList;
              // console.debug(errorList);
              errorNotify("Existen errores en el formulario.");
              return false;
            }
            if(finishedRequest) {
              finishedRequest = false;
              $form.ajaxSubmit({
                url: '/operaciones/nuevo_traspaso',
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if ( data.status == 'success' ) {
                    successNotify("Traspaso registrado con exito!");
                    dialog.close();
                    $('#operaciones-table').dataTable().DataTable().ajax.reload();
                  } else {
                    parseErrors(data.errors, $('form', dialog.getModal()));
                    errorNotify("Existen errores en el formulario.");
                    finishedRequest = true;
                  }
                  finishedRequest = true;
                }
              });
            }
            return false;
          }
        },
        {
          label: 'Cerrar',
          action: function(dialog) {
            BootstrapDialog.confirm({
              message: "¿Está seguro de descartar los cambios?",
              type: BootstrapDialog.TYPE_WARNING,
              size: BootstrapDialog.SIZE_SMALL,
              callback: function (result) {
                if ( result )
                dialog.close();
              }
            });
          }
        },
      ],
      message: function(dialog) {
        var $message = $('<div></div>');
        $message.load( '/operaciones/nuevo_traspaso' , function () {
          $('.datetime-picker', $(this)).datetimepicker(datetimeOptions());
          $('.bootstrap-datetimepicker-widget .btn').removeClass('shiny');
        });

        return $message;
      }
    });
  });
  /** FIN Nuevo Traspaso **/

  /** Adjuntar archivo **/
  $('#operaciones-table').on('click', 'tbody button.upload-file', function () {
    var $trParent = $(this).parents('tr');
    var operacionId = $('#operaciones-table').DataTable().row($trParent).data()['id'];

    BootstrapDialog.show({
      title: "Adjuntar Archivo a Operación",
      closable: false,
      buttons: [
        {
          label: 'Guardar',
          cssClass: 'btn-success',
          action: function (dialog) {
            var $form = $('form', dialog.getModal());
            if(!$form.valid()) {
              console.debug('FORMULARIO CON DATOS INVALIDOS');
              errorNotify("Existen errores en el formulario.");
              return false;
            }
            if(finishedRequest) {
              finishedRequest = false;
              $form.ajaxSubmit({
                url: '/operaciones/upload_file/' + operacionId,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if ( data.status == 'success' ) {
                    successNotify("Archivo adjuntado con exito!");
                    dialog.close();
                    $('#operaciones-table').dataTable().DataTable().ajax.reload();
                  } else {
                    parseErrors(data.errors, $('form', dialog.getModal()));
                    errorNotify("Existen errores en el formulario.");
                    finishedRequest = true;
                  }
                  finishedRequest = true;
                }
              });
            }
            return false;
          }
        },
        {
          label: 'Cerrar',
          action: function(dialog) {
            BootstrapDialog.confirm({
              message: "¿Está seguro de descartar los cambios?",
              type: BootstrapDialog.TYPE_WARNING,
              size: BootstrapDialog.SIZE_SMALL,
              callback: function (result) {
                if ( result )
                dialog.close();
              }
            });
          }
        },
      ],
      message: function(dialog) {
        var $message = $('<div></div>');
        $message.load( '/operaciones/upload_file/' + operacionId , function () {
          $('.datetime-picker', $(this)).datetimepicker(datetimeOptions());
          $('.bootstrap-datetimepicker-widget .btn').removeClass('shiny');
        });

        return $message;
      }
    });
  });
  /** FIN Adjuntar archivo **/

  /** Borrar Fila de la Tabla **/
  deleteRowTable = function () {
      var $selectedRow = $('#operaciones-table').find('tr.selected');
      if ($selectedRow.length) {
          if ($selectedRow.hasClass('danger') || $selectedRow.hasClass('success')) {
              $('#operaciones-table').DataTable().row( $selectedRow ).remove().draw( false );
          } else {
              deleteEntity('/operaciones/delete/', $('#operaciones-table'));
          }
          return;
      }
      warningNotify('Debe seleccionar una fila primero!');
  };
  /** FIN Borrar Fila de la Tabla **/

  /** Exportar tabla a Excel **/
  $('button#export-excel').on('click', function(e) {
      e.preventDefault();

      var year = $('select#year-select').val();
      var url = 'operaciones/generarExcel/' + year + especie_query.replace('&', '?');

      window.location.href = url;

      return false;
  });
});
</script>
<?= $this->end(); ?>
