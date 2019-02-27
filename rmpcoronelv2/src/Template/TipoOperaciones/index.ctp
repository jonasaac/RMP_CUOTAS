<?php
$this->extend('/Common/view');
$this->assign('title', 'Administración Tipos de Operaciones');
$this->Html->addCrumb('Administración', ['controller' => 'Home', 'action' => 'index', '#' => 'admin']);
$this->Html->addCrumb('Mantención');
$this->Html->addCrumb('Tipos de Operaciones');
?>
<div class="col-lg-12">
  <div class="widget">
    <div class="widget-header">
      <span class="widget-caption">Tipos de Operaciones</span>
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
            <?php if (array_in_array(['admin_tipoOperacion_add'], $current_user['privilegios'])): ?>
            <button id="new-decreto" onclick="javascript:newEntity('Nuevo Tipo Operacion', '/tipo_operaciones/add/', newTipoOperacionOptions);" class="btn btn-default pull-left">
              Nuevo Tipo Operacion
            </button>
            <?php else: ?>
            <button id="new-decreto" onclick="javascript:;" class="btn btn-default" disabled="disabled">
              Nuevo Tipo Operacion
            </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered" id="tipo-operaciones-table">
              <thead>
                <tr role="row">
                  <th>id</th>
                  <th>Nombre</th>
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
$(document).ready(function () {
    newTipoOperacionOptions = {
        oTable: $('#tipo-operaciones-table'),
        sTableReloadPage: '/api/tipooperaciones.json'
    }

    editTipoOperacionOptions = {
        oTable: $('#tipo-operaciones-table'),
        sTableReloadPage: '/api/tipo_operaciones.json'
    }

options = {
    "processing": true,
    ajax: {
      'url': '/api/tipo_operaciones.json?estado=activo',
      'type': 'GET',
      'dataType': 'json',
      'dataSrc': 'tipo_operaciones'
    },
  actionButtons:
  <?php if(array_in_array(['admin_tipoOperacion_edit'], $current_user['privilegios'])): ?>
  '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Tipo Descarga\', \'/tipo_operaciones/edit/\', editTipoOperacionOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php else: ?>
  '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php endif; ?>
  <?php if(array_in_array(['admin_tipoOperacion_delete'], $current_user['privilegios'])): ?>
  '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/tipo_operaciones/delete/\', $(\'#tipo-operaciones-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php else: ?>
  '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php endif; ?>
  dataColumns: [
    {"data": "id"},
    {"data": "nombre"}
  ]
};

dataTableEntityInit($('#tipo-operaciones-table'), options);
return;
});
</script>
<?= $this->end() ?>
