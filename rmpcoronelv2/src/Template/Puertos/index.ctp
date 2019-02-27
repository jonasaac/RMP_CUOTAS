<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedores Puertos');
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Puertos');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Puertos</span>
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
                          <?php if(array_in_array(['admin_puerto_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Puerto', '/puertos/add', newPuertoOptions);" class="btn btn-default">
                                Nuevo Puerto
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nuevo Puerto
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control" id="ver-puertos-inactivos">
                                    <span class="text"><?= __('View inactive {0}', __('Puertos'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="puertos-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Nombre') ?></th>
                                <th><?= __('Pontones') ?></th>
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
$(document).ready(function() {

  $('#ver-puertos-inactivos').change(function () {
    $('#puertos-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#puertos-table').DataTable().ajax.url( '/api/puertos/INACTIVO').load();
    } else {
      $('#puertos-table').DataTable().ajax.url( '/api/puertos/').load();
    }
  })

newPuertoOptions = {
oTable: $('#puertos-table'),
sTableReloadPage: '/api/puertos/'
}

editPuertoOptions = {
oTable: $('#puertos-table'),
sTableReloadPage: '/api/puertos/'
}

options = {
//loadUrl: '/api/puertos/',
ajax: {
    dataSrc: 'puertos',
    url : '/api/puertos.json'
},
tableType: 'EXPANDABLE',
expandedContent: function (data) {
    var sOut = '<div class="row">';
    sOut += '<div class="col-md-2">Pontones:</div><div class="col-md-10"><strong><ul>';
    $.each(data.pontones, function (i, v) { sOut += '<li>' + v.recinto.nombre + '</li>';});
    sOut += '</ul></strong></div>';
    sOut += '</div>';
return sOut;
},
actionButtons:
<?php if(array_in_array(['admin_puerto_edit', 'admin_ponton_add', 'admin_ponton_edit'], $current_user['privilegios'])): ?>
'<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Puerto\', \'/puertos/edit/\', editPuertoOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
<?php else: ?>
'<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
<?php endif; ?>
<?php if(array_in_array(['admin_puerto_delete'], $current_user['privilegios'])): ?>
'<button id="delete-btn" class="btn" onclick="deleteEntity(\'/puertos/delete/\', $(\'#puertos-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php else: ?>
'<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php endif; ?>
dataColumns: [
{"data":null, "defaultContent": '<i class="fa fa-plus-square-o row-details"></i>', "orderable": false},
{"data": "id"},
{"data": "recinto.nombre"},
{"data": "pontones", "visible": false},
{
    "data": function (row) {
        return row.recinto.estado.nombre + ' - ' + row.recinto.estado.id;
    }
},
]
};

dataTableEntityInit($('#puertos-table'), options);
});
</script>
<?= $this->end() ?>
