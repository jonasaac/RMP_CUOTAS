<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Transportes');
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Transportes');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Transportes</span>
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
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Transporte', '/transportes/add', newTransporteOptions);" class="btn btn-default">
                                Nuevo Transporte
                            </button>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Transportes'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="transportes-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Nombre') ?></th>
                                <th><?= __('Estado') ?></th>
                                <th><?= __('Camiones') ?></th>
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
newTransporteOptions = {
oTable: $('#transportes-table'),
sTableReloadPage: '/api/transportes/'
}

editTransporteOptions = {
oTable: $('#transportes-table'),
sTableReloadPage: '/api/transportes/'
}

options = {
loadUrl: '/api/transportes/',
tableType: 'EXPANDABLE',
expandedContent: function (data) {
    var sOut = '<div class="row">';
    sOut += '<div class="col-md-2">Camiones:</div><div class="col-md-10"><strong><ul>';
    $.each(data.camiones, function (i, v) { sOut += '<li>' + v.patente + '</li>';});
    sOut += '</ul></strong></div>';
    sOut += '</div>';
return sOut;
},
actionButtons: '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Transporte\', \'/transportes/edit/\', editTransporteOptions )"><i class="fa fa-edit"></i> Editar</button> <button id="delete-btn" class="btn" onclick="deleteEntity(\'/transportes/delete/\', $(\'#transportes-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
dataColumns: [
{"data":null, "defaultContent": '<i class="fa fa-plus-square-o row-details"></i>', "orderable": false},
{"mData": "id"},
{"mData": "nombre"},
{
    "data": function (row) {
        return row.estado.nombre + ' - ' + row.estado.id;
    }
},
{"mData": "camiones", "visible": false},
]
};

dataTableEntityInit($('#transportes-table'), options)
</script>
<?= $this->end() ?>
