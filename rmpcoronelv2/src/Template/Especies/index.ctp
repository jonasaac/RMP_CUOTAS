<?php
$this->extend('/Common/view');
$this->assign('title', 'Especies');
$this->Html->addCrumb('Especies');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Especies</span>
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
                          <?php if(array_in_array(['admin_especie_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nueva Especie', '/especies/add', newEspecieOptions);" class="btn btn-default">
                                Nueva Especie
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nueva Especie
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input id="ver-especies-inactivas" type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Especies'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="especies-table">
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
  $('#ver-especies-inactivas').on('change', function() {
    $('#especies-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#especies-table').DataTable().ajax.url( '/api/especies/INACTIVO').load();
    } else {
      $('#especies-table').DataTable().ajax.url( '/api/especies').load();
    }
  });

newEspecieOptions = {
oTable: $('#especies-table'),
sTableReloadPage: '/api/especies/'
}

editEspecieOptions = {
oTable: $('#especies-table'),
sTableReloadPage: '/api/especies/'
}

options = {
//loadUrl: '/api/especies/',
ajax : {
    url : '/api/especies.json',
    dataSrc : 'especies'
},
actionButtons:
<?php if(array_in_array(['admin_especie_edit'], $current_user['privilegios'])): ?>
'<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Especie\', \'/especies/edit/\', editEspecieOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
<?php else: ?>
'<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
<?php endif; ?>
<?php if(array_in_array(['admin_especie_delete'], $current_user['privilegios'])): ?>
'<button id="delete-btn" class="btn" onclick="deleteEntity(\'/especies/delete/\', $(\'#especies-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
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

dataTableEntityInit($('#especies-table'), options);
});
</script>
<?= $this->end() ?>
