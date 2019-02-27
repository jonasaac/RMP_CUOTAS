/**
 * Modulo con funciones globales que se aplican a todo el sistema
 *
 * Author: Daniel Campos - daniel@irbits.cl
 * Last Update Date: 17/05/2016
 * Version: 1.1
 */

(function( $ ){
    $.fn.helptooltip = function (options) {
        var label = this.parents('.form-group').find('label.control-label');
        var helpIcon = $('<strong> ?</strong>');
        label.append(helpIcon);
        helpIcon.tooltip(options);
        return this;
    };
})( jQuery );

$.propHooks.checked = {
    set: function(el, value) {
        if (el.checked !== value) {
            el.checked = value;
            $(el).trigger('change');
        }
    }
};

// Nueva función para truncar numeros en javascript
Number.prototype.toFixedDown = function(digits) {
    var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
        m = this.toFixed( digits*2 ).toString().match(re);
    return m ? parseFloat(m[1]) : this.valueOf();
};

$(document).ready(function() {
    // clickinput handler
    $(document).on('focus', '.form-control', function() {
        $(this).addClass('input-active');
    });

    $(document).on('shown.bs.modal', function () {
        $('[data-toggle=tooltip]').tooltip();
    });
});

// cambia formato de numeros
function toggleNumberFormat(input, precision) {
  precision = typeof precision === 'number' ? precision : 3;

  if (typeof input === 'number') {
    input = input.toFixed( precision );
    if (input == -0) input = Number(0).toFixed( precision );
    input = input.toString();
  }

  return input.replace(/[,.]/g, function (x) { return x == "," ? "." : ","; });
}

//Funcion usada para asignar un largo fijo a un número entero
function formatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}

//funcion para normalizar los caracteres especiales
var normalize = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};

  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );

  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' );
  };

})();

// agrega a un array solo si no existe
Array.prototype.pushIfNotExist = function(val) {
    if (typeof(val) == 'undefined' || val === '') { return; }
    val = $.trim(val);
    if ($.inArray(val, this) == -1) {
        this.push(val);
    }
};

//variables globales para toda la aplicación
var datetimeOptions = function (defaultDate, maxDate) {
    var newDefaultDate = defaultDate ? defaultDate : null;
    var _maxDate = maxDate ? maxDate : false;
    return {
        locale: moment.locale('es_CL'),
        useCurrent: true,
        format: 'DD-MMM-YYYY HH:mm',
        maxDate: _maxDate,
        sideBySide: true,
        allowInputToggle: true,
        debug: false
    };
};

dateOptions = function (defaultDate, maxDate, widgetParent) {
  var newDefaultDate = defaultDate ? defaultDate : false;
  var _maxDate = maxDate ? maxDate : false;
  var _widgetParent = widgetParent ? widgetParent : null;
  return {
      locale: moment.locale('es_CL'),
      // defaultDate: newDefaultDate,  TODO: revisar impacto
      useCurrent: true,
      format: 'DD-MMM-YYYY',
      maxDate: _maxDate,
      sideBySide: false,
      allowInputToggle: true,
      debug: false,
      widgetParent: widgetParent,
  };
};

timeOptions = function (defaultDate) {
  var newDefaultDate = defaultDate ? defaultDate : false;
  return {
      locale: moment.locale('es_CL'),
      useCurrent: true,
      defaultDate: newDefaultDate,
      format: 'HH:mm',
      sideBySide: true,
      allowInputToggle: true,
      debug: false
  };
};

//pequeño plugin para inabilitar la seleccion de objetos
$.fn.unselectable = function () {
    return this.each(function() {
        $(this)
            .attr('unselectable','on')
            .css({'-moz-user-select':'-moz-none',
                  '-moz-user-select':'none',
                  '-o-user-select':'none',
                  '-khtml-user-select':'none',
                  '-webkit-user-select':'none',
                  '-ms-user-select':'none',
                  'user-select':'none'
                 })
            .bind('selectstart', function(){ return false; });
    });
};

