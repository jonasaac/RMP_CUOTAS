<?php
$this->extend('/Common/view');
$this->assign('title', 'Administración Decretos de Pesca');
$this->Html->addCrumb('Control Cuotas', ['controller' => 'Home', 'action' => 'index', '#' => 'cuotas']);
$this->Html->addCrumb('Administración Decretos de Pesca');
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
      <span class="widget-caption">Decretos de Pesca</span>
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
            <?php if (array_in_array(['cuotas_decreto_add'], $current_user['privilegios'])): ?>
            <button id="new-decreto" onclick="javascript:newEntity('Nueva Decreto', '/decretos/add/', newDecretoOptions);" class="btn btn-default pull-left">
              Nuevo Decreto
            </button>
            <?php else: ?>
            <button id="new-decreto" onclick="javascript:;" class="btn btn-default" disabled="disabled">
              Nuevo Decreto
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
                <input type="checkbox" id="ver-decretos-historicas" class="form-control">
                <span class="text">Ver Historico</span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered" id="decretos-table">
              <thead>
                <tr role="row">
                  <th>id</th>
                  <th>Resolución</th>
                  <th>Fecha Promulgación</th>
                  <th>Fecha Inicio Vigencia</th>
                  <th>Total Cuota</th>
                  <th>Adjunto</th>
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
    $('#decretos-table').dataTable().DataTable().ajax.url('/api/decretos.json?reload=true&estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val()).load();
  });

  $('#year-select').on('change', function() {
      $('#decretos-table').dataTable().DataTable().ajax.url('/api/decretos.json?reload=true&estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val()).load();
  });

  /*******************************************************
  *  -- DECRETOS --
  ********************************************************/
  newDecretoOptions = {
      oTable: $('#decretos-table'),
      sTableReloadPage: function() {
        return '/api/decretos.json?estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val();
      }
  };
  editDecretoOptions = {
      oTable: $('#decretos-table'),
      sTableReloadPage: function() {
        return '/api/decretos.json?estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-select').val();
      }
  };

  decretosActivasOptions = {
    "processing": true,
    ajax: {
      'url': '/api/decretos.json?estado=activo&year=' + $('#year-select').val() + '&especie=' + $('#especie-id').val(),
      'type': 'GET',
      'dataType': 'json',
      'dataSrc': 'decretos'
    },
    actionButtons:
    <?php if (array_in_array(['cuotas_decreto_edit'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:editEntity(\'Editar Decreto\', \'/decretos/edit/\', editDecretoOptions);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['cuotas_decreto_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteEntity(\'/decretos/delete/\', $(\'#decretos-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "name": "Decretos.id",
        "data": "id"
      }, {
        "name": "Decretos.resolucion",
        "data": "codigo_resolucion"
      }, {
        "name": "Decretos.fecha_promulgacion",
        "data": function(row) {return moment.utc(row.fecha_promulgacion).format('DD-MMM-YYYY');}
      }, {
        "name": "Decretos.fecha_inicio_vigencia",
        "data": function(row) {return moment.utc(row.fecha_inicio_vigencia).format('DD-MMM-YYYY');}
      }, {
        "name": "Decretos.total_cuota",
        "data": function (row) {return toggleNumberFormat(row.total_cuota);}
      }, {
        "name": "Decretos.adjunto",
        "class": "centered",
        "data": function(row) {return row.adjunto?'<a href="/uploads/'+row.adjunto+'" class="btn"><i class="fa fa-download"></i></a>':'<button disabled="disabled" class="btn btn-disabled"><i class="fa fa-download"></i></button>';}
      }
    ]
  };

  newResolucionDerechoOptions = {
    oTable: $('#decretos-table'),
    sTableReloadPage: function() {
      return '/api/decretos/' + $('#decretos-year').val();
    }
  };

  // Se inicializan las datatables
  dataTableEntityInit($('#decretos-table'), decretosActivasOptions);

});
</script>
<?= $this->end() ?>
