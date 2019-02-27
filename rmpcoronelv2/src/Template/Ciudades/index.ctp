<?php
$this->extend('/Common/view');
$this->assign('title', 'Ciudades');
$this->Html->addCrumb('Ciudades');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Ciudades</span>
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
                          <?php if(array_in_array(['admin_ciudad_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Ciudad', '/ciudades/add', newCiudadOptions);" class="btn btn-default">
                                Nuevo Ciudad
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nuevo Ciudad
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input id="ver-ciudades-inactivas" type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Ciudades'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="ciudades-table">
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
$('#ver-ciudades-inactivas').on('change', function() {
$('#ciudades-table').data('selected', null);
if($(this).is(':checked')) {
$('#ciudades-table').DataTable().ajax.url( '/api/ciudades/INACTIVO').load();
} else {
$('#ciudades-table').DataTable().ajax.url( '/api/ciudades').load();
}
});

newCiudadOptions = {
oTable: $('#ciudades-table'),
sTableReloadPage: '/api/ciudades/'
}

editCiudadOptions = {
oTable: $('#ciudades-table'),
sTableReloadPage: '/api/ciudades/'
}

options = {
loadUrl: '/api/ciudades/',
actionButtons:
<?php if(array_in_array(['admin_ciudad_edit'], $current_user['privilegios'])): ?>
'<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Ciudad\', \'/ciudades/edit/\', editCiudadOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
<?php else: ?>
'<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
<?php endif; ?>
<?php if(array_in_array(['admin_ciudad_delete'], $current_user['privilegios'])): ?>
'<button id="delete-btn" class="btn" onclick="deleteEntity(\'/ciudades/delete/\', $(\'#ciudades-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php else: ?>
'<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php endif; ?>
dataColumns: [
{"mData": "id"},
{"mData": "nombre"},
{
    "data": function (row) {
        return row.estado.nombre + ' - ' + row.estado.id;
    }
},
]
};

dataTableEntityInit($('#ciudades-table'), options)
});
</script>
<?= $this->end() ?>
