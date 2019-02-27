/**
 * Validaciones personalizadas para la extension jQuery validate
 **/

$.validator.addMethod("rut", function(value, element) {
    return this.optional( element ) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");

$.validator.addMethod("exactlength", function(value, element, param) {
 return this.optional( element ) || value.length == param;
}, "Ingresa {0} caracteres.");

$.validator.addMethod("numberrange", function(value, element, params) {
  tmp_value = toggleNumberFormat(value)
  return this.optional( element ) || (/^-?(?:\d+|\d{1,3}(?:\.\d{3})+)(?:,\d+)?$/.test( value ) && (tmp_value >= params[0] && tmp_value <= params[1]));
}, "Debe ingresar un valor en un rango valido {0}, {1}")

$.validator.addMethod("latlong", function(value, element, params) {
  return this.optional( element ) || /^\d+[\xB0\xBA]\d+[\'\u2018\u2019\xB4\u2032]$/.test( value );
}, "Ingresar un valor correcto. Ej: 20º70\'");

$.validator.addMethod("numberEqual", function(value, element, param) {
  return this.optional( element ) || value == param;
}, "Ingresar el valor de este campo debe ser igual a {0}");

// TODO: numberMin puede mejorar para casos especiales (Mejorar toggleNumberFormat)
$.validator.addMethod("numberMin", function(value, element, param) {
  return this.optional( element ) || toggleNumberFormat(value) >= param;
}, "Ingresar el valor de este campo debe ser mayor a {0}");

$.validator.addMethod("fileExtension", function(value, element, param) {
  var correct_file_extension = false;
  var file_extension = value.split(".");
  file_extension = file_extension[file_extension.length - 1];
  if (file_extension.length) {
    $.each(param, function(i, ext) {
      if (file_extension == ext) {
        correct_file_extension = true;
        return false;  // break;
      }
    });
  }
  return this.optional( element ) || correct_file_extension;
}, "El archivo seleccionado no es válido.");
