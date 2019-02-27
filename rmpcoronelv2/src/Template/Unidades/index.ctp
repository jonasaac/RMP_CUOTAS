<?php
$this->extend('/Common/view');
$this->assign('title', 'Unidades');
$this->Html->addCrumb('Unidades');
?>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Unidades</span>
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
              <button id="new-button" onclick="javascript:newEntity('Nuevo Unidad', '/unidades/add', newUnidadOptions);" class="btn btn-default">
                Nuevo Unidad
              </button>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input id="ver-unidades-inactivas" type="checkbox" class="form-control">
                  <span class="text"><?= __('View inactive {0}', __('Unidades'))?></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table class="table table-hover table-striped table-bordered" id="unidades-table">
            <thead>
              <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Abreviación') ?></th>
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
$('#ver-unidades-inactivas').change(function () {
  $('#unidades-table').data('selected', null);
  if($(this).is(':checked')) {
    $('#unidades-table').DataTable().ajax.url( '/api/unidades/INACTIVO').load();
  } else {
    $('#unidades-table').DataTable().ajax.url( '/api/unidades').load();
  }
})

newUnidadOptions = {
  oTable: $('#unidades-table'),
  sTableReloadPage: '/api/unidades/'
}

editUnidadOptions = {
  oTable: $('#unidades-table'),
  sTableReloadPage: '/api/unidades/'
}

options = {
  loadUrl: '/api/unidades/',
  actionButtons: '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Unidad\', \'/unidades/edit/\', editUnidadOptions )"><i class="fa fa-edit"></i> Editar</button> <button id="delete-btn" class="btn" onclick="deleteEntity(\'/unidades/delete/\', $(\'#unidades-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
  dataColumns: [
    {"data": "id"},
    {"data": "nombre"},
    {"data": "abreviacion"},
    {
        "data": function (row) {
            return row.estado.nombre + ' - ' + row.estado.id;
        }
    },
  ]
};

dataTableEntityInit($('#unidades-table'), options)
</script>
<?= $this->end() ?>
