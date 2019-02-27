// Se cargan el archivo con los mensajes
msgs = null;
$.getJSON('/languages/es.json', function (data) {
  console.debug(data);
  msgs = data;
});

var finishedRequest = true;
var idEntity = null;

function getEntityId ($table) {
  var id = $table.data('selected');
  if (id)
  return id;
  else
  return null;
}

function getRowById ($table, id) {
  return $('tr', $table).filter(function () {
    return $(this).data('id') == id;
  });
}

function reloadTable ($table, page, reloadCallback) {
  page = typeof page !== 'undefined' ? page : null;

  console.debug(page);
  if (false && typeof page === 'function') {
    page = page();
    $table.dataTable().DataTable().ajax.url( page ).load( function () {
      $( $.fn.dataTable.tables(true) ).each (function () {
        $(this).dataTable().fnAdjustColumnSizing();
      });

      if ($table.data("selected")) {
        $('tr', $table).filter(function () {
          return $(this).data('id') === $table.data("selected");
        }).addClass('selected');
      }

      if(typeof reloadCallback === 'function') {
        reloadCallback();
      }

    });
  } else {
    console.debug('RECARGA DESDE MISMO ORIGEN');
    $table.DataTable().ajax.reload(function () {
      $( $.fn.dataTable.tables(true) ).each (function () {
        $(this).dataTable().fnAdjustColumnSizing();
      });
      if ($table.data("selected")) {
        $('tr', $table).filter(function () {
          return $(this).data('id') === $table.data("selected");
        }).addClass('selected');
      }
      if(typeof reloadCallback === 'function') {
        reloadCallback();
      }
    }, false);
  }
}

