<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedores Camiones');
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Camiones');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Camiones</span>
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
                          <?php if(array_in_array(['admin_camion_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Camión', '/camiones/add', newCamionOptions);" class="btn btn-default">
                                Nuevo Camión
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nuevo Camión
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control" id="ver-camiones-inactivos">
                                    <span class="text"><?= __('View inactive {0}', __('Camiones'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="camiones-table">
                        <thead>
                            <tr>
                                <th><?= __('Patente') ?></th>
                                <th><?= __('Transporte') ?></th>
                                <th><?= __('Tipo Camion') ?></th>
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
  $('#ver-camiones-inactivos').on('change', function() {
    $('#camiones-table').data('selected', null);
    if($(this).is(':checked')) {
      $('#camiones-table').DataTable().ajax.url( '/api/camiones/INACTIVO').load();
    } else {
      $('#camiones-table').DataTable().ajax.url( '/api/camiones').load();
    }
  });

  newCamionOptions = {
    oTable: $('#camiones-table'),
    sTableReloadPage: '/api/camiones/'
  }

  editCamionOptions = {
    oTable: $('#camiones-table'),
    sTableReloadPage: '/api/camiones/'
  }

  options = {
    loadUrl: '/api/camiones/',
    actionButtons:
    <?php if(array_in_array(['admin_camion_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Camión\', \'/camiones/edit/\', editCamionOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['admin_camion_delete'], $current_user['privilegios'])): ?>
    '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/camiones/delete/\', $(\'#camiones-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
    <?php else: ?>
    '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
    <?php endif; ?>
    dataColumns: [
      {"data": "patente"},
      {"data": "transporte.nombre_completo"},
      {"data": "tipo_camion"},
      {
          "data": function (row) {
              return row.estado.nombre + ' - ' + row.estado.id;
          }
      },
    ]
  };

  dataTableEntityInit($('#camiones-table'), options);
});
</script>
<?= $this->end() ?>