// dataTable options
var dataTableOptions = function (aoColumns, rowCallback, ajax) {

    return {
        "responsive": true,
        "scrollY": "200px",
        "scrollCollapse": false,
        "ajax": ajax,
        "paging": false,
        "aLengthMenu": [
            [5, 10, 20, 100, -1],
            [5, 10, 20, 100, "Todas"]
        ],
        "iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "sDom": "Tfl<'action-buttons'>t<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "language": {
            "search": "",
            "emptyTable": "",
            "zeroRecords": "No hay datos que coincidan",
            "info": "Mostrando de _START_ a _END_ de un total de _TOTAL_",
            "infoEmpty": "No hay datos que mostrar",
            "infoFiltered": "(filtrado desde _MAX_ datos)",
            "sLengthMenu": "_MENU_",
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
            }
        },
        "columns": aoColumns,
        "fnRowCallback": function (row, data, index) {
            $(row).data("id", data.id);

            if (typeof rowCallback === 'function')
                rowCallback(row, data, index);
        },
    };
};

//funcion que llena un objeto select ya creado
var populateSelect = function (sSelect, sUrl) {
    $.ajax({"url": sUrl,
            "dataType": "json",
            "success": function (data) {
                var oSelect = $(sSelect).empty();
                oSelect.append('<option value=""></option>');
                $.each(data, function (i, e) {
                    oSelect.append('<option value="'+e.id+'">'+e.name+'</option>');
                });
            }
           });

};

//funcion que crea un nuevo select con la información del json
var createSelect = function (name, jsonData) {
    var sSelect = '<select name="'+name+'" class="form-control input-xs">';
    sSelect += '<option value=""></option>';
    $.each(jsonData, function (i, e) {
        sSelect += '<option value="'+e.id+'">'+e.name+'</option>';
    });
    sSelect += '</select>';

    return sSelect;
};

//convierte un formulario a un array
var serializeForm = function (oForm) {
    /*var serializedForm = oForm.serializeArray();
    var objectResult = {}

    $.each(serializedForm, function (i, e) {
        if (e.name != '_method')
            objectResult[e.name] = e.value;
    });*/
    console.log(oForm.serialize());
    return oForm.serialize();
};

// rellena el formulario con los errores
var parseErrors = function (data, form) {
    console.log(data);
    $('.has-error').removeClass('has-error has-feedback');
    $('p.help-block', form).html('');
    if (data) {
      $.each(data, function(i, el) {
          $('.form-group:has([name="' + i + '"])', form).addClass("has-error has-feedback");
          var errorText = '<ul>';
          $.each(el, function (i,e) {
              if (typeof e === 'object') {
                  errorText += '<li>Existen errores en estos campos</li>';
              } else
                  errorText += '<li>'+e+'</li>';
          });
          errorText += '</ul>';
          var $pHelp = $(' [name="' + i + '"]~p', form);
          if ($pHelp.length === 0) {
              console.log('buscando: '+i+'...');
              $pHelp = $(' [id="' + i + '-container"]~p', form);
              if ($pHelp.length > 0) console.log('encontrado: '+i);
          }
          $pHelp.html(errorText);
      });
    }
};

// crea un modal
var createModal = function (sTitle, fnMessage, fnSuccessCallback, sSize) {
    var newModal = bootbox.dialog({
        "message": fnMessage,
        "title": sTitle,
        "className": "modal-darkorange",
        "closeButton": false,
        "size": sSize,
        buttons: {
            success: {
                label: "Enviar",
                className: "btn-default",
                callback: fnSuccessCallback,
            },
            "Cancelar": {
                className: "btn-default",
                callback: function () {
                    var modalForm = $(this);
                    bootbox.confirm({
                        "message" : "¿Seguro de cerrar el formulario?",
                        "backdrop" : false,
                        "size": 'small',
                        "callback" : function (result) {
                            if (result)
                                modalForm.modal('hide');
                            else
                                modalForm.modal('toggle');
                        }
                    });
                    return false;
                }
            }
        }
    });

    return newModal;
};

/** Funciones de seleccion para select2
 * - los simbolos ** (doble asteristico) son utilizados para delimitar un
 *   titulo para cada opcion dentro del select2
 */
function formatSelectionSelect2Items(item) {
    var bold_patt = /\*\*(.*)\*\*/i;
    text = item.text;
    matches = text.match(bold_patt);
    if (!matches || !matches[1])
      return text;
    else
      return matches[1];
}

function formatSelect2Items(item) {
    var bold_patt = /\*\*(.*)\*\*/i;
    text = item.text;
    text = text.replace(bold_patt, function (match) {
        return '<b>' + match.substring(2, match.length - 2) + '</b>';
    });
    var lines = text.split("\\");
    var result = $('<span>' + lines.join("<br/>") + '</span>');
    return result;
}
