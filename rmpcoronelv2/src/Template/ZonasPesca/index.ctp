<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Zonas de Pesca');
$this->Html->addCrumb('Mantenedores', ['controller' => 'Home', 'action' => 'index', '#' => 'mantencion']);
$this->Html->addCrumb('Zonas de Pesca');
?>
<?php
$this->Form->templates([
  'formGroup' => '{{input}}',
  'select' => '<select name="{{name}}" {{attrs}}>{{content}}</select>',
]);
?>
<div class="row">
  <div class="col-lg-6">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Macro Zonas</span>
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
            <!-- TODO divisiones -->
            <div class="col-md-8 col-sm-6">
              <?php if (array_in_array(['admin_zona_add'], $current_user['privilegios'])): ?>
                <button id="new-macro-zona" onclick="javascript:newEntity('Nueva Macro Zona', '/macro_zonas/add/', newMacroZonaOptions);" class="btn btn-default">
                  Nueva Macro Zona
                </button>
              <?php else: ?>
                <button id="new-macro-zona" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                  Nueva Macro Zona
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-macro-zonas-inactivas">
                  <span class="text">Ver Macro Zonas Inactivas</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="macro-zonas-table">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>Zonas de Pesca</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Zonas de Pesca</span>
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
            <!-- TODO divisiones -->
            <div class="col-md-8 col-sm-6">
              <?php if (array_in_array(['admin_zona_add'], $current_user['privilegios'])): ?>
                <button id="new-zona-pesca" onclick="javascript:newEntity('Nueva Zona de Pesca', '/zonas_pesca/add/', newZonaPescaOptions);" class="btn btn-default">
                  Nueva Zona de Pesca
                </button>
              <?php else: ?>
                <button id="new-zona-pesca" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                  Nueva Zona de Pesca
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-zonas-pesca-inactivas">
                  <span class="text">Ver Zonas de Pesca Inactivas</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="zonas-pesca-table">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>Macro Zonas</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->start('jquery'); ?>
<script>
$(document).ready(function() {
    // MACRO ZONAS
    macro_zonas_estado = 1;
    $('#ver-macro-zonas-inactivas').on('change', function() {
        if ($(this).is(':checked')) {
            $('#new-macro-zona').hide();
            macro_zonas_estado = 2;
        } else {
            macro_zonas_estado = 1;
            $('#new-macro-zona').show();
        }
        $('#macro-zonas-table').DataTable().ajax.url('/api/macro_zonas.json?estado=' + macro_zonas_estado).load();
    });

    newMacroZonaOptions = {
        oTable: $('#macro-zonas-table'),
        sTableReloadPage: function() {
          return '/api/macro_zonas.json?estado=' + macro_zonas_estado;
        }
    };

    editMacroZonaOptions = {
        oTable: $('#macro-zonas-table'),
        sTableReloadPage: function() {
          return '/api/macro_zonas.json?estado=' + macro_zonas_estado;
        }
    };

    macroZonasOptions = {
      ajax: {
          "url": '/api/macro_zonas.json?estado=' + macro_zonas_estado,
          "dataSrc": "macro_zonas"
      },
      actionButtons:
      <?php if (array_in_array(['admin_zona_edit'], $current_user['privilegios'])): ?>
      '<button onclick="javascript:editEntity(\'Editar Macro Zona\', \'/macro_zonas/edit/\', editMacroZonaOptions);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
      <?php else: ?>
      '<button id="edit-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
      <?php endif; ?>
      <?php if (array_in_array(['admin_zona_delete'], $current_user['privilegios'])): ?>
      '<button onclick="deleteEntity(\'/macro_zonas/delete/\', $(\'#macro-zonas-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
      <?php else: ?>
      '<button id="delete-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>'
      <?php endif; ?>,
      dataColumns: [{
        "data": "id"
      }, {
        "data": "nombre"
      }, {
          "data": function(data) {var result = ""; $.each(data.zonas_pesca, function(i,v){result += "["+v.nombre+"] "}); return result;}
      }],
      selectCallback: function(id, row) {
        if (!id) {
          row.removeClass('selected');
        }
      }
    }

    // ZONAS DE PESCA
    zonas_pesca_estado = 1;
    $('#ver-zonas-pesca-inactivas').on('change', function() {
        if ($(this).is(':checked')) {
            $('#new-zona-pesca').hide();
            zonas_pesca_estado = 2;
        } else {
            zonas_pesca_estado = 1;
            $('#new-zona-pesca').show();
        }
        $('#zonas-pesca-table').DataTable().ajax.url('/api/zonas_pesca.json?estado=' + zonas_pesca_estado).load();
    });

    newZonaPescaOptions = {
        oTable: $('#zonas-pesca-table'),
        sTableReloadPage: function() {
          return '/api/zonas_pesca.json?estado=' + zonas_pesca_estado;
        }
    };

    editZonaPescaOptions = {
        oTable: $('#zonas-pesca-table'),
        sTableReloadPage: function() {
            return '/api/zonas_pesca.json?estado=' + zonas_pesca_estado;
        }
    };

    zonasPescaOptions = {
      ajax: {
          "url": '/api/zonas_pesca.json?estado=' + zonas_pesca_estado,
          "dataSrc": "zonas_pesca"
      },
      actionButtons:
      <?php if (array_in_array(['admin_zona_edit'], $current_user['privilegios'])): ?>
      '<button onclick="javascript:editEntity(\'Editar Zona de Pesca\', \'/zonas_pesca/edit/\', editZonaPescaOptions);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
      <?php else: ?>
      '<button id="edit-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
      <?php endif; ?>
      <?php if (array_in_array(['admin_zona_delete'], $current_user['privilegios'])): ?>
      '<button onclick="deleteEntity(\'/zonas_pesca/delete/\', $(\'#zonas-pesca-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
      <?php else: ?>
      '<button id="delete-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>'
      <?php endif; ?>,
      dataColumns: [{
        "data": "id"
      }, {
        "data": "nombre"
      }, {
        "data": function(data) {var result = ""; $.each(data.macro_zonas, function(i,v){result += "["+v.nombre+"] "}); return result;}
      }],
      selectCallback: function(id, row) {
        if (!id) {
          row.removeClass('selected');
        }
      }
    }

    // Se inicializan las datatables
    dataTableEntityInit($('#macro-zonas-table'), macroZonasOptions);
    dataTableEntityInit($('#zonas-pesca-table'), zonasPescaOptions);
});
</script>
<?php $this->end(); ?>
