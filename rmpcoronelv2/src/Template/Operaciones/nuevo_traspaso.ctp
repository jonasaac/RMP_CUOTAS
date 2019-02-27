<?php
$this->layout = 'ajax';
if (!$this->request->is('post')):
  $hash_id = hash('md5', time());
  ?>
<div class="row" id="<?=$hash_id?>">
  <form class="form-horizontal" id="traspaso-form">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Especie</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="especie_id" id="especie-id1" data-placeholder="Seleccione la Especie" lang="es" style="width:100%;">
                      <option value></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Licencia</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="operaciones[0][licencia_id]" id="licencia-id1" data-placeholder="Seleccione la Licencia" lang="es" style="width:100%;">
                      <option value></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Fecha Promulgación</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-xs date-picker" id="fecha-promulgacion1-date-container">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                      <input name="operaciones[0][fecha_promulgacion]" id="fecha-promulgacion1-date" type="text" class="form-control" placeholder="Ingrese Fecha de Promulgación">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Fecha Inicio</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-xs date-picker" id="fecha-inicio1-date-container">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                      <input name="operaciones[0][fecha_inicio]" id="fecha-inicio1-date" type="text" class="form-control" placeholder="Ingrese Fecha de Inicio de Vigencia">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Fecha Termino</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-xs date-picker" id="fecha-termino1-date-container">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                      <input name="operaciones[0][fecha_termino]" id="fecha-termino1-date" type="text" class="form-control" placeholder="Ingrese Fecha de Termino de Vigencia">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Macro Zona</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="operaciones[0][macro_zona_id]" id="macro-zona-id1" data-placeholder="Seleccione la Macro Zona" lang="es" style="width:100%;">
                      <option value></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Tipo Operación</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="operaciones[0][tipo_operacion_id]" id="tipo-operacion-id1" data-placeholder="Seleccione el Tipo de Operación" lang="es" style="width:100%;">
                      <option value></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Segundo traspaso -->
        <div class="col-md-6" style="background-color: rgba(0,0,0,0.05);">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Especie</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="especie_id" id="especie-id2" data-placeholder="Seleccione la Especie" lang="es" style="width:100%;">
                    <option value></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Licencia</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="operaciones[1][licencia_id]" id="licencia-id2" data-placeholder="Seleccione la Licencia" lang="es" style="width:100%;">
                    <option value></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Fecha Promulgación</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-xs date-picker" id="fecha-promulgacion2-date-container">
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    <input name="operaciones[1][fecha_promulgacion]" id="fecha-promulgacion2-date" type="text" class="form-control" placeholder="Ingrese Fecha de Promulgación" readonly="readonly">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Fecha Inicio</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-xs date-picker" id="fecha-inicio2-date-container">
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    <input name="operaciones[1][fecha_inicio]" id="fecha-inicio2-date" type="text" class="form-control" placeholder="Ingrese Fecha de Inicio de Vigencia">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Fecha Termino</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-xs date-picker" id="fecha-termino2-date-container">
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    <input name="operaciones[1][fecha_termino]" id="fecha-termino2-date" type="text" class="form-control" placeholder="Ingrese Fecha de Termino de Vigencia">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Macro Zona</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="operaciones[0][macro_zona_id]" id="macro-zona-id2" data-placeholder="Seleccione la Macro Zona" lang="es" style="width:100%;">
                    <option value></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Tipo Operación</label>
                <div class="col-sm-9">
                  <select class="form-control input-xs" name="operaciones[0][tipo_operacion_id]" id="tipo-operacion-id2" data-placeholder="Seleccione el Tipo de Operación" lang="es" style="width:100%;">
                    <option value></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr/>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Resolución</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-xs" id="resolucion" name="resolucion" placeholder="Ingrese la Resolución"/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Auxiliar</label>
            <div class="col-sm-9">
                <select class="form-control input-xs" name="auxiliar_id" id="auxiliar-id" data-placeholder="Seleccione el Auxiliar" lang="es" style="width:100%;">
                  <option value></option>
                </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Cantidad</label>
            <div class="col-sm-9">
              <div class="input-container">
                <input type="text" class="form-control input-xs" id="cantidad" name="cantidad" placeholder="0,000"/>
                <label>TON</label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Adjunto</label>
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
      </div>
      <hr/>
      <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Observaciones</label>
                  <div class="col-sm-9">
                      <textarea name="observaciones" class="form-control"></textarea>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function() {
  // Se inicializan los componentes necesarios para la vista
  var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal

  /** Configuracion de Licencias **/
  especies = [];
  $.ajax({
    url: '/api/especies.json',
    dataType: 'json',
    type: 'GET',
    data: {
      tieneLicencias: true
    }
  }).done(function(data) {
    $.each(data.especies, function(i, especie) {
      especies.push({id: especie.id, text: especie.nombre});
    });
    $('#especie-id1', $thisModal).select2({
      dropdownParent: $thisModal,
      data: especies
    });
    $('#especie-id2', $thisModal).select2({
      dropdownParent: $thisModal,
      data: especies
    });
  });
  $('#especie-id1', $thisModal).select2();
  $('#especie-id2', $thisModal).select2();
  $('#especie-id1', $thisModal).on('change', function() {
      $('#especie-id2', $thisModal).val($(this).val()).trigger('change');
      var especie_id = $(this).val();
      $.ajax({
        url: '/api/licencias.json',
        dataType: 'json',
        type: 'GET',
        data: function (query, page) {
            return {
                especie: especie_id,
                q: query.term,
            }
        },
      }).done(function(data) {
        var licencias_id1 = [{id: '', text: ''}];
        $.each(data.licencias, function(i, licencia) {
          licencias_id1.push({id: licencia.id, text: licencia.display_name});
        });
        console.log(licencias_id1);
        $('#licencia-id1', $thisModal).html('');
        $('#licencia-id1', $thisModal).select2({
          data: licencias_id1
        });
        $('#licencia-id1', $thisModal).prop('disabled', false);
      });
  });
  $('#especie-id2', $thisModal).on('change', function() {
      var especie_id = $(this).val();
      $.ajax({
        url: '/api/licencias.json',
        dataType: 'json',
        type: 'GET',
        data: function (query, page) {
            return {
                especie: especie_id,
                q: query.term,
            }
        },
      }).done(function(data) {
        var licencias_id2 = [{id: '', text: ''}];
        $.each(data.licencias, function(i, licencia) {
          licencias_id2.push({id: licencia.id, text: licencia.display_name});
        });
        $('#licencia-id2', $thisModal).html('');
        $('#licencia-id2', $thisModal).select2({
          data: licencias_id2
        });
        $('#licencia-id2', $thisModal).prop('disabled', false);
      });
  });
  $('#licencia-id1', $thisModal).prop('disabled', true);
  $('#licencia-id1', $thisModal).select2({
    dropdownParent: $thisModal
  });
  $('#licencia-id2', $thisModal).prop('disabled', true);
  $('#licencia-id2', $thisModal).select2({
    dropdownParent: $thisModal
  });
  $('#licencia-id1', $thisModal).on('change', function() {
    $('#licencia-id2', $thisModal).val($(this).val()).trigger('change');
  });
  /** FIN Configuracion de Licencias **/

  /** Configuracion de Fechas **/
  $('#fecha-promulgacion1-date-container', $thisModal).datetimepicker(dateOptions(false, moment()));
  $('#fecha-inicio1-date-container', $thisModal).datetimepicker(dateOptions(false));
  $('#fecha-termino1-date-container', $thisModal).datetimepicker(dateOptions(false));
  $('#fecha-promulgacion2-date-container', $thisModal).datetimepicker(dateOptions(false));
  $('#fecha-inicio2-date-container', $thisModal).datetimepicker(dateOptions(false));
  $('#fecha-termino2-date-container', $thisModal).datetimepicker(dateOptions(false));

  $("#fecha-promulgacion1-date-container", $thisModal).on('dp.change', function() {
    $('#fecha-promulgacion2-date-container', $thisModal).data("DateTimePicker")
      .date($('#fecha-promulgacion1-date-container', $thisModal).data("DateTimePicker").date());
  });
  $("#fecha-inicio1-date-container", $thisModal).on('dp.change', function() {
    $('#fecha-inicio2-date-container', $thisModal).data("DateTimePicker")
      .date($('#fecha-inicio1-date-container', $thisModal).data("DateTimePicker").date());
    $('#fecha-termino1-date-container', $thisModal).data("DateTimePicker")
      .minDate($('#fecha-inicio1-date-container', $thisModal).data("DateTimePicker").date())
      .date($('#fecha-inicio1-date-container', $thisModal).data("DateTimePicker").date());
  });
  $("#fecha-termino1-date-container", $thisModal).on('dp.change', function() {
    $('#fecha-termino2-date-container', $thisModal).data("DateTimePicker")
      .date($('#fecha-termino1-date-container', $thisModal).data("DateTimePicker").date());
  });
  $("#fecha-inicio2-date-container", $thisModal).on('dp.change', function() {
    $('#fecha-termino2-date-container', $thisModal).data("DateTimePicker")
      .minDate($('#fecha-inicio2-date-container', $thisModal).data("DateTimePicker").date())
      .date($('#fecha-inicio2-date-container', $thisModal).data("DateTimePicker").date());
  });
  /** FIN Configuracion de Fechas **/

  /** Configuracion de Macro Zonas **/
  macro_zonas = [];
  $.ajax({
    url: '/api/macro_zonas.json',
    dataType: 'json',
    type: 'GET'
  }).done(function(data) {
    var results = [];
    $.each(data.macro_zonas, function(i, val) {
      macro_zonas.push({id: val.id, text: val.nombre});
    });
    $('#macro-zona-id1', $thisModal).select2({
      dropdownParent: $thisModal,
      data: macro_zonas
    });
    $('#macro-zona-id2', $thisModal).select2({
      dropdownParent: $thisModal,
      data: macro_zonas
    });
  });
  $('#macro-zona-id1', $thisModal).select2({
    dropdownParent: $thisModal
  });
  $('#macro-zona-id2', $thisModal).select2({
    dropdownParent: $thisModal
  });
  $('#macro-zona-id1', $thisModal).on('change', function() {
    $('#macro-zona-id2', $thisModal).val($(this).val()).trigger('change');
  });
  /** FIN Configuracion de Macro Zonas **/

  /** Configuracion de Tipo Operaciones **/
  tipo_operaciones = [];
  $.ajax({
    url: '/api/tipo_operaciones.json',
    dataType: 'json',
    type: 'GET'
  }).done(function(data) {
    var results = [];
    $.each(data.tipo_operaciones, function(i, val) {
      tipo_operaciones.push({id: val.id, text: val.nombre});
    });
    $('#tipo-operacion-id1', $thisModal).select2({
      dropdownParent: $thisModal,
      data: tipo_operaciones
    });
    $('#tipo-operacion-id2', $thisModal).select2({
      dropdownParent: $thisModal,
      data: tipo_operaciones
    });
  });
  $('#tipo-operacion-id1', $thisModal).select2({
    dropdownParent: $thisModal
  });
  $('#tipo-operacion-id2', $thisModal).select2({
    dropdownParent: $thisModal
  });
  $('#tipo-operacion-id1', $thisModal).on('change', function() {
    $('#tipo-operacion-id2', $thisModal).val($(this).val()).trigger('change');
  });
  /** FIN Configuracion de Tipo Operaciones **/

  /** Configuracion Auxiliar **/
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
  /** FIN Configuracion Auxiliar **/

  /** Configuracion de Adjunto **/
  $('#adjunto-file', $thisModal).on('change', function() {
      $('#adjunto-text-container', $thisModal).val($(this).val().replace(/C:\\fakepath\\/i, '...\\'));
  });
  /** FIN Configuracion de Adjunto **/

  /** Validaciones **/
  $('#traspaso-form', $thisModal).validate({
    rules: {
      "operaciones[0][licencia_id]": {
        required: true
      },
      "operaciones[0][fecha_promulgacion]": {
        required: true
      },
      "operaciones[0][fecha_inicio]": {
        required: true
      },
      "operaciones[0][fecha_termino]": {
        required: true
      },
      "operaciones[0][macro_zona_id]": {
        required: true
      },
      "operaciones[0][tipo_operacion_id]": {
        required: true
      },
      "operaciones[1][licencia_id]": {
        required: true
      },
      "operaciones[1][fecha_promulgacion]": {
        required: true
      },
      "operaciones[1][fecha_inicio]": {
        required: true
      },
      "operaciones[1][fecha_termino]": {
        required: true
      },
      "operaciones[1][macro_zona_id]": {
        required: true
      },
      "operaciones[1][tipo_operacion_id]": {
        required: true
      },
      resolucion: {
        required: true,
      },
      auxiliar_id: {
        required: true,
      },
      cantidad: {
        required: true,
        number: true
      },
      adjunto_file: {
        fileExtension: ['pdf']
      }
    }
  });
  /** FIN Validaciones **/
});
</script>
<?php
endif;
?>
