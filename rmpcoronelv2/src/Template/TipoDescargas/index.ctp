<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Tipo Descargas');
$this->Html->addCrumb('Administración');
$this->Html->addCrumb('Matención');
$this->Html->addCrumb('Tipo Descargas');
?>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Tipo Descargas</span>
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
            <div class="col-sm-6">
              <?php if(array_in_array(['admin_tipoDescarga_add'], $current_user['privilegios'])): ?>
              <button id="new-button" onclick="javascript:newEntity('Nuevo Tipo Descarga', '/tipo_descargas/add', newTipoDescargaOptions);" class="btn btn-default">
                Nuevo Tipo Descarga
              </button>
              <?php else: ?>
                <button id="new-button" class="btn btn-default" disabled="disabled">
                  Nuevo Tipo Descarga
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-tipodescargas-inactivos">
                  <span class="text"><?= __('View inactive {0}', __('Tipo Descargas'))?></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table class="table table-hover table-striped table-bordered" id="tipodescargas-table">
            <thead>
              <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Estado') ?></th>
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
$(document).ready(function () {
  $('#ver-tipodescargas-inactivos').on('change', function() {
    $('#tipodescargas-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#tipodescargas-table').DataTable().ajax.url( '/api/tipodescargas/INACTIVO').load();
    } else {
      $('#tipodescargas-table').DataTable().ajax.url( '/api/tipodescargas').load();
    }
  });
newTipoDescargaOptions = {
  oTable: $('#tipodescargas-table'),
  sTableReloadPage: '/api/tipodescargas/'
}

editTipoDescargaOptions = {
  oTable: $('#tipodescargas-table'),
  sTableReloadPage: '/api/tipodescargas/'
}

options = {
  loadUrl: '/api/tipodescargas/',
  actionButtons:
  <?php if(array_in_array(['admin_tipoDescarga_edit'], $current_user['privilegios'])): ?>
  '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Tipo Descarga\', \'/tipo_descargas/edit/\', editTipoDescargaOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php else: ?>
  '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php endif; ?>
  <?php if(array_in_array(['admin_tipoDescarga_delete'], $current_user['privilegios'])): ?>
  '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/tipo_descargas/delete/\', $(\'#tipodescargas-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php else: ?>
  '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php endif; ?>
  dataColumns: [
    {"data": "id"},
    {"data": "nombre"},
    {
        "data": function (row) {
            return row.estado.nombre + ' - ' + row.estado.id;
        }
    },
  ]
};

dataTableEntityInit($('#tipodescargas-table'), options)
});
</script>
<?= $this->end() ?>
