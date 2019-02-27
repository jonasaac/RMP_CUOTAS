<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
  $hash_id = hash('md5', time());
  ?>
  <div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
      <?= $this->Form->create($guiaEncabezado, ['id' => 'guia-form']) ?>
      <input type="hidden" name="descarga_encabezado_id" id="descarga-encabezado-id">
      <input type="hidden" name="codigo_descarga" id="codigo-descarga">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label col-sm-3">Tipo de Guia</label>
            <div class="col-sm-9">
              <div class="radio radio-inline">
                <label>
                  <input id="virtual-radio" name="virtual" type="radio" value="1"/>
                  <span class="text">Virtual</span>
                </label>
              </div>
              <div class="radio radio-inline">
                <label>
                  <input id="real-radio" name="virtual" type="radio" value="0" checked="checked"/>
                  <span class="text">Real</span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <legend>Guia Encabezado</legend>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <?= $this->Form->input('nro_guia', ['placeholder' => 'Ingrese el número de guia']) ?>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Movimiento</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="movimiento_id" id="movimiento-id" data-placeholder="Seleccione un movimiento" placeholder="Seleccione un movimiento" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($movimientos as $id => $movimiento): ?>
                    <option value="<?=$id?>"><?=$movimiento?></option>
                  <?php endforeach; ?>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_movimiento_add'], $current_user['privilegios'])): ?>
                    <a id="new-movimiento" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-movimiento" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Origen</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="origen_id" id="origen-id" data-placeholder="Seleccione un origen" placeholder="Seleccione un origen" lang="es" style="width: 100%">
                  <option value=""></option>
                  <?php foreach($origenes as $id => $grupo): ?>
                    <optgroup label="<?=$id?>">
                      <?php foreach($grupo as $id => $origen):?>
                        <?php if (isset($origen->puerto)): ?>
                          <?php foreach($origen->puerto->pontones as $ponton): ?>
                            <option value="<?=$ponton->id?>"><?=$origen->puerto->nombre.' - '.$ponton->nombre?></option>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <option value="<?=$id?>"><?=$origen?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </optgroup>
                  <?php endforeach; ?>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_ponton_add', 'admin_planta_add'], $current_user['privilegios'])): ?>
                    <a id="new-origen" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-origen" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de Salida</label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-7">
                  <div class="input-group input-group-xs date-picker" id="fecha-salida-date-container">
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    <input name="fecha_salida_date" id="fecha-salida-date" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="input-group input-group-xs time-picker" id="fecha-salida-time-container">
                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                    <input name="fecha_salida_time" id="fecha-salida-time" type="text" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Destino</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="destino_id" id="destino-id" data-placeholder="Seleccione un destino" placeholder="Seleccione un destino" lang="es" style="width: 100%">
                  <option value=""></option>
                  <?php foreach($destinos as $id => $grupo): ?>
                    <optgroup label="<?=$id?>">
                      <?php foreach($grupo as $id => $destino): ?>
                        <option value="<?=$id?>"><?=$destino?></option>
                      <?php endforeach; ?>
                    </optgroup>
                  <?php endforeach; ?>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_planta_add'], $current_user['privilegios'])): ?>
                    <a id="new-destino" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-destino" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de Recepción</label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-7">
                  <div class="input-group input-group-xs date-picker" id="fecha-recepcion-date-container">
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    <input name="fecha_recepcion_date" id="fecha-recepcion-date" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="input-group input-group-xs time-picker" id="fecha-recepcion-time-container">
                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                    <input name="fecha_recepcion_time" id="fecha-recepcion-time" type="text" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Camión</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="camion_id" id="camion-id" data-placeholder="Seleccione un camión" placeholder="Seleccione un camión" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($camiones as $id => $camion): ?>
                    <option value="<?=$id?>"><?=$camion?></option>
                  <?php endforeach; ?>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_camion_add'], $current_user['privilegios'])): ?>
                    <a id="new-camion" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-camion" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Chofer</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="chofer_id" id="chofer-id" data-placeholder="Seleccione un chofer" placeholder="Seleccione un chofer" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($choferes as $id => $chofer): ?>
                    <option value="<?=$id?>"><?=$chofer?></option>
                  <?php endforeach; ?>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                    <a id="new-chofer" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-chofer" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <?= $this->Form->input('observaciones') ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <legend>Detalles</legend>
        </div>
      </div>
      <div class="row">
      <div class="col-lg-12">
        <button class="btn" id="add-detalles">Agregar Detalles</button>
        <button class="btn" id="edit-detalles" style="display:none;">Editar Detalles</button>
        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered table-striped" id="guia-detalles-table">
              <thead>
                <tr>
                  <th class="col-sm-3">Cód. Descarga</th>
                  <th class="col-sm-3">Nave</th>
                  <th>Fecha Recalada</th>
                  <th>Especie</th>
                  <th><?= $recurso->unidad_principal->abreviacion ?></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?= $this->Form->end() ?>
    </div>
  </div>
  <script>
  $(document).ready(function() {
    detallesData = [];
    cantidad_inicial = {};
    var $thisModal = $('#<?=$hash_id?>');
    $('#movimiento-id, #origen-id, #destino-id, #camion-id', $thisModal).select2({
        dropdownParent: $thisModal
    });
    choferes = [];
    $.ajax({
      url: '/api/auxiliares.json?funcion=chofer',
      type: 'GET',
      dataType: 'json',
    })
    .done(function (data) {
      $.each(data.auxiliares, function(i, chofer) {
        choferes.push({id: i, text: chofer});
      });
      $('#chofer-id', $thisModal).select2({
        data: choferes,
        dropdownParent: $thisModal,
        minimumInputLength: 2
      });
    })
    $('#fecha-salida-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
    $('#fecha-salida-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
    $('#fecha-salida-time', $thisModal).val(moment().format('HH:mm'));
    $('#fecha-salida-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));
    $('#fecha-recepcion-date', $thisModal).val('');
    $('#fecha-recepcion-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
    $('#fecha-recepcion-time', $thisModal).val('');
    $('#fecha-recepcion-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));

    $('#fecha-salida-date-container', $thisModal).on('dp.change', function() {
      $('#fecha-recepcion-date-container', $thisModal).data('DateTimePicker')
        .minDate($('#fecha-salida-date-container', $thisModal).data("DateTimePicker").date());
    });

    $(':radio[name="virtual"]', $thisModal).on('change', function () {
      $('#nro-guia', $thisModal).prop('disabled', function(i, v) { return !v; });
      $('#nro-guia', $thisModal).prop('required', function(i, v) { return !v; });
      $('#nro-guia', $thisModal).removeClass('has-error');
      $('#nro-guia', $thisModal).parents('.form-group').removeClass('has-error');
      $('#fecha-recepcion-date', $thisModal).parents('.form-group').toggle();
      $('#camion-id', $thisModal).prop('disabled', function(i, v) { return !v; });
      $('#camion-id', $thisModal).parents('.form-group').toggle();
      $('#chofer-id', $thisModal).prop('disabled', function(i, v) { return !v; });
      $('#chofer-id', $thisModal).parents('.form-group').toggle();
    });

    <?php if(array_in_array(['admin_movimiento_add'], $current_user['privilegios'])): ?>
    $('#new-movimiento', $thisModal).click(function (e) {
      e.stopPropagation();
      newEntity('Nuevo Movimiento', '/movimientos/add', {
        successCallback: function ( data ){
          var $select = $('#movimiento-id', $thisModal);
          $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
        }
      });
    });
    <?php endif; ?>
    <?php if(array_in_array(['admin_camion_add'], $current_user['privilegios'])): ?>
    $('#new-camion', $thisModal).click(function (e) {
      e.stopPropagation();
      newEntity('Nuevo Camión', '/camiones/add', {
        successCallback: function ( data ){
          var $select = $('#camion-id', $thisModal);
          $select.append('<option value="'+data.data.id+'">'+data.data.patente+'</option>');
        }
      });
    });
    <?php endif; ?>
    <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
    $('#new-chofer', $thisModal).click(function (e) {
      e.stopPropagation();
      newEntity('Nuevo Chofer', '/auxiliares/add/chofer', {
        successCallback: function ( data ){
          var $select = $('#chofer-id', $thisModal);
          $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
        }
      });
    });
    <?php endif; ?>
    <?php if(array_in_array(['admin_ponton_add', 'admin_planta_add'], $current_user['privilegios'])): ?>
    $('#new-origen', $thisModal).click(function (e) {
      e.stopPropagation();

      newEntityTitle = 'Nueva Planta';
      entityName = 'plantas';
      BootstrapDialog.show({
        closable: false,
        message: '¿Que origen desea ingresar?',
        buttons: [{
          label: 'Planta',
          action: function ( dialog ) {
            dialog.close();
            newEntity('Nueva Planta', '/plantas/add', {
              successCallback: function ( data ){
                var $select = $('#origen-id', $thisModal);
                $select.find('[label="Plantas"]').append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
              }
            });
          }
        }, {
          label: 'Ponton',
          action: function ( dialog ) {
            dialog.close();
            newEntity('Nuevo Ponton', '/pontones/add', {
              successCallback: function ( data ){
                var $select = $('#origen-id', $thisModal);
                $select.find('[label="Pontones"]').append('<option value="'+data.data.id+'">'+data.data.puerto.nombre+' - '+data.data.nombre+'</option>');
              }
            });
          }
        },{
          label: 'Cancelar',
          action: function ( dialog ) {
            dialog.close();
          }
        }]
      })
    });
    <?php endif; ?>
    <?php if(array_in_array(['admin_planta_add'], $current_user['privilegios'])): ?>
    $('#new-destino', $thisModal).click(function (e) {
      e.stopPropagation();
      newEntity('Nuevo Chofer', '/plantas/add', {
        successCallback: function ( data ){
          var $select = $('#destino-id', $thisModal);
          $select.find('[label="Plantas"]').append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
          $select.select2('val', data.data.id);
        }
      });
    });
    <?php endif; ?>

    newGuiaDetallesOptions = {
      oTable: $('#guia-detalles-table'),
      sTableReloadPage: '/api/guia_detalles/1',
      dialogSize: BootstrapDialog.SIZE_WIDE,
      acceptCallback: function ( dialog ) {
        if ( $('#descargas-table .danger:not(:hidden)').length > 0) {
          errorNotify('Existen datos mal ingresados');
        }
        else if ( $('#detalles-table tbody tr').length == 0) {
          warningNotify('No se han ingresado datos');
        }
        else {
          $('#guia-detalles-table tbody').html('');
          var stbody = '';
          var minDate = 0;
          $.each(detallesData, function (i, v) {
            $('#codigo-descarga').val(v.codigo_descarga);
            $('#descarga-encabezado-id').val(v.descarga_encabezado_id);

            if (Number(toggleNumberFormat(v.cantidad_usada)) == 0) {
              return true;
            }
            if (moment(v.inicio_desembarque) > moment(minDate))
            minDate = v.inicio_desembarque;

            // campos ocultos que serán enviados por fomulario
            var inputHidden = '<input type="hidden" name="guia_detalles['+i+'][descarga_detalle_id]" value="'+v.id+'">';
            inputHidden += '<input type="hidden" name="guia_detalles['+i+'][especie_id]" value="'+v.especie_id+'">';
            inputHidden += '<input type="hidden" name="inicio_desembarque" value="'+v.inicio_desembarque+'">';
            $.each(v.unidades, function (j, unidad) {
              inputHidden += '<input type="hidden"';
              inputHidden += ' data-unidad-id="'+unidad.id+'"';
              inputHidden += ' data-cantidad="'+unidad._joinData.cantidad+'"';
              inputHidden += ' data-precision="'+unidad.precision+'"';
              inputHidden += ' data-cantidad-usada="'+unidad.cantidad_usada+'"';
              inputHidden += ' name="guia_detalles['+i+'][unidades]['+j+'][_joinData][cantidad]"';
              inputHidden += ' value="'+toggleNumberFormat(unidad.cantidad_usada, unidad.precision)+'">';
              inputHidden += '<input type="hidden" name="guia_detalles['+i+'][unidades]['+j+'][id]" value="'+unidad.id+'">';
            });

            var srow = '<tr>';
            srow += '<td>'+v.codigo_descarga+'</td>';
            srow += '<td>'+v.nave+'</td>';
            srow += '<td>'+moment.utc(v.fecha_recalada).format('DD-MMM-YYYY HH:mm')+'</td>';
            srow += '<td>'+v.especie.nombre+'</td>';
            srow += '<td>'+inputHidden+v.cantidad_usada+'</td>';
            srow += '</tr>';

            stbody += srow;
          });
          $('#fecha-salida-date-container').data("DateTimePicker").minDate(moment(minDate));
          $('#guia-detalles-table tbody').html(stbody);
          if (stbody.length > 0) {
            $('#add-detalles').hide();
            $('#edit-detalles').show();
          }
          dialog.close();
        }
      }
    };

    $('#add-detalles').click(function (e) {
      e.preventDefault();
      newEntity('Agregar Detalles', '/guia_detalles/add/<?=$recurso->id?>/', newGuiaDetallesOptions, msgs.rmp.guias.detalles);
    });
    $('#edit-detalles').click(function (e) {
      e.preventDefault();
      var editDetallesOptions = newGuiaDetallesOptions;
      editDetallesOptions.fnCreateCallback = function ($message) {
        var $detallesTable = $('#detalles-table tbody', $message);
        $('#guia-detalles-table tbody tr').each(function () {
          var codigo_descarga = $(this).find('td:eq(0)').text();
          var nave = $(this).find('td:eq(1)').text();
          var especie = $(this).find('td:eq(3)').text();
          var cantidad = $(this).find('td:eq(4)').text();

          sRow = '<tr>';
          sRow += '<td>'+codigo_descarga+'</td>';
          sRow += '<td>'+nave+'</td>';
          sRow += '<td>'+especie+'</td>';
          sRow += '<td><input type="text" value="'+cantidad+'" class="from-control input-xs" name="cantidad"></td>';
          sRow += '</tr>';

          var data = {};
          data.id = $(this).find('[name$="[descarga_detalle_id]"]').val();
          data.codigo_descarga = codigo_descarga;
          data.nave = nave;
          data.especie = {nombre: especie};
          data.especie_id = $(this).find('[name$="[especie_id]"]').val();
          data.inicio_desembarque = $(this).find('[name=inicio_desembarque]').val();
          data.unidades = [];
          $('[name*="[unidades]"][name$="[cantidad]"]', $(this)).each(function () {
            data.unidades.push({
              'id': $(this).data('unidadId'),
              'cantidad_usada': $(this).data('cantidadUsada'),
              'precision': $(this).data('precision'),
              '_joinData': {
                'cantidad': $(this).data('cantidad')
              }
            });
          });

          //cantidad_inicial[data.id] = 0.0;//toggleNumberFormat(cantidad);

          var $row = $(sRow);
          $row.data('data', data);
          $detallesTable.append($row);
        });
      };
      newEntity('Editar Detalles', '/guia_detalles/add/<?=$recurso->id?>/', editDetallesOptions, msgs.rmp.guias.detalles);
    });

    var heights = $('form .col-sm-6').map(function() {
      return $(this).height();
    }).get();
    maxHeight = Math.max.apply(null, heights);
    $("form .col-sm-6").height(maxHeight);

    $('#guia-form', $thisModal).validate({
      rules: {
        nro_guia: {
          /*required: function () {
              return $(':radio[name="virtual"]:checked', $thisModal).val() === "0";
          },*/
          digits: true
        },
        movimiento_id: {
          required: true
        },
        origen_id: {
          required: true
        },
        fecha_salida_date: {
          required: true
        },
        fecha_salida_time: {
          required: true
        },
        destino_id: {
          required: true
        },
        camion_id: {
          required: true
        },
        chofer_id: {
          required: true
        }
      }
    });
  });
  </script>
  <?php
} else {
  echo json_encode([
    'status' => $status,
    'errors' => $guiaEncabezado->errors(),
    'data' => $guiaEncabezado
    ]);
  }
  ?>
