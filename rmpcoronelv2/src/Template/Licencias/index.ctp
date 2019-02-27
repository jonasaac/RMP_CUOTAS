<?php
$this->extend('/Common/view');
$this->assign('title', 'Administración Licencias de Pesca');
$this->Html->addCrumb('Control Cuotas', ['controller' => 'Home', 'action' => 'index', '#' => 'cuotas']);
$this->Html->addCrumb('Administración Licencias de Pesca');
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
      <span class="widget-caption">Licencias de Pesca</span>
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
          <div class="col-md-6 col-sm-6">
            <?php if (array_in_array(['cuotas_licencia_add'], $current_user['privilegios'])): ?>
            <button id="new-licencia" onclick="javascript:newEntity('Nueva Licencia', '/licencias/add/', newLicenciaOptions);" class="btn btn-default pull-left">
              Nueva Licencia
            </button>
            <?php else: ?>
            <button id="new-licencia" onclick="javascript:;" class="btn btn-default" disabled="disabled">
              Nueva Licencia
            </button>
            <?php endif; ?>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="form-group">
              <input hidden="year[]" value="">
              <select name="year[]" id="year-select" class="input-xs form-control" data-placeholder="Año (Ninguno)" lang="es" style="width:100%;" multiple="multiple">
                <?php foreach($years as $year): ?>
                  <option value="<?=$year?>" selected="selected"><?=$year?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="form-group">
              <select name="especie" id="especie-select" class="input-xs form-control" data-placeholder="Especie (Todas)" lang="es" style="width:100%;">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-45">
          <div class="row">
          <div class="col-sm-12">
            <legend>Licencias Activas</legend>
          </div>
          <div class="col-sm-12">
            <table class="table table-striped table-hover table-bordered" id="licencias-activas-table">
              <thead>
                <tr role="row">
                  <th>id</th>
                  <th>Resolución</th>
                  <th class="hidden-sm">Porcentaje</th>
                  <th>Disponible</th>
                  <th>Adjunto</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
        <div class="col-md-1 hidden-sm hidden-xs" style="height:430px; padding-top:200px">
          <button class="btn delete-detalle" id="activar-licencia-btn" title="Activar Licencia"><i class="fa fa-chevron-left"></i></button>
          <button class="btn add-detalle" id="desactivar-licencia-btn" title="Desactivar Licencia"><i class="fa fa-chevron-right"></i></button>
        </div>
        <div class="col-md-1 hidden-lg hidden-md centered" style="padding-top: 10px; padding-bottom: 10px">
          <button class="btn add-detalle" id="activar-licencia-btn" title="Activar Licencia"><i class="fa fa-chevron-down"></i></button>
          <button class="btn delete-detalle" id="desactivar-licencia-btn" title="Desactivar Licencia"><i class="fa fa-chevron-up"></i></button>
        </div>
        <div class="col-md-45">
          <div class="row">
          <div class="col-sm-12">
            <legend>Licencias Inactivas</legend>
          </div>
          <div class="col-sm-12">
            <table class="table table-striped table-hover table-bordered" id="licencias-inactivas-table">
              <thead>
                <tr role="row">
                  <th>id</th>
                  <th>Resolución</th>
                  <th class="hidden-sm">Porcentaje</th>
                  <th>Disponible</th>
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
      allowClear: true,
    });
  })
  $('#especie-select').select2();
  $('#year-select').select2();

  $('#especie-select').on('change', function() {
    var especie_query = '';
    if ($('#especie-select').val()) {
      especie_query = '&especie=' + $('#especie-select').val();
    }
    $('#licencias-activas-table').dataTable().DataTable().ajax.url('/api/licencias.json?cantidad_disponible=1&reload=true&estado=activo&year=' + $('#year-select').val() + especie_query).load().draw( false );
    $('#licencias-inactivas-table').dataTable().DataTable().ajax.url('/api/licencias.json?cantidad_disponible=1&reload=true&estado=inactivo&year=' + $('#year-select').val() + especie_query).load().draw( false );
  });

  $('#year-select').on('change', function() {
    var especie_query = '';
    if ($('#especie-select').val()) {
      especie_query = '&especie=' + $('#especie-select').val();
    }
    $('#licencias-activas-table').dataTable().DataTable().ajax.url('/api/licencias.json?cantidad_disponible=1&reload=true&estado=activo&year=' + $('#year-select').val() + especie_query).load().draw( false );
    $('#licencias-inactivas-table').dataTable().DataTable().ajax.url('/api/licencias.json?cantidad_disponible=1&reload=true&estado=inactivo&year=' + $('#year-select').val() + especie_query).load().draw( false );
  });

  /*******************************************************
  *  -- LICENCIAS --
  ********************************************************/
  newLicenciaOptions = {
      oTable: $('#licencias-activas-table'),
      sTableReloadPage: function() {
        var especie_query = '';
        if ($('#especie-id').val()) {
          especie_query = '&especie=' + $('#especie-id').val();
        }
        return '/api/licencias.json?cantidad_disponible=1&reload=true&estado=activo&year=' + $('#year-select').val() + especie_query;
      }
  };
  editLicenciaActivasOptions = {
      oTable: $('#licencias-activas-table'),
      sTableReloadPage: function() {
        var especie_query = '';
        if ($('#especie-id').val()) {
          especie_query = '&especie=' + $('#especie-id').val();
        }
        return '/api/licencias.json?cantidad_disponible=1&reload=true&estado=activo&year=' + $('#year-select').val() + especie_query;
      }
  };
  editLicenciaInactivaOptions = {
      oTable: $('#licencias-inactivas-table'),
      sTableReloadPage: function() {
        var especie_query = '';
        if ($('#especie-id').val()) {
          especie_query = '&especie=' + $('#especie-id').val();
        }
        return '/api/licencias.json?cantidad_disponible=1&reload=true&estado=inactivo&year=' + $('#year-select').val() + especie_query;
      }
  };

  licenciasActivasOptions = {
    "processing": true,
    ajax: {
      'url': function() {
        var especie_query = '';
        if ($('#especie-id').val()) {
          especie_query = '&especie=' + $('#especie-id').val();
        }
        return '/api/licencias.json?cantidad_disponible=1&estado=activo&year=' + $('#year-select').val() + especie_query;
      }(),
      'type': 'GET',
      'dataType': 'json',
      'dataSrc': 'licencias'
    },
    actionButtons:
    <?php if (array_in_array(['cuotas_licencia_edit'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:editEntity(\'Editar Licencia\', \'/licencias/edit/\', editLicenciaActivasOptions);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['cuotas_licencia_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteEntity(\'/licencias/delete/\', $(\'#licencias-activas-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "name": "Licencias.id",
        "data": "id"
      }, {
        "name": "Licencias.resolucion",
        "data": "display_name"
      }, {
        "name": "Licencias.porcentaje",
        "class": "text-right hidden-sm",
        "data": function(row) {return toggleNumberFormat(row.porcentaje);}
      }, {
        "name": "Licencias.disponible",
        "class": "text-right",
        "data": function(row) {
          if (row.vencido) {
            return '-';
          }
          return toggleNumberFormat(row.cantidad_disponible);
        }
      }, {
        "class": "centered",
        "data": function(row) {return row.adjunto?'<a href="/uploads/'+row.adjunto+'" class="btn" title="Descargar documento adjunto"><i class="fa fa-download"></i></a>':'<button disabled="disabled" class="btn btn-disabled" title="Documento adjunto no disponible"><i class="fa fa-download"></i></button>';}
      }
    ],
    rowCallback: function (row, data, dataindex) {
      if (data.vencido) {
        $(row).addClass('danger');
      }
    }
  };

  licenciasInactivasOptions = {
    "processing": true,
    ajax: {
      'url': function() {
        var especie_query = '';
        if ($('#especie-id').val()) {
          especie_query = '&especie=' + $('#especie-id').val();
        }
        return '/api/licencias.json?cantidad_disponible=1&estado=inactivo&year=' + $('#year-select').val() + especie_query;
      }(),
      'type': 'GET',
      'dataType': 'json',
      'dataSrc': 'licencias'
    },
    actionButtons:
    <?php if (array_in_array(['cuotas_licencia_edit'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:editEntity(\'Editar Licencia\', \'/licencias/edit/\', editLicenciaInactivaOptions);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['cuotas_licencia_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteEntity(\'/licencias/delete/\', $(\'#licencias-inactivas-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "name": "Licencias.id",
        "data": "id"
      }, {
        "name": "Licencias.resolucion",
        "data": "display_name"
      }, {
        "name": "Licencias.porcentaje",
        "class": "text-right hidden-sm",
        "data": function(row) {return toggleNumberFormat(row.porcentaje);}
      }, {
        "name": "Licencias.disponible",
        "class": "text-right",
        "data": function(row) {
          if (row.vencido) {
            return '-';
          }
          return toggleNumberFormat(row.cantidad_disponible);
        }
      }, {
        "class": "centered",
        "data": function(row) {return row.adjunto?'<a href="/uploads/'+row.adjunto+'" class="btn" title="Descargar documento adjunto"><i class="fa fa-download"></i></a>':'<button disabled="disabled" class="btn btn-disabled" title="Documento adjunto no disponible"><i class="fa fa-download"></i></button>';}
      }
    ],
    rowCallback: function (row, data, dataindex) {
      if (data.vencido) {
        $(row).addClass('danger');
      }
    }
  };

  // Se inicializan las datatables
  dataTableEntityInit($('#licencias-activas-table'), licenciasActivasOptions);
  dataTableEntityInit($('#licencias-inactivas-table'), licenciasInactivasOptions);

  /** Activacion y desactivacion de licencias **/
  $('#activar-licencia-btn').on('click', function() {
      var licenciaId = $('#licencias-inactivas-table').data('selected');
      var $selectedRow = $('#licencias-inactivas-table').find('tr.selected');

      if (!$selectedRow.length) {
          warningNotify("Debe seleccionar una licencia inactiva primero");
          return;
      }
      $.ajax({
          'url': '/licencias/activate/' + licenciaId,
          'type': 'POST',
          'dataType': 'json'
      })
      .done(function (data){
          if (data.status == "success") {
              $('#licencias-activas-table').DataTable().row.add(data.licencia).draw( false );
              $('#licencias-inactivas-table').DataTable().row($selectedRow).remove().draw( false );
          }
      });
  });

  $('#desactivar-licencia-btn').on('click', function() {
     var licenciaId = $('#licencias-activas-table').data('selected');
     var $selectedRow = $('#licencias-activas-table').find('tr.selected');

     if (!$selectedRow.length) {
         warningNotify("Debe seleccionar una licencia activa primero");
         return;
     }
     $.ajax({
         'url': '/licencias/deactivate/' + licenciaId,
         'type': 'POST',
         'dataType': 'json'
     })
     .done(function (data){
         if (data.status == "success") {
             $('#licencias-inactivas-table').DataTable().row.add(data.licencia).draw( false );
             $('#licencias-activas-table').DataTable().row($selectedRow).remove().draw( false );
         }
     });
  });

});
</script>
<?= $this->end() ?>
