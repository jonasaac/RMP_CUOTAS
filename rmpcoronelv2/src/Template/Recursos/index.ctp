<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Recursos');
$this->Html->addCrumb('Administración', ['controller' => 'Home', 'action' => 'index', '#' => 'administración']);
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Recursos');
?>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Recursos</span>
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
              <button id="new-button" onclick="javascript:newEntity('Nuevo Recurso', '/recursos/add', newRecursoOptions);" class="btn btn-default">
                Nuevo Recurso
              </button>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-recursos-inactivos">
                  <span class="text"><?= __('View inactive {0}', __('Recursos'))?></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table class="table table-hover table-striped table-bordered" id="recursos-table">
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
  $('#ver-recursos-inactivos').on('change', function() {
    $('#recursos-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#recursos-table').DataTable().ajax.url( '/api/recursos/INACTIVO').load();
    } else {
      $('#recursos-table').DataTable().ajax.url( '/api/recursos').load();
    }
  });

  newRecursoOptions = {
    oTable: $('#recursos-table'),
    sTableReloadPage: '/api/recursos/'
  }

  editRecursoOptions = {
    oTable: $('#recursos-table'),
    sTableReloadPage: '/api/recursos/'
  }

  options = {
    loadUrl: '/api/recursos/',
    actionButtons: '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Recurso\', \'/recursos/edit/\', editRecursoOptions )"><i class="fa fa-edit"></i> Editar</button> <button id="delete-btn" class="btn" onclick="deleteEntity(\'/recursos/delete/\', $(\'#recursos-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
    dataColumns: [
      {"data": "id"},
      {"data": "nombre"},
      {
          "data": function (row) {
              return row.estado.nombre + ' - ' + row.estado.id;
          }
      },
    ]
  };

  dataTableEntityInit($('#recursos-table'), options)
});
</script>
<?= $this->end() ?>
