<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Movimientos');
$this->Html->addCrumb('Administración');
$this->Html->addCrumb('Matención');
$this->Html->addCrumb('Movimientos');
?>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Movimientos</span>
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
              <?php if(array_in_array(['admin_movimiento_add'], $current_user['privilegios'])): ?>
              <button id="new-button" onclick="javascript:newEntity('Nuevo Movimiento', '/movimientos/add', newTipoDescargaOptions);" class="btn btn-default">
                Nuevo Movimiento
              </button>
              <?php else: ?>
                <button id="new-button" class="btn btn-default" disabled="disabled">
                  Nuevo Movimiento
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-movimientos-inactivos">
                  <span class="text"><?= __('View inactive {0}', __('Movimientos'))?></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table class="table table-hover table-striped table-bordered" id="movimientos-table">
            <thead>
              <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Tipo')?></th>
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
  $('#ver-movimientos-inactivos').on('change', function() {
    $('#movimientos-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#movimientos-table').DataTable().ajax.url( '/api/movimientos/INACTIVO').load();
    } else {
      $('#movimientos-table').DataTable().ajax.url( '/api/movimientos').load();
    }
  });
newTipoDescargaOptions = {
  oTable: $('#movimientos-table'),
  sTableReloadPage: '/api/movimientos/'
}

editTipoDescargaOptions = {
  oTable: $('#movimientos-table'),
  sTableReloadPage: '/api/movimientos/'
}

options = {
  loadUrl: '/api/movimientos/',
  actionButtons:
  <?php if(array_in_array(['admin_movimiento_edit'], $current_user['privilegios'])): ?>
  '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Movimiento\', \'/movimientos/edit/\', editTipoDescargaOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php else: ?>
  '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php endif; ?>
  <?php if(array_in_array(['admin_movimiento_delete'], $current_user['privilegios'])): ?>
  '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/movimientos/delete/\', $(\'#movimientos-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php else: ?>
  '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php endif; ?>
  dataColumns: [
    {"data": "id"},
    {"data": "nombre"},
    {"data": function(row) {return row.tipo == 1?'1 - ENTRADA':'2 - SALIDA';}},
    {
        "data": function (row) {
            return row.estado.nombre + ' - ' + row.estado.id;
        }
    },
  ]
};

dataTableEntityInit($('#movimientos-table'), options)
});
</script>
<?= $this->end() ?>