function newEntity (title, page, arg_options, arg_msgs) {
  var options = arg_options ? arg_options : {};
  var msgs = arg_msgs ? arg_msgs : null;
  var config = {
    sClose: msgs?msgs.closeNew:'¿Está seguro de descartar este nuevo registro?',
    sSuccess: msgs?msgs.newSuccess:'Registrado con exito!',
    sError: msgs?msgs.newError:'No se pudo ingresar el registro. Existen errores en el formulario!',
    fnCreateCallback: options && options.fnCreateCallback ? options.fnCreateCallback : function() {},
    fnPreSubmit: options && options.fnPreSubmit ? options.fnPreSubmit : function() {return true;},
    oTable: options ? options.oTable : null,
    sTableReloadPage: options ? options.sTableReloadPage : null,
    fnPreCreate: options ? options.fnPreCreate : null,
    dialogSize: options ? options.dialogSize : null,
    closeCallback: options ? options.closeCallback : null,
    acceptCallback: options ? options.acceptCallback : null,
    successCallback: options.successCallback ? options.successCallback : null
  };

  if ( typeof config.fnPreCreate === 'function' ) {
    if (!config.fnPreCreate())
    return false;
  }

  BootstrapDialog.show({
    title: title,
    closable: false,
    size: config.dialogSize ? config.dialogSize : null,
    buttons: [
      {
        label: 'Guardar',
        cssClass: 'btn-success',
        action: function (dialog) {
          if (typeof config.acceptCallback === 'function') {
            config.acceptCallback( dialog );
          } else {
            if (!config.fnPreSubmit()) {
              return false;
            }
            var $form = $('form', dialog.getModal());
            if(!$form.valid()) {
              console.debug('FORMULARIO CON DATOS INVALIDOS');
              var errorList = $form.validate().errorList;
              console.debug(errorList);
              errorNotify(config.sError);
              return false;
            }
            if(finishedRequest) {
              finishedRequest = false;
              $form.ajaxSubmit({
                url: page,
                type: 'POST',
                dataType: 'json',
                /*beforeSerialize: function($form, options) {
                },
                beforeSubmit: function(arr, $form, options) {
                },*/
                success: function (data) {
                  if ( data.status == 'success' ) {
                    successNotify(config.sSuccess);
                    if(typeof config.successCallback === 'function') {
                      config.successCallback( data );
                    }
                    dialog.close();
                    if(config.oTable)
                    reloadTable(config.oTable, config.sTableReloadPage, config.closeCallback);
                  } else {
                    parseErrors(data.errors, $('form', dialog.getModal()));
                    errorNotify(config.sError);
                    finishedRequest = true;
                  }
                  finishedRequest = true;
                }
              });
            }
            return false;
          }
        }
      },
      {
        label: 'Cerrar',
        action: function(dialog) {
          BootstrapDialog.confirm({
            message: config.sClose,
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
      $message.load( page , function () {
        $('.datetime-picker', $(this)).datetimepicker(datetimeOptions());
        $('.bootstrap-datetimepicker-widget .btn').removeClass('shiny');
        config.fnCreateCallback($message);
      });

      return $message;
    }
  });
}

function editEntity (title, page, arg_options, arg_msgs) {
  var options = arg_options ? arg_options : {};
  var msgs = arg_msgs ? arg_msgs : null;
  var config = {
    sClose: msgs?msgs.closeEdit:'¿Está seguro de descartar los cambios?',
    sSuccess: msgs?msgs.editSuccess:'Mantenedor registrado con exito!',
    sError: msgs?msgs.editError:'No se pudo registrar el mantenedor. Existen errores en el formulario!',
    fnCreateCallback:  options.fnCreateCallback ? options.fnCreateCallback : function() {},
    fnPreSubmit: options.fnPreSubmit ? options.fnPreSubmit : function () {return true;},
    oTable: options.oTable,
    sTableReloadPage: options.sTableReloadPage,
    fnSuccessCallback: options.fnSuccessCallback ? options.fnSuccessCallback : null,
    fnErrorCallback: options.fnErrorCallback ? options.fnErrorCallback : null,
    elementId: options.elementId ? options.elementId : null
  };

  var id = config.elementId ? config.elementId() : getEntityId( config.oTable );
  if (!id) {
    warningNotify("Debe seleccionar una fila primero!");
    return false;
  }

  BootstrapDialog.show({
    title: title,
    closable: false,
    size: options.dialogSize ? options.dialogSize : null,
    buttons: [
      {
        label: 'Editar',
        cssClass: 'btn-success',
        action: function (dialog) {
          if (!config.fnPreSubmit()) {
            return false;
          }
          var $form = $('form', dialog.getModal());
          if(!$form.valid()) {
            console.debug('FORMULARIO CON DATOS INVALIDOS');
            var errorList = $form.validate().errorList;
            console.debug(errorList);
            errorNotify(config.sError);
            return false;
          }
          // formData = serializeForm($form);
          if(finishedRequest) {
            finishedRequest = false;
            $form.ajaxSubmit({
              url: page + id,
              type: 'POST',
              dataType: 'json',
              /*beforeSerialize: function($form, options) {
              },
              beforeSubmit: function(arr, $form, options) {
              },*/
              success: function (data) {
                if (data.status == 'success') {
                  successNotify(config.sSuccess);
                  dialog.close();
                  if (config.sTableReloadPage)
                  reloadTable(config.oTable, config.sTableReloadPage);
                  if (typeof config.fnSuccessCallback == "function") {
                    config.fnSuccessCallback( data );
                  }
                } else {
                  parseErrors(data.errors, $('form', dialog.getModal()));
                  errorNotify(config.sError);
                  finishedRequest = true;
                  if (typeof config.fnErrorCallback == "function") {
                    config.fnErrorCallback( data );
                  }
                }
                finishedRequest = true;
              }
            });
          }
          return false;
        }
      },
      {
        label: 'Cancelar',
        action: function (dialog) {
          BootstrapDialog.confirm({
            message: config.sClose,
            type: BootstrapDialog.TYPE_WARNING,
            size: BootstrapDialog.SIZE_SMALL,
            callback: function (result) {
              if (result)
              dialog.close();
            }
          });
        }
      }
    ],
    message: function (dialog) {
      var $message = $('<div></div>');
      if (typeof page === 'function') {
        page = page();
      }

      $message.load(page + id, function () {
        $('.datetime-picker', $(this)).datetimepicker(datetimeOptions());
        $('.bootstrap-datetimepicker-widget .btn').removeClass('shiny');
        config.fnCreateCallback();
      });

      return $message;
    }
  });
}

function deleteEntity (page, $table, arg_options) {
  var options = arg_options ? arg_options : {};

  var config = {
    sWarning: '¿Seguro de borrar?',
    sSuccess: 'Se ha borrado con exito el registro!',
    sError: 'No se ha podido eliminar el registro!',
    elementId: options.elementId ? options.elementId : null,
    callback: options.callback ? options.callback : null
  };

  var id = config.elementId ? config.elementId() : getEntityId( $table );
  var $row = getRowById($table, id);
  if (!id) {
    warningNotify("Debe seleccionar una fila primero!");
    return false;
  }

  BootstrapDialog.confirm({
    message: config.sWarning,
    type: BootstrapDialog.TYPE_DANGER,
    size: BootstrapDialog.SIZE_SMALL,
    callback: function (result) {
      if (result) {
        $.post( page + id,
          {'id': id},
          function (data) {
            if (data.status == 'success') {
              successNotify(config.sSuccess);
              $table.dataTable().DataTable().row($row).remove().draw( false );
            } else {
              errorNotify(config.sError);
            }
          }, 'json'
        );
      }
    }
  });
}

function lockEntity (page, $table, callback) {
  var config = {
    sWarning: '¿Seguro de cerrar?',
    sSuccess: 'Se ha cerrado con exito el registro!',
    sError: 'No se ha podido cerrar el registro!'
  };

  var id = getEntityId( $table );
  if (!id) {
    warningNotify("Debe seleccionar una fila primero!");
    return false;
  }

  BootstrapDialog.confirm({
    message: config.sWarning,
    type: BootstrapDialog.TYPE_WARNING,
    size: BootstrapDialog.SIZE_SMALL,
    callback: function (result) {
      if (result) {
        $.post( page + id,
          {'id': id},
          function (data) {
            if (data.status == 'success') {
              successNotify(config.sSuccess);
              $table.dataTable().DataTable().ajax.reload();
            } else {
              errorNotify(config.sError);
            }
          },
          'json'
        );
      }
    }
  });
}

function unlockEntity (page, $table, callback) {
  var config = {
    sWarning: '¿Seguro de abrir?',
    sSuccess: 'Se ha abierto con exito el registro!',
    sError: 'No se ha podido abrir el registro!'
  };

  var id = getEntityId( $table );
  if (!id) {
    warningNotify("Debe seleccionar una fila primero!");
    return false;
  }

  BootstrapDialog.confirm({
    message: config.sWarning,
    type: BootstrapDialog.TYPE_WARNING,
    size: BootstrapDialog.SIZE_SMALL,
    callback: function (result) {
      if (result) {
        $.post( page + id,
          {'id': id},
          function (data) {
            if (data.status == 'success') {
              successNotify(config.sSuccess);
              $table.dataTable().DataTable().ajax.reload();
            } else {
              errorNotify(config.sError);
            }
          },
          'json'
        );
      }
    }
  });
}

function dataTableEntityInit ($table, options) {
  $table.data('selected', null);
  idEntity = null;
  $table.unselectable();

  $table.on('processing.dt', function (e, settings, processing) {
    if (processing) {
      if ($('.loading-container.loading-inactive').length === 1)
        $('.loading-container.loading-inactive').removeClass('loading-inactive');
    } else {
      $('.loading-container').addClass('loading-inactive');
    }
  });

  var ajax_parameter = options.loadUrl;
  if (options.ajax) {
      ajax_parameter = function (data, callback, settings) {
          if (settings.jqXHR) {
              settings.jqXHR.abort();
          }
          var options_ajax = $.extend({}, options.ajax);
          if (typeof options_ajax.url === 'function') {
            options_ajax.url = options_ajax.url();
          }
          if (typeof options_ajax.data === 'function') {
            options_ajax.data = options_ajax.data(data);
          } else {
            options_ajax.data = data;
          }
          options_ajax.dataType = 'json';

          console.debug("Opciones AJAX:", options_ajax);

          return $.ajax( options_ajax )
          .done(function (retrived_data) {
              if (options_ajax.dataSrc) {
                  retrived_data.data = retrived_data[options_ajax.dataSrc];
                  delete retrived_data[options_ajax.dataSrc];
              }
              callback(retrived_data);
          });
      };
  }

  var entityTable = $table.dataTable({
    "searchDelay": 350,
    "serverSide": options.serverSide?options.serverSide:false,
    "responsive": true,
    "scrollY": options.scrollY!=undefined?options.scrollY:"200px",
    //"scrollCollapse": false,
    "ajax": ajax_parameter,
    //"paging": false,
    "aLengthMenu": [
      [10, 20, 100, -1],
      [10, 20, 100, "Todas"]
    ],
    "iDisplayLength": 10,
    //"sPaginationType": "bootstrap",
    "sDom": "T<'action-buttons'>flt<'row DTTTFooter'<'col-md-6'i><'col-md-6'p>>",
    "oLanguage": {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Registros _START_ a _END_ de _TOTAL_ totales",
      "sInfoEmpty":      "Sin registros para mostrar",
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
    "processing": true,
    "bProcessing": true,
    "columns": options.dataColumns,
    "orderFixed": options.orderFixed?options.orderFixed:false,
    "fnRowCallback": function (row, data, index) {
      $(row).data('id', data.id);
      $(row).data('data', data);  // TODO: compatibililidad con version anterior

      if (typeof options.rowCallback === 'function') {
        options.rowCallback(row, data, index);
      }
    }
  });

  $('.action-buttons', entityTable.parents('.dataTables_wrapper')).html(options.actionButtons);

  if (options.tableType == 'EXPANDABLE') {
    var fnFormatDetails = function ($table, nTr) {
      var aData = $table.fnGetData(nTr);
      return options.expandedContent(aData);
    };

    $('tbody', $table).on('click', 'td .row-details', function (e) {
      e.stopPropagation();

      var nTr = $(this).parents('tr')[0];
      if ($table.fnIsOpen(nTr)) {
        /* This row is already open - close it */
        $(this).addClass("fa-plus-square-o").removeClass("fa-minus-square-o");
        $table.fnClose(nTr);
      } else {
        /* Open this row */
        $(this).addClass("fa-minus-square-o").removeClass("fa-plus-square-o");
        $table.fnOpen(nTr, fnFormatDetails($table, nTr), 'details');
        if (!options.allowDetailsClick) {
          $('tr.details', $table).on('click', function () {return false;});
        }
      }
    });
  }

  var selectable = typeof(options.selectable) != 'undefined' ?options.selectable:true;

  if (selectable) {
    var selector = options.tableSelector?options.tableSelector:'tr';
    $('tbody', $table).on('click', selector, function () {
      if($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        $table.data('selected', null);
        if (typeof options.unselectCallback === 'function')
        options.unselectCallback();
      } else {
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        $table.data('selected', $(this).data('id'));
        if (typeof options.selectCallback === 'function')
        options.selectCallback($(this).data('id'), $(this));
      }
    });
  }
}
