<?php
$this->extend('/Common/view');
$this->assign('title', 'Regimenes');
$this->Html->addCrumb('Regimenes');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Régimenes</span>
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
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Regimen', '/regimenes/add', newRegimenOptions);" class="btn btn-default">
                                Nuevo Régimen
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="regimenes-table">
                        <thead>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Nombre') ?></th>
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
$(document).ready(function() {
newRegimenOptions = {
oTable: $('#regimenes-table'),
sTableReloadPage: '/api/regimenes/'
}

editRegimenOptions = {
oTable: $('#regimenes-table'),
sTableReloadPage: '/api/regimenes/'
}

options = {
loadUrl: '/api/regimenes/',
actionButtons: '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Regimen\', \'/regimenes/edit/\', editRegimenOptions )"><i class="fa fa-edit"></i> Editar</button> <button id="delete-btn" class="btn" onclick="deleteEntity(\'/regimenes/delete/\', $(\'#regimenes-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
dataColumns: [
{"mData": "id"},
{"mData": "nombre"}
]
};

dataTableEntityInit($('#regimenes-table'), options);
});
</script>
<?= $this->end() ?>
