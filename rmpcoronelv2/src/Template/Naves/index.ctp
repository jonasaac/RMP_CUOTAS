
<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Naves');
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Naves', ['controller' => 'Naves', 'action' => 'index']);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Naves</span>
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
                          <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nueva Nave', '/naves/add', newNaveOptions);" class="btn btn-default">
                                Nueva Nave
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nueva Nave
                            </button>
                          <?php endif; ?>
                        </div>
                                                <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input id="ver-naves-inactivas" type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Naves'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="naves-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Matricula') ?></th>
                                <th><?= __('Nombre') ?></th>
                                <th><?= __('Señal Distintiva') ?></th>
                                <th><?= __('Armador') ?></th>
                                <th><?= __('Representante') ?></th>
                                <th><?= __('Estado') ?></th>
                                <th>Recursos</th>
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
$('#ver-naves-inactivas').change(function () {
$('#naves-table').data('selected', null);
if($(this).is(':checked')) {
$('#naves-table').DataTable().ajax.url( '/api/naves/INACTIVO').load();
} else {
$('#naves-table').DataTable().ajax.url( '/api/naves').load();
}
})

options = {
ajax: {
  url: '/api/naves.json?recursos=true',
  dataSrc: 'naves',
},
tableType: 'EXPANDABLE',
expandedContent: function (data) {
    var sOut = '<div class"row details">';
    sOut += '<div class="col-md-2">Capacidad:</div><div class="col-md-10"><strong><ul>';
    $.each(data.unidades, function (i, v) { sOut += '<li>' + v._joinData.capacidad + ' ' + v.abreviacion + '</li>';});
    sOut += '</ul></strong></div>';
    sOut += '<div class="col-md-2">Capacidad Bodegas:</div><div class="col-md-10"><strong><ul>';
    $.each(data.bodegas, function (i, v) { sOut += '<li>Bodega-' + v.nro + ' ' + v.capacidad + ' M<sup>3</sup></li>'; });
    sOut += '</ul></strong></div>';
    sOut += '</div>';
return sOut;
},
actionButtons:
<?php if(array_in_array(['admin_nave_edit'], $current_user['privilegios'])): ?>
'<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Nave\', \'/naves/edit/\', editNaveOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
<?php else: ?>
'<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
<?php endif; ?>
<?php if(array_in_array(['admin_nave_delete'], $current_user['privilegios'])): ?>
'<button id="delete-btn" class="btn" onclick="deleteEntity(\'/naves/delete/\', $(\'#naves-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php else: ?>
'<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
<?php endif; ?>
dataColumns: [
{"defaultContent": '<i class="fa fa-plus-square-o row-details"></i>', "orderable": false},
{"data": "id", "visible": false},
{"data": "matricula"},
{"data": "nombre"},
{"data": "senal_distintiva"},
{"data": "armador.nombre_completo"},
{"data": "representante.nombre_completo"},
{"data": function (row) {
  return row.estado.nombre + ' - ' + row.estado.id;
}},
{
  "data": "recursos_list",
  "visible": false
}
]
};

newNaveOptions = {
oTable: $('#naves-table'),
sTableReloadPage: '/api/naves',
}

editNaveOptions = {
oTable: $('#naves-table'),
sTableReloadPage: '/api/naves',
}

dataTableEntityInit($('#naves-table'), options);
</script>
<?= $this->end() ?>
