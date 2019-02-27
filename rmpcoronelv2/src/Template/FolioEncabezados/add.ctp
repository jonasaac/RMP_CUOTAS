<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
  $hash_id = hash('md5', time());
  ?>
  <div class="row" id="<?=$hash_id?>">
    <div class="col-lg-12">
      <?= $this->Form->create($folioEncabezado, ['id' => 'folio-form']) ?>
      <input type="hidden" name="descarga_encabezado_id" id="descarga-encabezado-id">
      <input type="hidden" name="codigo_descarga" id="codigo-descarga">
      <div class="row">
        <div class="col-md-12">
          <legend>Folio Encabezado</legend>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <?= $this->Form->input('nro_folio', ['placeholder' => 'Ingrese el número del folio']) ?>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de Recepción</label>
            <div class="col-sm-9">
              <div class="input-group input-group-xs date-picker" id="fecha-recepcion-date-container">
                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                <input name="fecha_recepcion_date" id="fecha-recepcion-date" type="text" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="col-sm-3 control-label">Un. por Kgs</label>
            <div class="col-sm-9">
              <input type="text" name="calibre" id="calibre" class="form-control input-xs" required="required" placeholder="Ingrese el calibre">
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
            <table class="table table-bordered table-striped" id="folio-detalles-table">
              <thead>
                <tr>
                  <th>Cód. Descarga</th>
                  <th>Nave</th>
                  <th>Fecha Recalada</th>
                  <th>Especie</th>
                  <th>Fecha Producción</th>
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
    $('#fecha-recepcion-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
    $('#fecha-recepcion-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
    $('#fecha-recepcion-time', $thisModal).val(moment().format('HH:mm'));
    $('#fecha-recepcion-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));

    newFolioDetallesOptions = {
      oTable: $('#folio-detalles-table'),
      sTableReloadPage: '/api/folio_detalles/1',
      dialogSize: BootstrapDialog.SIZE_WIDE,
      acceptCallback: function ( dialog ) {
        if ( $('#descargas-table .danger:not(:hidden)').length > 0 || $('#detalles-table .danger').length > 0 ) {
          errorNotify('Existen datos mal ingresados');
        }
        else if ( $('#detalles-table tbody tr').length == 0) {
          warningNotify('No se han ingresado datos');
        }
        else {
          $('#folio-detalles-table tbody').html('');
          var stbody = '';
          var minDate = 0;
          var minDateProduccion = moment();
          $.each(detallesData, function (i, v) {
            if (Number(toggleNumberFormat(v.cantidad_usada)) == 0) {
              return true;
            }
            if (moment(v.inicio_desembarque) > moment(minDate))
            minDate = v.inicio_desembarque;
            if (moment(v.fecha_produccion) < moment(minDateProduccion))
            minDateProduccion = v.fecha_produccion;

            // campos ocultos que serán enviados por fomulario
            var inputHidden = '<input type="hidden" name="folio_detalles['+i+'][descarga_detalle_id]" value="'+v.id+'">';
            inputHidden += '<input type="hidden" name="folio_detalles['+i+'][fecha_produccion]" value="'+v.fecha_produccion+'">';
            inputHidden += '<input type="hidden" name="folio_detalles['+i+'][especie_id]" value="'+v.especie_id+'">';
            inputHidden += '<input type="hidden" name="inicio_desembarque" value="'+v.inicio_desembarque+'">';
            $.each(v.unidades, function (j, unidad) {
              inputHidden += '<input type="hidden"';
              inputHidden += ' data-unidad-id="'+unidad.id+'"';
              inputHidden += ' data-cantidad="'+unidad._joinData.cantidad+'"';
              inputHidden += ' data-precision="'+unidad.precision+'"';
              inputHidden += ' data-cantidad-usada="'+unidad.cantidad_usada+'"';
              inputHidden += ' name="folio_detalles['+i+'][unidades]['+j+'][_joinData][cantidad]"';
              inputHidden += ' value="'+toggleNumberFormat(unidad.cantidad_usada, unidad.precision)+'">';
              inputHidden += '<input type="hidden" name="folio_detalles['+i+'][unidades]['+j+'][id]" value="'+unidad.id+'">';
            });

            var srow = '<tr role="row">';
            srow += '<td role="codigo-descarga" data-descarga-encabezado-id="'+v.descarga_encabezado_id+'">'+v.codigo_descarga+'</td>';
            srow += '<td role="nave">'+v.nave+'</td>';
            srow += '<td role="fecha-recalada" data-fecha-recalada="'+v.fecha_recalada+'">'+moment.utc(v.fecha_recalada).format('DD-MMM-YYYY HH:mm')+'</td>';
            srow += '<td role="especie">'+v.especie.nombre+'</td>';
            srow += '<td role="fecha-produccion">'+moment.utc(v.fecha_produccion).format('DD-MMM-YYYY')+'</td>';
            srow += '<td role="cantidad-usada">'+inputHidden+v.cantidad_usada+'</td>';
            srow += '</tr>';

            stbody += srow;
          });
          $('#fecha-recepcion-date-container').data("DateTimePicker").minDate(moment.utc(minDate).set({'hour':0, 'minute':0})).maxDate(moment.utc(minDateProduccion).set({'hour':0, 'minute':0}));
          $('#folio-detalles-table tbody').html(stbody);
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
      newEntity('Agregar Detalles', '/folio_detalles/add/', newFolioDetallesOptions);
    });
    $('#edit-detalles').click(function (e) {
      e.preventDefault();
      var editDetallesOptions = newFolioDetallesOptions;
      editDetallesOptions.fnCreateCallback = function ($message) {
        var $detallesTable = $('#detalles-table tbody', $message);
        $('#folio-detalles-table tbody tr').each(function () {
          var _codigo_descarga = $(this).find('td:eq(0)').text();
          var _descarga_encabezado_id = $(this).find('td:eq(0)').data('descargaEncabezadoId');
          var _nave = $(this).find('td:eq(1)').text();
          var _fecha_recalada = $(this).find('td:eq(2)').data('fechaRecalada');
          var _especie = $(this).find('td:eq(3)').text();
          var _especie_id = $(this).find('[name$="[especie_id]"]').val();
          var _cantidad = $(this).find('td:eq(5)').text();
          var _fecha_produccion = $(this).find('[name$="[fecha_produccion]"]').val();
          var _descarga_detalle_id = $(this).find('[name$="[descarga_detalle_id]"]').val();
          var _inicio_desembarque = $(this).find('[name=inicio_desembarque]').val();

          <?php
              $this->Form->templates([
                  'formGroup' => '{{input}}',
              ]);
          ?>

          sRow = '<tr role="row">';
          sRow += '<td>'+_codigo_descarga+'</td>';
          sRow += '<td>'+_nave+'</td>';
          sRow += '<td>'+_especie+'</td>';
          sRow += '<td><div class="input-group input-group-xs date-picker fecha-produccion"><span class="input-group-addon"><span class="fa fa-calendar"></span></span><input name="fecha_produccion_date" type="text" class="form-control fecha-produccion-date input-small-date"></div></td>';
          sRow += '<td><input type="text" value="'+_cantidad+'" class="from-control input-xs cantidad" name="cantidad"></td>';
          sRow += '</tr>';

          var data = {};
          data.id = _descarga_detalle_id
          data.codigo_descarga = _codigo_descarga;
          data.descarga_encabezado_id = _descarga_encabezado_id;
          data.fecha_recalada = _fecha_recalada;
          data.nave = _nave;
          data.especie = {nombre: _especie};
          data.especie_id = _especie_id
          data.inicio_desembarque = _inicio_desembarque;
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

          $('.fecha-produccion-date', $row).val(moment.utc(_fecha_produccion).format('DD-MMM-YYYY'));
          $('.fecha-produccion', $row).datetimepicker(dateOptions(moment.utc()));
        });
      };
      newEntity('Editar Detalles', '/folio_detalles/add/', editDetallesOptions);
    });

    var heights = $('form .col-sm-6').map(function() {
      return $(this).height();
    }).get();
    maxHeight = Math.max.apply(null, heights);
    $("form .col-sm-6").height(maxHeight);

    $('#folio-form', $thisModal).validate({
      rules: {
        nro_folio: {
          required: true,
          digits: true
        },
        calibre: {
          required: true,
          digits: true
        },
        fecha_recepcion_date: {
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
    'errors' => $folioEncabezado->errors(),
    'data' => $folioEncabezado
    ]);
  }
  ?>
