<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedores Auxiliares');
$this->Html->addCrumb('Administración', ['controller' => 'Home', 'action' => 'index', '#' => 'administración']);
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Auxiliares');
?>

<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header ">
        <span class="widget-caption">Auxiliares</span>
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
              <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
              <button id="new-button" onclick="javascript:newEntity('Nuevo Auxiliar', '/auxiliares/add', newAuxiliarOptions);" class="btn btn-default">
                Nuevo Auxiliar
              </button>
              <?php else: ?>
                <button id="new-button" class="btn btn-default" disabled="disabled">
                  Nuevo Auxiliar
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-auxiliares-inactivos">
                  <span class="text"><?= __('View inactive {0}', __('Auxiliars'))?></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table class="table table-striped table-hover table-bordered" id="auxiliares-table">
            <thead>
              <tr>
                <th></th>
                <th><?= __('Id') ?></th>
                <th><?= __('RUT') ?></th>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Domicilio') ?></th>
                <th><?= __('Ciudad') ?></th>
                <th><?= __('Estado') ?></th>
                <th><?= __('Functions') ?></th>
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
var auxiliarFuncion = null; // Busca una funcion especifica del auxiliar

$('#ver-auxiliares-inactivos').change(function () {
  $('#auxiliares-table').data('selected', null);
  if($(this).is(':checked')) {
    $('#auxiliares-table').DataTable().ajax.url( '/api/auxiliares/ALL/INACTIVO').load();
  } else {
    $('#auxiliares-table').DataTable().ajax.url( '/api/auxiliares/ALL').load();
  }
})

newAuxiliarOptions = {
  fnPreSubmit: function() {
    $("#rut").val($("#rut").val().replace('k','K'));
    return true;
  },
  oTable: $('#auxiliares-table'),
  sTableReloadPage: '/api/auxiliares/' + (auxiliarFuncion ? auxiliarFuncion : ''),
};

editAuxiliarOptions = {
  fnPreSubmit: function() {
    $("#rut").val($("#rut").val().replace('k','K'));
    return true;
  },
  oTable: $('#auxiliares-table'),
  sTableReloadPage: '/api/auxiliares/' + (auxiliarFuncion ? auxiliarFuncion : ''),
};

options = {
  ajax: {
    url: '/api/auxiliares.json?retornarFunciones=true',
    dataSrc: 'auxiliares',
    dataType: 'json',
    type: 'get'
  },
  tableType: 'EXPANDABLE',
  expandedContent: function (data) {
    var sOut = '<table>';
    sOut += '<tr><td>Funciones:</td><td><strong>' + data.funciones.toString().replace(/,/g,', ').replace(/_/g, ' ').toUpperCase() + '</strong></td></tr>';
    sOut += '</table>';
    return sOut;
  },
  actionButtons:
  <?php if(array_in_array(['admin_auxiliar_edit'], $current_user['privilegios'])): ?>
  '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Auxiliar\', \'/auxiliares/edit/\', editAuxiliarOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php else: ?>
  '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
  <?php endif; ?>
  <?php if(array_in_array(['admin_auxiliar_delete'], $current_user['privilegios'])): ?>
  '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/auxiliares/delete/\', $(\'#auxiliares-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php else: ?>
  '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
  <?php endif; ?>
  dataColumns: [
    {
      "data": null,
      "defaultContent": '<i class="fa fa-plus-square-o row-details"></i>',
      "sortable": false},
      {
        "name": "Auxiliares.id",
        "data": "id"
      },{
        "name": "Auxiliares.rut",
        "data": function(row){
          var newrut = row.rut.split('').reverse('').join('').match(/.{1,3}/g).join('.');
          newrut = newrut.split('').reverse('').join('');
          return newrut+'-'+row.verificador;
        }
      },{
        "name": "Auxiliares.nombre",
        "data": "nombre_completo"
      },{
        "name": "Auxiliares.domicilio",
        "data": "domicilio"
      },{
        "data": "ciudad.nombre"
      },{
        "data": function (row) {
            return row.estado.nombre + ' - ' + row.estado.id;
        }
      },{
        "visible": false,
        "data": "funciones"
      }
    ]
  };

  dataTableEntityInit($('#auxiliares-table'), options);
  </script>
  <?= $this->end() ?>
