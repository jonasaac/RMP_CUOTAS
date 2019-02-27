<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Divisiones');
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Divisiones');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Divisiones</span>
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
                        <div class="col-md-12 col-sm-12">
                            <button id="new-button" onclick="javascript:newEntity('Nueva División', '/divisiones/add', newDivisionOptions);" class="btn btn-default">
                                Nueva División
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="divisiones-table">
                        <thead>
                            <tr>
                                <th><?= __('Id')?></th>
                                <th><?= __('Nombre')?></th>
                                <th><?= __('Estado')?></th>
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
newDivisionOptions = {
oTable: $('#divisiones-table'),
sTableReloadPage: '/api/divisiones/'
}

editDivisionOptions = {
oTable: $('#divisiones-table'),
sTableReloadPage: '/api/divisiones/'
}

options = {
loadUrl: '/api/divisiones/',
actionButtons: '<button onclick="javascript:detailEntity(\'División\', \'/divisiones/view/\', $(\'#divisiones-table\'));" id="details-btn" class="btn"><i class="fa fa-eye"></i> Ver</button> <button id="edit-btn" class="btn" onClick="editEntity(\'Editar División\', \'/divisiones/edit/\', editDivisionOptions )"><i class="fa fa-edit"></i> Editar</button> <button id="delete-btn" class="btn" onclick="deleteEntity(\'/divisiones/delete/\', $(\'#divisiones-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
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

dataTableEntityInit($('#divisiones-table'), options);
</script>
<?= $this->end() ?>
