<?php
$this->extend('/Common/view');
$this->assign('title', 'Control de Calidad');
$this->Html->addCrumb('Control de Calidad', ['controller' => 'Home', 'action' => 'index', '#' => 'calidad']);
$this->Html->addCrumb('SARDINAS ARTESANAL');

// templates
$this->Form->templates([
    'formGroup' => '{{input}}',
    'select' => '<select name="{{name}}" {{attrs}}>{{content}}</select>',
]);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Controles de Calidad - Sardina Artesanal</span>
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
                            <?php if(array_in_array(['calidad_artesanal_add'], $current_user['privilegios'])): ?>
                            <a id="new-control" href="javascript:newEntity('AGREGAR CONTROL DE CALIDAD', '/controles_calidad/add/', newControlOptions);" class="btn btn-default">
                                Agregar Control de Calidad
                            </a>
                            <?php else: ?>
                            <a id="new-control" class="btn btn-default" disabled="disabled">
                                Agregar Control de Calidad
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 col-sm-6">
                          <div class="input-group input-group-xs input-small pull-right">
                            <span class="input-group-addon">Año</span>
                            <?= $this->Form->input('guias-year', ['options' => $years, 'class' => 'input-xs form-control']) ?>
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control" id="ver-guias-controladas">
                                    <span class="text">Ver Guias con Control de Calidad</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered" id="controles_calidad-table">
                    <thead>
                        <tr>
                            <th>Nave</th>
                            <th>Nro Guia</th>
                            <th>Origen</th>
                            <th>Fecha Salida</th>
                            <th>Destino</th>
                            <th>Fecha Recepción</th>
                            <th>Camión</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->append('jquery') ?>
<script>
$(document).ready(function () {
$('#guias-year').select2();
controlesCalidadEstado = 'SIN CALIDAD';

$('#guias-year').on('change', function() {
  console.debug('Se realiza un cambio de año');
  $('#controles_calidad-table').dataTable().DataTable().ajax.url('/api/controles_calidad/' + $(this).val() + '/' + controlesCalidadEstado).load();
});

$('#ver-guias-controladas').change(function() {
    var actionbuttons = $('#controles_calidad-table').parents('.dataTables_wrapper').find('.action-buttons');

    $('#controles_calidad-table').data('selected', null);

    if ($(this).is(':checked')) {
        $('#controles_calidad-table').DataTable().ajax.url('/api/controles_calidad/' + $('#guias-year').val() + '/CONTROLADO').load();
        $('#new-control').hide();
        actionbuttons.find('#details-btn').show();
        actionbuttons.find('#edit-btn').show();
        actionbuttons.find('#delete-btn').show();
    } else {
        $('#controles_calidad-table').DataTable().ajax.url('/api/controles_calidad/' + $('#guias-year').val() + '/SIN CALIDAD').load();

        $('#new-control').show();
        actionbuttons.find('#details-btn').hide();
        actionbuttons.find('#edit-btn').hide();
        actionbuttons.find('#delete-btn').hide();
    }
});

options = {
  "processing": true,
  "serverSide": true,
  "ajax": {
    url: '/api/controles_calidad/' + $('#guias-year').val(),
    type: 'post'
  },
  loadUrl: '/api/controles_calidad',
  actionButtons: <?php if (true||array_in_array(['calidad_artesanal_edit'], $current_user['privilegios'])): ?>
  '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Guia\', \'/controles_calidad/edit/\', editControlOptions )" style="display:none;"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php else:?>
  '<button id="edit-btn" class="btn" style="display:none;" disabled><i class="fa fa-edit"></i> Editar</button> ' +
  <?php endif; ?>
  <?php if (array_in_array(['calidad_artesanal_delete'], $current_user['privilegios'])): ?>
  '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/controles_calidad/delete/\', $(\'#controles_calidad-table\'), deleteControlOptions)" style="display:none;"><i class="fa fa-trash-o"></i> Borrar</button>'
  <?php else: ?>
  '<button id="delete-btn" class="btn" style="display:none;" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
  <?php endif; ?>,
  dataColumns: [{
      "data": function(row) {
        var naves = []
        $.each(row.guia_detalles, function(i, e) {
          naves.pushIfNotExist(e.descarga_detalle.descarga_encabezado.recalada.marea.nave.nombre);
        });
        return naves.join('<br/>');
      }
  }, {
      "data": "nro_guia"
  }, {
      "data": "origen.nombre"
  }, {
      "data": {
        "_": function(row) {
          return row?moment(row.fecha_salida).format('DD-MMM-YYYY HH:mm'):null;
        },
        "sort": "fecha_salida"
    }
  }, {
      "data": "destino.nombre"
  }, {
      "data": {
        "_": function(row) {
          return row?moment(row.fecha_recepcion).format('DD-MMM-YYYY HH:mm'):'NO RECIBIDO';
      },
      "sort": "fecha_recepcion"
    }
  }, {
      "data": function(row) {
          return row.virtual == 0 ? row.camion.patente : 'VIRTUAL';
      }
  }, {
      "data": function(row) {
          return row.control_calidad ? 'CONTROLADO' : 'SIN CALIDAD';
      }
  }],
  rowCallback: function(nRow, aData, iDisplayIndex) {
      $('td:eq(3)', nRow).data("fecha", aData.fecha_salida);
      $('td:eq(5)', nRow).data("fecha", aData.fecha_recepcion);

      return nRow;
  }
}

dataTableEntityInit($('#controles_calidad-table'), options);

newControlOptions = {
    oTable: $('#controles_calidad-table'),
    sTableReloadPage: '/api/controles_calidad/',
    fnPreCreate: function() {
        if (!$('#controles_calidad-table').data('selected')) {
            warningNotify('Debe seleccionar una guia primero.');
            return false;
        }
        return true;
    },
    fnCreateCallback: function($message) {
        $('form', $message).append('<input type="hidden" value="' + $('#controles_calidad-table').data('selected') + '" name="guia_encabezado_id" id="guia-encabezado-id">');
    },
}
editControlOptions = {
    elementId: function() {
        var control_id = null;
        var $row = $('#controles_calidad-table tbody .selected');
        var rowData = $('#controles_calidad-table').DataTable().row($row).data();
        if (rowData)
            control_id = rowData.control_calidad.id;
        return control_id;
    },
    oTable: $('#controles_calidad-table'),
    sTableReloadPage: '/api/controles_calidad/',
    fnPreCreate: function() {
        if (!$('#controles_calidad-table').data('selected')) {
            warningNotify('Debe seleccionar una guia primero.');
            return false;
        }
        return true;
    }
}

detailControlOptions = {
    elementId: function() {
        var control_id = null;
        var $row = $('#controles_calidad-table tbody .selected');
        var rowData = $('#controles_calidad-table').DataTable().row($row).data();
        if (rowData)
            control_id = rowData.control_calidad.id;
        return control_id;
    }
}

deleteControlOptions = {
    elementId: function() {
        var control_id = null;
        var $row = $('#controles_calidad-table tbody .selected');
        var rowData = $('#controles_calidad-table').DataTable().row($row).data();
        if (rowData)
            control_id = rowData.control_calidad.id;
        return control_id;
    }
}
});
</script>
<?= $this->end() ?>
