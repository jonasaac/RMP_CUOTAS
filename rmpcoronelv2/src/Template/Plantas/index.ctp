<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Plantas');
$this->Html->addCrumb('Mantendores');
$this->Html->addCrumb('Plantas');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Plantas</span>
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
                          <?php if(array_in_array(['admin_planta_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Planta', '/plantas/add', newPlantaOptions);" class="btn btn-default">
                                Nueva Planta
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nueva Planta
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control" id="ver-plantas-inactivas">
                                    <span class="text"><?= __('View inactive {0}', __('Plantas'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="plantas-table">
                        <thead>
                            <tr>
                                <th><?= __('Código') ?></th>
                                <th><?= __('Sección') ?></th>
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
$(document).ready(function() {
  $('#ver-plantas-inactivas').on('change', function() {
    $('#plantas-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#plantas-table').DataTable().ajax.url( '/api/plantas/INACTIVO').load();
    } else {
      $('#plantas-table').DataTable().ajax.url( '/api/plantas').load();
    }
  });

  newPlantaOptions = {
    oTable: $('#plantas-table'),
    sTableReloadPage: '/api/plantas/'
  }

  editPlantaOptions = {
    oTable: $('#plantas-table'),
    sTableReloadPage: '/api/plantas/'
  }

  options = {
    loadUrl: '/api/plantas/',
    actionButtons:
    <?php if(array_in_array(['admin_planta_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Planta\', \'/plantas/edit/\', editPlantaOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['admin_planta_delete'], $current_user['privilegios'])): ?>
    '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/plantas/delete/\', $(\'#plantas-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
    <?php else: ?>
    '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
    <?php endif; ?>
    dataColumns: [
      {"data": "codigo"},
      {"data": "seccion"},
      {"data": "nombre"},
      {
          "data": function (row) {
              return row.recinto.estado.nombre + ' - ' + row.recinto.estado.id;
          }
      },
    ]
  };

  dataTableEntityInit($('#plantas-table'), options)
});
</script>
<?= $this->end() ?>
