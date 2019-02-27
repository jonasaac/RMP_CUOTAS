<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
  $hash_id = hash('md5', time());
  ?>
  <div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
      <?= $this->Form->create($guiaEncabezado, ['id' => 'guia-form']) ?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label col-sm-3">Tipo de Guia</label>
            <div class="col-sm-9">
              <div class="radio radio-inline">
                <label>
                  <input id="virtual-radio" name="virtual" type="radio" value="1"<?= $guiaEncabezado->virtual==1?'checked="checked"':''?>/>
                  <span class="text">Virtual</span>
                </label>
              </div>
              <div class="radio radio-inline">
                <label>
                  <input id="real-radio" name="virtual" type="radio" value="0"<?= $guiaEncabezado->virtual==0?'checked="checked"':''?>/>
                  <span class="text">Real</span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <legend>Guia Encabezado - <?=$guiaEncabezado->nro_guia?></legend>
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
                <select class="form-control input-xs" name="movimiento_id" id="movimiento-id" placeholder="Seleccione un movimiento" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($movimientos as $id => $movimiento): ?>
                    <option value="<?=$id?>"<?=$id==$guiaEncabezado->movimiento_id?' selected="selected"':''?>><?=$movimiento?></option>
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
                <select class="form-control input-xs" name="origen_id" id="origen-id" placeholder="Seleccione un origen" lang="es" style="width: 100%">
                  <option value=""></option>
                  <?php foreach($origenes as $id => $grupo): ?>
                    <optgroup label="<?=$id?>">
                      <?php foreach($grupo as $id => $origen):?>
                        <?php if (isset($origen->puerto)): ?>
                          <?php foreach($origen->puerto->pontones as $ponton): ?>
                            <option value="<?=$ponton->id?>"<?=$ponton->id==$guiaEncabezado->origen_id?' selected="selected"':''?>><?=$origen->puerto->nombre.' - '.$ponton->nombre?></option>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <option value="<?=$id?>"<?=$id==$guiaEncabezado->origen_id?' selected="selected"':''?>><?=$origen?></option>
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
                <select class="form-control input-xs" name="destino_id" id="destino-id" placeholder="Seleccione un destino" lang="es" style="width: 100%">
                  <option value=""></option>
                  <?php foreach($destinos as $id => $grupo): ?>
                    <optgroup label="<?=$id?>">
                      <?php foreach($grupo as $id => $destino): ?>
                        <option value="<?=$id?>"<?=$id==$guiaEncabezado->destino_id?' selected="selected"':''?>><?=$destino?></option>
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
                <select class="form-control input-xs" name="camion_id" id="camion-id" placeholder="Seleccione un camión" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($camiones as $id => $camion): ?>
                    <option value="<?=$id?>"<?=$id==$guiaEncabezado->camion_id?' selected="selected"':''?>><?=$camion?></option>
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
                <select class="form-control input-xs" name="chofer_id" id="chofer-id" placeholder="Seleccione un chofer" lang="es" style="width: 100%">
                  <option></option>
                  <?php foreach($choferes as $id => $chofer): ?>
                    <option value="<?=$id?>"<?=$id==$guiaEncabezado->chofer_id?' selected="selected"':''?>><?=$chofer?></option>
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
        <button class="btn" id="add-detalles" style="display:none;">Agregar Detalles</button>
        <button class="btn" id="edit-detalles">Editar Detalles</button>
        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered table-striped" id="guia-detalles-table">
              <thead>
                <tr>
                  <th>Cód. Descarga</th>
                  <th>Nave</th>
                  <th>Fecha Recalada</th>
                  <th>Especie</th>
                  <th><?= $recurso->unidad_principal->abreviacion ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                foreach ($guiaEncabezado->guia_detalles as $detalle) {
                  $inputHidden = '<input type="hidden" name="guia_detalles['.$i.'][id]" value="'.$detalle->id.'" class="guia-detalle-id">'.
                  '<input type="hidden" name="guia_detalles['.$i.'][descarga_detalle_id]" value="'.$detalle->descarga_detalle_id.'">'.
                  '<input type="hidden" name="guia_detalles['.$i.'][especie_id]" value="'.$detalle->especie_id.'">'.
                  '<input type="hidden" name="inicio_desembarque" value="'.$detalle->descarga_detalle->descarga_encabezado->inicio_desembarque->format(DateTime::ISO8601).'">';
                  $j = 0;
                  $cantidad_usada = 0;
                  foreach($detalle->unidades as $unidad):
                    if ($unidad->id == $recurso->unidad_principal->id) {
                      $cantidad_usada = $this->Number->precision($unidad->_joinData->cantidad, $unidad->precision);
                    }

                    $inputHidden .= '<input type="hidden"'.
                    ' data-unidad-id="'.$unidad->id.'"'.
                    ' data-cantidad="'.$unidad->_joinData->cantidad_total.'"'.
                    ' data-precision="'.$unidad->precision.'"'.
                    ' data-cantidad-usada="'.$unidad->_joinData->cantidad.'"'.
                    ' name="guia_detalles['.$i.'][unidades]['.$j.'][_joinData][cantidad]"'.
                    ' value="'.$this->Number->precision($unidad->_joinData->cantidad, $unidad->precision).'">'.
                    '<input type="hidden"'.
                    ' name="guia_detalles['.$i.'][unidades]['.$j.'][id]"'.
                    ' value="'.$unidad->id.'">';
                    $j++;
                  endforeach;
                  echo '<tr>'.
                  '<td>'.$detalle->descarga_detalle->descarga_encabezado->codigo_descarga.'</td>'.
                  '<td>'.$detalle->descarga_detalle->descarga_encabezado->recalada->marea->nave->nombre.'</td>'.
                  '<td>'.convertirFecha($detalle->descarga_detalle->descarga_encabezado->recalada->fecha_recalada->toUnixString()).'</td>'.
                  '<td>'.$detalle->especie->nombre.'</td>'.
                  '<td>'.$inputHidden.$cantidad_usada.'</td>'.
                  '</tr>';
                  $i++;
                }
                ?>
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
    detallesData = [
      <?php foreach($guiaEncabezado->guia_detalles as $detalle): ?>
      <?= $detalle->id.',' ?>
      <?php endforeach; ?>
    ];
    cantidad_inicial = {
      <?php
      foreach ($guiaEncabezado->guia_detalles as $detalle) {
        foreach($detalle->unidades as $unidad) {
          if($recurso->unidad_principal_id == $unidad->id) {
            echo '"'.$detalle->descarga_detalle_id.'":'.$unidad->_joinData->cantidad.',';
          }
        }
      }
      ?>
    };
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
      console.log(data);

      $.each(data.auxiliares, function(i, chofer) {
        choferes.push({id: i, text: chofer});
      });
      $('#chofer-id', $thisModal).select2({
        data: choferes,
        dropdownParent: $thisModal,
        minimumInputLength: 2
      });
    })

    $('#fecha-salida-date', $thisModal).val( moment.utc('<?=$guiaEncabezado->fecha_salida->format(DateTime::ISO8601)?>').format('DD-MMM-YYYY') );
    $('#fecha-salida-date-container', $thisModal).datetimepicker(dateOptions());
    $('#fecha-salida-time', $thisModal).val( moment.utc('<?=$guiaEncabezado->fecha_salida->format(DateTime::ISO8601)?>').format('HH:mm') );
    $('#fecha-salida-time-container', $thisModal).datetimepicker(timeOptions());
    $('#fecha-recepcion-date', $thisModal).val( moment.utc('<?=$guiaEncabezado->fecha_recepcion?$guiaEncabezado->fecha_recepcion->format(DateTime::ISO8601):''?>').format('DD-MMM-YYYY') );
    $('#fecha-recepcion-date-container', $thisModal).datetimepicker(dateOptions());
    $('#fecha-recepcion-time', $thisModal).val( moment.utc('<?=$guiaEncabezado->fecha_recepcion?$guiaEncabezado->fecha_recepcion->format(DateTime::ISO8601):''?>').format('HH:mm') );
    $('#fecha-recepcion-time-container', $thisModal).datetimepicker(timeOptions());

    $('#fecha-salida-date-container', $thisModal).on('dp.change', function() {
      $('#fecha-recepcion-date-container', $thisModal).data('DateTimePicker')
        .minDate($('#fecha-salida-date-container', $thisModal).data("DateTimePicker").date())
    });

    if($('#virtual-radio').is(':checked')) {
      $('#nro-guia', $thisModal).prop('disabled', function(i, v) { return !v; });
      $('#fecha-recepcion-date', $thisModal).parents('.form-group').toggle();
      $('#camion-id', $thisModal).prop('disabled', function(i, v) { return !v; });
      $('#camion-id', $thisModal).parents('.form-group').toggle();
      $('#chofer-id', $thisModal).prop('disabled', function(i, v) { return !v; });
      $('#chofer-id', $thisModal).parents('.form-group').toggle();
    }

    $(':radio[name="virtual"]', $thisModal).on('change', function () {
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
        }
      });
    });
    <?php endif; ?>

    newGuiaDetallesOptions = {
      oTable: $('#guia-detalles-table'),
      sTableReloadPage: '/api/guia_detalles/1',
      dialogSize: BootstrapDialog.SIZE_WIDE,
      fnCreateCallback: null,
      acceptCallback: function ( dialog ) {
        if ( $('#descargas-table .danger:not(:hidden)').length > 0) {
          errorNotify('Existen datos mal ingresados');
        } else {
          $('#guia-detalles-table tbody').html('');
          var stbody = '';
          var minDate = 0;
          $.each(detallesData, function (i, v) {
            if (Number(toggleNumberFormat(v.cantidad_usada)) == 0) {
              return true;
            }
            if (moment.utc(v.inicio_desembarque) > moment.utc(minDate))
            minDate = v.inicio_desembarque;

            // campos ocultos que serán enviados por fomulario
            var inputHidden = '<input type="hidden" name="guia_detalles['+i+'][descarga_detalle_id]" value="'+v.id+'">';
            if ( v.detalle_id ) {
              inputHidden += '<input type="hidden" name="guia_detalles['+i+'][id]" value="'+v.detalle_id+'" class="guia-detalle-id">';
            }
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

            // información mostrada en la fila
            var srow = '<tr>';
            srow += '<td>'+v.codigo_descarga+'</td>';
            srow += '<td>'+v.nave+'</td>';
            srow += '<td>'+moment.utc(v.fecha_recalada).format('DD-MMM-YYYY HH:mm')+'</td>';
            srow += '<td>'+v.especie.nombre+'</td>';
            srow += '<td>'+inputHidden+v.cantidad_usada+'</td>';
            srow += '</tr>';

            stbody += srow;
          });
          $('#fecha-salida-date-container').data("DateTimePicker").minDate(moment.utc(minDate));
          $('#guia-detalles-table tbody').html(stbody);
          if (stbody.length > 0) {
            $('#add-detalles').hide();
            $('#edit-detalles').show();
          }
          dialog.close();
        }
      }
    }

    $('#add-detalles').click(function (e) {
      e.preventDefault();
      newEntity('Agregar Detalles', '/guia_detalles/add/<?=$guiaEncabezado->recurso_id?>/', newGuiaDetallesOptions, msgs.rmp.guias.detalles);
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
          data.detalle_id = $(this).find('.guia-detalle-id').val();
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

          //cantidad_inicial[data.id] = toggleNumberFormat(cantidad, <?=$recurso->unidad_principal->precision?>);

          var $row = $(sRow);
          $row.data('data', data);
          $detallesTable.append($row);
        });
      };
      newEntity('Editar Detalles', '/guia_detalles/add/<?=$guiaEncabezado->recurso_id?>/', editDetallesOptions, msgs.rmp.guias.detalles);
    });

    /*var heights = $('form .col-sm-6').map(function() {
      return $(this).height();
    }).get();
    maxHeight = Math.max.apply(null, heights);
    $("form .col-sm-6").height(maxHeight);*/

    $('#guia-form', $thisModal).validate({
      rules: {
        nro_guia: {
          required: true,
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
