<?php
$this->layout = 'ajax';
$hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
  <div class="col-md-6">
    <legend>Descargas Abiertas <button class="btn pull-right" id="refresh-table"><i class="fa fa-refresh"></i></button></legend>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered table-striped table-condensed" id="descargas-table">
          <thead>
            <tr>
              <th></th>
              <th>Código</th>
              <th>Fecha Recalada</th>
              <th>Nave</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-1 hidden-sm hidden-xs" style="height:430px; padding-top:200px">
    <button class="btn add-detalle" id="add-detalle"><i class="fa fa-chevron-right"></i></button>
    <button class="btn delete-detalle" id="delete-detalle"><i class="fa fa-chevron-left"></i></button>
  </div>
  <div class="col-md-1 hidden-lg hidden-md centered" style="padding-top: 10px; padding-bottom: 10px">
    <button class="btn add-detalle" id="add-detalle"><i class="fa fa-chevron-down"></i></button>
    <button class="btn delete-detalle" id="delete-detalle"><i class="fa fa-chevron-up"></i></button>
  </div>
  <div class="col-md-5">
    <legend>Detalles Guías</legend>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered table-striped table-hover table-condensed" id="detalles-table">
          <thead>
            <tr>
              <th>Cód. Descarga</th>
              <th>Nave</th>
              <th>Especie</th>
              <th><?= $recurso->unidad_principal->abreviacion ?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <form class="form-inline">
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label col-sm-3 col-sm-offset-3">Total:</label>
              <div class="col-sm-6">
                <input name="guia_total" id="guia-total" type="text" value="0,000" readonly="readonly" class="input-xs" style="text-align: right;"/>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
  var $thisModal = $('#<?=$hash_id?>');
  detallesData = [];
  cantidad_remanente = {};
  unidad_principal_id = '<?= $recurso->unidad_principal->id ?>';

  $('#refresh-table', $thisModal).click(function (e) {
    e.preventDefault();
    $('#descargas-table').dataTable().DataTable().ajax.reload(function () {
      updateTables();
    });
  });

  var descargasTable = $('#descargas-table', $thisModal).DataTable({
    "ajax": '/api/descargas_disponibles/<?=$recurso->id?>?disponible=true',
    "scrollY": "200px",
    "paging": false,
    "responsive": true,
    "sPaginationType": "bootstrap",
    "dom": "ft",
    "language": {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    },
    "columns": [
      {"defaultContent": '<i class="fa fa-plus-square-o row-details"></i>', "orderable": false, "width": '10px'},
      {"data": "codigo_descarga"},
      {"data": {
        "_": function (row) {return row?moment.utc(row.recalada.fecha_recalada).format('DD-MMM-YYYY HH:mm'):null;},
        "sort": "recalada.fecha_recalada"
      }},
      {"data": "recalada.marea.nave.nombre"},
    ],
    "drawCallback": function ( settings ){
      if (settings.aoData.length > 0) {
        updateTotal();
        updateTables();
      }
    },
    "rowCallback": function (row, data, index) {
      $(row).data("id", data.id).addClass('header');
      $(row).data("descarga_detalles", data.descarga_detalles);

      var mostrar = false;

      $.each(data.descarga_detalles, function (i, detalle) {
        $.each(detalle.unidades, function (ii, unidad) {
          if (unidad._joinData.cantidad_disponible > 0) {
            mostrar = true;
            return;
          }
        });

        if (mostrar) return;

        var descDetalleId = detalle.id;
        $('#detalles-table tbody tr').each(function () {
          if(descDetalleId == $(this).data('data').id) {
            mostrar = true;
            return;
          }
        });
      });

      if (!mostrar)
      $(row).hide();
    }
  });

  function format ( d ) {
    var $rows = $('<tbody></tbody>');
    $.each(d.descarga_detalles, function (i, data) {
      var sRow = '<tr>';
      sRow += '<td>'+data.especie.nombre+'</td>';
      sRow += '<td class="text-right">';
      $.each(data.unidades, function (index, unidad) {
        sRow += toggleNumberFormat(unidad._joinData.cantidad, unidad.precision)+' '+unidad.abreviacion+'<br>'
      });
      sRow += '</td>';
      sRow += '<td>'+data.destinatario.nombre_completo+'</td>';

      // Se obtine la cantidad principal
      sRow += '<td class="text-right">';
      var cantidad_principal = 1;
      $.each(data.unidades, function (index, unidad) {
        if (unidad.id == unidad_principal_id) {
          cantidad_principal = unidad._joinData.cantidad;

          $.each(data.unidades, function (index, unidad) {
            var cantidad_disponible = unidad._joinData.cantidad_disponible;
            sRow += '<b data-disponible="'+cantidad_disponible+'"';
            sRow += ' data-unidad-id="'+unidad.id+'"';
            sRow += ' data-conversion="'+(unidad._joinData.cantidad/cantidad_principal).toFixed(8)+'">';
            sRow += toggleNumberFormat(cantidad_disponible, unidad.precision)+' '+unidad.abreviacion+'</b><br>';
            if (unidad.id == unidad_principal_id) {
              sRow += '<input type="hidden" class="principal"';
              sRow += ' data-disponible="'+cantidad_disponible+'"';
              sRow += ' data-abreviacion="'+unidad.abreviacion+'">';
            }
          });

          return;
        }
      });

      sRow += '</td></tr>';
      var $row = $(sRow);
      data.codigo_descarga = d.codigo_descarga;
      $row.data('data', data);
      $rows.append($row);
    });

    var $tempTable = $('<table class="detalles table table-bordered table-striped table-hover no-padding"><thead><tr><th>Especie</th><th>Cantidad</th><th>Destino</th><th>Disponible</th></tr></thead></table>');
    $('thead', $tempTable).after($rows);

    return $tempTable;
  }

  // Se expande las filas de los DescargaEncabezados
  $('#descargas-table>tbody', $thisModal).on('click', '>tr:not(:has(table))', function () {
    var $row = $(this);
    var row = descargasTable.row( $row );

    if ( row.child.isShown() ) {
      $('.row-details', $(this)).addClass("fa-plus-square-o").removeClass("fa-minus-square-o");
      row.child.hide();
    } else {
      row.child( format(row.data()) ).show()
      $('.row-details', $(this)).addClass("fa-minus-square-o").removeClass("fa-plus-square-o");

      // Se realiza el scroll automatico
      var scroller = $(this).parents('.dataTables_scrollBody');
      $(scroller).scrollTo($(this), 500);
    }

    updateTables();
  });

  // Se selecciona los valores de los DescargaDetalles
  $('#descargas-table', $thisModal).on('click', '>tbody > tr .table-hover tbody tr', function (e) {
    e.stopPropagation();
    $('#descargas-table .selected').not($(this)).removeClass('selected');
    $(this).toggleClass('selected');
    $('#descargas-table').data('selected', null);
    if ( $(this).hasClass('selected') ) {
      var rowData = $(this).data('data');
      rowData.cantidad_disponible = $(this).find('input.principal').data('disponible');
      rowData.unidad_abreviacion = $(this).find('input.principal').data('abreviacion');
      rowData.nave = descargasTable.row( $(this).parents('tr:has(table)').prev() ).data().recalada.marea.nave.nombre;
      rowData.fecha_recalada = descargasTable.row( $(this).parents('tr:has(table)').prev() ).data().recalada.fecha_recalada;
      rowData.inicio_desembarque = descargasTable.row( $(this).parents('tr:has(table)').prev() ).data().inicio_desembarque;
      $('#descargas-table').data('selected', rowData);
    }
  });

  // Se seleccionan las filas de los detalles de las GUIAS
  $('#detalles-table', $thisModal).on('click', 'tbody tr', function (e) {
    e.stopPropagation();
    $('#detalles-table .selected').not($(this)).removeClass('selected');
    $(this).toggleClass('selected');
    $('#detalles-table').data('selected', null);
    if ( $(this).hasClass('selected') ) {
      $('#detalles-table').data('selected', $(this));
    }
  });

  // Se agregan los GuiaDetalles
  $('button.add-detalle', $thisModal).click(function (e) {
    e.preventDefault();
    var rowData = $('#descargas-table').data('selected');
    if ( !rowData ) {
      warningNotify('Debe seleccionar una linea de una descarga');
      return false;
    }

    var existRow = false;
    $.each($('#detalles-table tbody tr'), function (i, r) {
      var $r = $(r);
      if ($r.data('data').id == rowData.id) {
        existRow = r;
        return;
      }
    });

    if ( existRow ) {
      // TODO: Se podria agregar lo restante a lo que existe
      warningNotify('Ya ha sido agregado este registro');
      $('#detalles-table .selected').not($(existRow)).removeClass('selected');
      $(existRow).addClass('selected');
      $('#detalles-table').data('selected', $(existRow));
      //$(existRow).trigger('click');
      return false; //termina anticipadamente
    }

    sRow = '<tr>';
    sRow += '<td>'+rowData.codigo_descarga+'</td>';
    sRow += '<td>'+rowData.nave+'</td>';
    sRow += '<td>'+rowData.especie.nombre+'</td>';
    sRow += '<td><input type="text" name="cantidad" value="'+toggleNumberFormat(rowData.cantidad_disponible, <?= $recurso->unidad_principal->precision ?>)+'" class="form-control input-xs"></td>';
    sRow += '</tr>';

    var $row = $(sRow);
    $row.data('data', rowData);
    $('#detalles-table tbody').append($row);

    updateTables();
    updateTotal();
  })

  // Se borran los GuiaDetalles
  $('button.delete-detalle', $thisModal).click(function (e) {
    e.preventDefault();
    var $row = $('#detalles-table').data('selected');

    if ( !$row ) {
      warningNotify('Debe seleccionar una fila primero.');
      return false;
    }

    $row.remove();
    $('#detalles-table').data('selected', null);
    updateTables();
    updateTotal();
  });

  // Cuando se modifica la cantidad de un GuiaDetalle
  $('#detalles-table', $thisModal).on('change keyup blur click', 'input', function (e) {
    if (e.type == 'click') {
      e.stopPropagation();
      return;
    }
    if (e.type == 'focusout') {
      if ($(this).val().length == 0) {
        $(this).val('0');
      }
    }
    updateTables();
    if (e.type == 'focusout') {
      var tempNum = Number(toggleNumberFormat($(this).val())).toFixed(<?= $recurso->unidad_principal->precision ?>);
      if (isNaN(tempNum)) {
        warningNotify('Valor mal ingresado.');
        $(this).val(toggleNumberFormat(Number(0.000), <?= $recurso->unidad_principal->precision ?>));
        updateTables();
      }
      else
      $(this).val(toggleNumberFormat(tempNum));
    }

    updateTotal();
  });

  // Se actualiza el total de las GuiaDetalles
  function updateTotal() {
    var total = 0;
    detallesData = [];
    $('#detalles-table tbody input', $thisModal).each(function () {
      total += Number(toggleNumberFormat($(this).val()));

      //se generan los datos que seran pasados al modal de guia encabezados
      var $tr = $(this).parents('tr');
      var dataRow = $tr.data('data');

      var cantidad_principal_ingresada = $(this).val();
      // Se incluye la cantidad usada por cada unidad
      $.each(dataRow.unidades, function(i, unidad) {
        dataRow.cantidad_usada = cantidad_principal_ingresada;
        if (unidad.id == unidad_principal_id) {
          var cantidad_principal = unidad._joinData.cantidad;
          $.each(dataRow.unidades, function(i, unidad2) {
            var conversion = Number(unidad2._joinData.cantidad/cantidad_principal).toFixed(15);
            unidad2.conversion = conversion;
            if (unidad2.id == unidad_principal_id) {
              unidad2.cantidad_usada = toggleNumberFormat(cantidad_principal_ingresada, unidad2.precision);
            } else {
              var remanente = 0;
              if (cantidad_remanente[dataRow.id][unidad2.id] < 0.005) {
                remanente = cantidad_remanente[dataRow.id][unidad2.id];
              }
              unidad2.cantidad_usada = Number((toggleNumberFormat(cantidad_principal_ingresada, unidad2.precision) * conversion) + remanente).toFixedDown( unidad2.precision );
            }
          });
          return;
        }
      });

      detallesData.push(dataRow);
    });

    $('#guia-total', $thisModal).val(toggleNumberFormat(total, <?= $recurso->unidad_principal->precision ?>)+' <?= $recurso->unidad_principal->abreviacion ?>');
  }

  // Se actualizan los datos de la tabla de descargas
  function updateTables() {
    $('#descargas-table > tbody > tr').each(function () {
      var danger = false;

      // Actualiza las tablas expandidas
      $('table.detalles > tbody > tr', $(this)).each(function (i, r) {
        var $descargaRow = $(r);
        var rowid = $descargaRow.data('data').id;

        // Se busca la unidad principal
        $.each($descargaRow.data('data').unidades, function(index, unidad) {
          if (unidad.id == unidad_principal_id) {
            var cantidad_inicial_usada = cantidad_inicial[rowid] ? cantidad_inicial[rowid] : 0.0;
            var cell_text = '';
            $.each($descargaRow.data('data').unidades, function(index, unidad) {
              var conversion = $descargaRow.find('[data-unidad-id="'+unidad.id+'"]').data('conversion');
              var cantidad_disponible = Number(unidad._joinData.cantidad_disponible) + Number(cantidad_inicial_usada*conversion);
              var unidades_abreviacion = unidad.abreviacion;

              $.each($('#detalles-table tbody tr'), function (i2, r2) {
                var r2data = $(r2).data('data');
                if ( r2data.id == rowid ) {
                  if (unidad.id == unidad_principal_id) {
                    cantidad_disponible -= toggleNumberFormat($('input', r2).val(), unidad.precision);
                  } else {
                    cantidad_disponible -= toggleNumberFormat($('input', r2).val(), unidad.precision) * conversion;
                  }
                }
              });

              var aprox = '';
              if (!cantidad_remanente[rowid]) {
                cantidad_remanente[rowid] = {};
              }
              cantidad_remanente[rowid][unidad.id] = cantidad_disponible;
              if (cantidad_disponible > 0 && cantidad_disponible < 0.005) {
                aprox = '~';
                cantidad_disponible = 0.0;
              }

              cantidad_disponible = cantidad_disponible.toFixedDown( unidad.precision );

              cell_text += '<b data-unidad-id="'+unidad.id+'"';
              cell_text += ' data-disponible="'+cantidad_disponible+'"';
              cell_text += ' data-conversion="'+conversion+'">' + aprox;
              cell_text += toggleNumberFormat( cantidad_disponible, unidad.precision )+' '+unidades_abreviacion+'</b><br/>';

              if (unidad.id == unidad_principal_id) {
                cell_text += '<input type="hidden" class="principal"';
                cell_text += ' data-disponible="'+cantidad_disponible+'"';
                cell_text += ' data-abreviacion="'+unidad.abreviacion+'">';
              }

              // Si alguna unidad es menor a cero
              if (cantidad_disponible.toFixed( unidad.precision ) < 0) {
                danger = true;
              }
            });
            // Se actualuza el valor de la celda
            $('td:eq(3)', $descargaRow).html( cell_text );
            return;
          }
        });
      });

      // Si la siguiente fila no son detalles
      if ( !$(this).next().find('table.detalles').length && !$(this).find('table.detalles').length ) {
        // Se chequean tablas no expandidas
        var rowDataDescargaDetalles = $(this).data('descarga_detalles');
        $.each(rowDataDescargaDetalles, function(i, detalle) {
          // Se encuentra la unidad principal
          $.each(detalle.unidades, function(index, unidad) {
            if (unidad.id == unidad_principal_id) {
              var cantidad_inicial_usada = cantidad_inicial[detalle.id] ? cantidad_inicial[detalle.id] : 0.0;
              var cantidad_principal = unidad._joinData.cantidad;
              $.each(detalle.unidades, function(index, unidad) {
                var conversion = Number(unidad._joinData.cantidad/cantidad_principal).toFixed(8);
                var cantidad_disponible = Number(unidad._joinData.cantidad_disponible) + Number(cantidad_inicial_usada*conversion);

                $.each($('#detalles-table tbody tr'), function (i2, r2) {
                  var r2data = $(r2).data('data');
                  if ( r2data.id == detalle.id ) {
                    if (unidad.id == unidad_principal_id) {
                      cantidad_disponible -= toggleNumberFormat($('input', r2).val(), unidad.precision);
                    } else {
                      cantidad_disponible -= toggleNumberFormat($('input', r2).val(), unidad.precision) * conversion;
                    }
                  }
                });
                if (!cantidad_remanente[detalle.id]) {
                  cantidad_remanente[detalle.id] = {};
                }
                cantidad_remanente[detalle.id][unidad.id] = cantidad_disponible;
                cantidad_disponible = cantidad_disponible.toFixedDown( unidad.precision );
                if (cantidad_disponible < 0) {
                  danger = true;
                  return;
                }
              });

              return;
            }
          });

          if (danger) return;
        });
      }

      if ( $(this).find('table.detalles').length ) {
        main_tr = $(this).prev();
      } else {
        main_tr = $(this);
      }

      if (danger) {
        main_tr.addClass('danger');
      } else {
        main_tr.removeClass('danger');
      }
    });
  }
});
</script>
