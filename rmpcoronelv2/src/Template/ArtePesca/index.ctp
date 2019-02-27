<?php
$this->extend('/Common/view');
$this->assign('title', 'Arte Pesca');
$this->Html->addCrumb('Administración');
$this->Html->addCrumb('Mantención');
$this->Html->addCrumb('Artes de Pesca');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Artes de Pesca</span>
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
                          <?php if(array_in_array(['admin_artePesca_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Arte de Pesca', '/arte_pesca/add', newArte_pescaOptions);" class="btn btn-default">
                                Nuevo Arte de Pesca
                            </button>
                            <?php else: ?>
                              <button id="new-button" class="btn btn-default" disabled="disabled">
                                Nuevo Arte de Pesca
                              </button>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input id="ver-arte_pesca-inactivas" type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Artes de Pesca'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="arte_pesca-table">
                        <thead>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Nombre') ?></th>
                                <th><?= __('Recurso') ?></th>
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
$('#ver-arte_pesca-inactivas').on('change', function() {
$('#arte_pesca-table').data('selected', null);
if($(this).is(':checked')) {
$('#arte_pesca-table').DataTable().ajax.url( '/api/arte_pesca/INACTIVO').load();
} else {
$('#arte_pesca-table').DataTable().ajax.url( '/api/arte_pesca').load();
}
});

newArte_pescaOptions = {
oTable: $('#arte_pesca-table'),
sTableReloadPage: '/api/arte_pesca/'
};

editArte_pescaOptions = {
oTable: $('#arte_pesca-table'),
sTableReloadPage: '/api/arte_pesca/'
};

options = {
loadUrl: '/api/arte_pesca/',
actionButtons:
<?php if(array_in_array(['admin_artePesca_edit'], $current_user['privilegios'])): ?>
'<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Arte_pesca\', \'/arte_pesca/edit/\', editArte_pescaOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
<?php else: ?>
'<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
<?php endif; ?>
<?php if(array_in_array(['admin_artePesca_delete'], $current_user['privilegios'])): ?>
'<button id="delete-btn" class="btn" onclick="deleteEntity(\'/arte_pesca/delete/\', $(\'#arte_pesca-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php else: ?>
'<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php endif; ?>
dataColumns: [
{"data": "id"},
{"data": "nombre"},
{"data": "recurso.nombre"},
{
    "data": function (row) {
        return row.estado.nombre + ' - ' + row.estado.id;
    }
},
]
};

dataTableEntityInit($('#arte_pesca-table'), options);
});
</script>
<?= $this->end() ?>
