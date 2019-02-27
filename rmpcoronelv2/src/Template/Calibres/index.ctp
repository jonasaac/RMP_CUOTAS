<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Calibres');
$this->Html->addCrumb('Administración', ['controller' => 'Home', 'action' => 'index', '#' => 'administración']);
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Calibres');
?>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Calibres</span>
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
              <?php if(array_in_array(['admin_calibre_add'], $current_user['privilegios'])): ?>
              <button id="new-button" onclick="javascript:newEntity('Nuevo Calibre', '/calibres/add', newCalibreOptions);" class="btn btn-default">
                Nuevo Calibre
              </button>
              <?php else: ?>
                <button id="new-button" class="btn btn-default" disabled="disabled">
                  Nuevo Calibre
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-calibres-inactivos">
                  <span class="text"><?= __('View inactive {0}', __('Calibres'))?></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table class="table table-hover table-striped table-bordered" id="calibres-table">
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
  $('#ver-calibres-inactivos').on('change', function() {
    $('#calibres-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#calibres-table').DataTable().ajax.url( '/api/calibres/INACTIVO').load();
    } else {
      $('#calibres-table').DataTable().ajax.url( '/api/calibres').load();
    }
  });

  newCalibreOptions = {
    oTable: $('#calibres-table'),
    sTableReloadPage: '/api/calibres/'
  }

  editCalibreOptions = {
    oTable: $('#calibres-table'),
    sTableReloadPage: '/api/calibres/'
  }

  options = {
    loadUrl: '/api/calibres/',
    actionButtons:
    <?php if(array_in_array(['admin_calibre_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Calibre\', \'/calibres/edit/\', editCalibreOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['admin_calibre_delete'], $current_user['privilegios'])): ?>
    '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/calibres/delete/\', $(\'#calibres-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
    <?php else: ?>
    '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
    <?php endif; ?>
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

  dataTableEntityInit($('#calibres-table'), options)
});
</script>
<?= $this->end() ?>
