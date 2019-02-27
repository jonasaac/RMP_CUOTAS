<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedores Tratamientos');
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Tratamientos');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Tratamientos</span>
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
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Tratamiento', '/tratamientos/add', newTratamientoOptions);" class="btn btn-default">
                                Nuevo Tratamiento
                            </button>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Tratamientos'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="tratamientos-table">
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
newTratamientoOptions = {
oTable: $('#tratamientos-table'),
sTableReloadPage: '/api/tratamientos/'
}

editTratamientoOptions = {
oTable: $('#tratamientos-table'),
sTableReloadPage: '/api/tratamientos/'
}

options = {
loadUrl: '/api/tratamientos/',
actionButtons: '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Tratamiento\', \'/tratamientos/edit/\', editTratamientoOptions )"><i class="fa fa-edit"></i> Editar</button> <button id="delete-btn" class="btn" onclick="deleteEntity(\'/tratamientos/delete/\', $(\'#tratamientos-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
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

dataTableEntityInit($('#tratamientos-table'), options)
</script>
<?= $this->end() ?>
