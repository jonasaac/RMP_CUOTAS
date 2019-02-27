<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor de Areas');
$this->Html->addCrumb('Administración', ['controller' => 'Home', 'action' => 'index', '#' => 'administracion']);
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Areas');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Areas</span>
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
                          <?php if(array_in_array(['admin_usuario_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nueva Area', '/areas/add', newAreaOptions);" class="btn btn-default">
                                Nueva Area
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                                Nueva Area
                            </button>
                          <?php endif;?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control" id="ver-inactivos">
                                    <span class="text"><?= __('View inactive {0}', __('Areas'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="areas-table">
                        <thead>
                            <tr>
                                <th><?= __('id') ?></th>
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
// Se cargan las datos correspondientes según se ha seleccionado en el checkbox
// Estados de tablas
areasEstado = 'ACTIVO';

$('#ver-inactivos').change(function() {
  var actionbuttons = $('#areas-table').parents('.dataTables_wrapper').find('.action-buttons');

  if ($(this).is(':checked')) {
    areasEstado = 'INACTIVO'
    $('#new-area').hide();
  } else {
    areasEstado = 'ACTIVO'
    $('#new-area').show();
  }

  $('#areas-table').DataTable().ajax.url('/api/areas/' + areasEstado).load();
});

newAreaOptions = {
oTable: $('#areas-table'),
sTableReloadPage: '/api/areas/' + areasEstado
}

editAreaOptions = {
oTable: $('#areas-table'),
sTableReloadPage: '/api/areas/' + areasEstado
}

options = {
loadUrl: '/api/areas/' + areasEstado,
actionButtons:
<?php if(array_in_array(['admin_usuario_edit'], $current_user['privilegios'])): ?>
  '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Area\', \'/areas/edit/\', editAreaOptions )"><i class="fa fa-edit"></i> Editar</button> '+
<?php else: ?>
  '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> '+
<?php endif; ?>
<?php if(array_in_array(['admin_usuario_delete'], $current_user['privilegios'])): ?>
'<button id="delete-btn" class="btn" onclick="deleteEntity(\'/areas/delete/\', $(\'#areas-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
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

dataTableEntityInit($('#areas-table'), options)
</script>
<?= $this->end(); ?>
