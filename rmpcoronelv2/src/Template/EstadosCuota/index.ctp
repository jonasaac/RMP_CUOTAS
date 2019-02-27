<?php
$this->extend('/Common/view');
$this->assign('title', 'Administración Estados Cuota de Pesca');
$this->Html->addCrumb('Control Cuotas', ['controller' => 'Home', 'action' => 'index', '#' => 'cuotas']);
$this->Html->addCrumb('Administración Estados Cuota de Pesca');
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
      <span class="widget-caption">Estados Cuota de Pesca</span>
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
            <?php if (array_in_array(['cuotas_estado_add'], $current_user['privilegios'])): ?>
            <button id="new-decreto" onclick="javascript:newEntity('Nueva Estado Cuota', '/estados_cuota/add/', newEstadoCuotaOptions);" class="btn btn-default pull-left">
              Nuevo Estado Cuota
            </button>
            <?php else: ?>
            <button id="new-decreto" onclick="javascript:;" class="btn btn-default" disabled="disabled">
              Nuevo Estado Cuota
            </button>
            <?php endif; ?>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-group input-small pull-right">
              <select name="especie" id="especie-select" class="input-xs form-control" data-placeholder="Especie" lang="es">
                <option value=""></option>
              </select>
            </div>
            <div class="form-group input-small pull-right">
              <select name="year" id="year-select" class="input-xs form-control" data-placeholder="Año" lang="es">
                  <?php foreach($years as $year): ?>
                      <option value="<?=$year?>"><?=$year?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="checkbox pull-right">
              <label>
                <input type="checkbox" id="ver-estados-cuota-historicas" class="form-control">
                <span class="text">Ver Historico</span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered" id="estados-cuota-table">
              <thead>
                <tr role="row">
                  <th>id</th>
                  <th>Especie</th>
                  <th>Macro Zona</th>
                  <th>Fecha Estado</th>
                  <th>Cantidad</th>
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

<?= $this->append('jquery') ?>
<script>
$(document).ready(function() {
  // Se crean los select2
  especies = [];
  $.ajax({
    url: '/api/especies.json',
    dataType: 'json',
    type: 'GET'
  }).done(function(data) {
    $.each(data.especies, function(i, val) {
      especies.push({id: val.id, text: val.nombre});
    });
    $('#especie-select').select2({
        data: especies,
        allowClear: true
    });
  })
  $('#especie-select').select2();
  $('#year-select').select2();


  $('#especie-select').on('change', function() {
    $('#estados-cuota-table').dataTable().DataTable().ajax.url('/api/estados_cuota.json?reload=true&estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val()).load();
  });

  $('#year-select').on('change', function() {
      $('#estados-cuota-table').dataTable().DataTable().ajax.url('/api/estados_cuota.json?reload=true&estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val()).load();
  });

  /*******************************************************
  *  -- ESTADO CUOTAS --
  ********************************************************/
  newEstadoCuotaOptions = {
      oTable: $('#estados-cuota-table'),
      sTableReloadPage: function() {
        return '/api/estados_cuota.json?estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val();
      }
  };
  editEstadoCuotaOptions = {
      oTable: $('#estados-cuota-table'),
      sTableReloadPage: function() {
        return '/api/estados_cuota.json?estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val();
      }
  };

  estadosCuotaOptions = {
    "processing": true,
    ajax: {
      'url': '/api/estados_cuota.json?estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-id').val(),
      'type': 'GET',
      'dataType': 'json',
      'dataSrc': 'estadosCuota'
    },
    actionButtons:
    <?php if (array_in_array(['cuotas_estado_edit'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:editEntity(\'Editar Estado Cuota\', \'/estados_cuota/edit/\', editEstadoCuotaOptions);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['cuotas_estado_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteEntity(\'/estados_cuota/delete/\', $(\'#estados-cuota-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "name": "EstadosCuota.id",
        "data": "id"
      }, {
        "name": "EstadosCuota.especie",
        "data": function(row) {return row.especie.nombre;}
      }, {
        "name": "EstadosCuota.resolucion",
        "data": function(row) {return row.macro_zona.nombre;}
      }, {
        "name": "EstadosCuota.fecha_estado",
        "data": function(row) {return moment.utc(row.fecha_estado).format('DD-MMM-YYYY');}
      }, {
        "name": "EstadosCuota.Unidades.cantidad",
        "data": function(row) {return toggleNumberFormat(row.unidades[0]._joinData.cantidad);}
      }
    ]
  };

  newEstadosCuotaOptions = {
    oTable: $('#estados-cuota-table'),
    sTableReloadPage: function() {
      return '/api/estados_cuota/' + $('#estados-cuota-year').val();
    }
  };

  // Se inicializan las datatables
  dataTableEntityInit($('#estados-cuota-table'), estadosCuotaOptions);

});
</script>
<?= $this->end() ?>
