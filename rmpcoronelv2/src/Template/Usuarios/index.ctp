<?php
$this->extend('/Common/view');
$this->assign('title', 'Mantenedor Usuarios');
$this->Html->addCrumb('Administración', ['controller' => 'Home', 'action' => 'index', '#' => 'administracion']);
$this->Html->addCrumb('Mantenedores');
$this->Html->addCrumb('Usuarios');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Grupos</span>
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
                          <?php if(array_in_array(['admin_usuario_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Grupo', '/grupos/add', newGrupoOptions);" class="btn btn-default">
                                Nuevo Grupo
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nuevo Grupo
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Grupos'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="grupos-table">
                        <thead>
                            <tr>
                                <th><?= __('id') ?></th>
                                <th><?= __('Nombre') ?></th>
                                <th><?= __('División') ?></th>
                                <th><?= __('Areas') ?></th>
                                <th><?= __('Estado') ?></th>
                                <th><?= __('Privilegios') ?></th>
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

<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Usuarios</span>
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
                          <?php if(array_in_array(['admin_usuario_add'], $current_user['privilegios'])): ?>
                            <button id="new-button" onclick="javascript:newEntity('Nuevo Usuario', '/usuarios/add', newUsuarioOptions);" class="btn btn-default">
                                Nuevo Usuario
                            </button>
                          <?php else: ?>
                            <button id="new-button" class="btn btn-default" disabled="disabled">
                              Nuevo Usuario
                            </button>
                          <?php endif; ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="checkbox pull-right">
                                <label>
                                    <input type="checkbox" class="form-control">
                                    <span class="text"><?= __('View inactive {0}', __('Usuarios'))?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                <div>
                    <table class="table table-hover table-striped table-bordered" id="usuarios-table">
                        <thead>
                            <tr>
                                <th><?= __('uid') ?></th>
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
  newGrupoOptions = {
    oTable: $('#grupos-table'),
    sTableReloadPage: '/api/grupos/'
  }

  editGrupoOptions = {
    oTable: $('#grupos-table'),
    sTableReloadPage: '/api/grupos/'
  }

  options = {
    loadUrl: '/api/grupos/',
    actionButtons:
    <?php if(true||array_in_array(['admin_usuario_edit'], $current_user['privilegios'])): ?>
      '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Grupo\', \'/grupos/edit/\', editGrupoOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['admin_usuario_delete'], $current_user['privilegios'])): ?>
       '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/grupos/delete/\', $(\'#grupos-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
   <?php else: ?>
   '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
   <?php endif; ?>
    dataColumns: [
      {"data": "id"},
      {"data": "nombre"},
      {"data": "division.nombre"},
      {"data": function (row) { return row.listar_areas?row.listar_areas:null; }},
      {
          "data": function (row) {
              return row.estado.nombre + ' - ' + row.estado.id;
          }
      },
      {"data": "privilegios", "visible": false},
    ]
  };

  dataTableEntityInit($('#grupos-table'), options)

  // USUARIOS
  newUsuarioOptions = {
    oTable: $('#usuarios-table'),
    sTableReloadPage: '/api/usuarios/'
  }

  editUsuarioOptions = {
    oTable: $('#usuarios-table'),
    sTableReloadPage: '/api/usuarios/',
  }

  options = {
    loadUrl: '/api/usuarios/',
    actionButtons:
    <?php if(array_in_array(['admin_usuario_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Usuario\', \'/usuarios/edit/\', editUsuarioOptions )"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['admin_usuario_delete'], $current_user['privilegios'])): ?>
     '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/usuarios/delete/\', $(\'#usuarios-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>',
   <?php else: ?>
   '<button id="delete-btn" class="btn" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>',
   <?php endif; ?>
    dataColumns: [
      {"data": "uid"},
      {"data": "nombre"},
      {
          "data": function (row) {
              return row.estado.nombre + ' - ' + row.estado.id;
          }
      },
    ],
    rowCallback: function (row, data, index) {
      $(row).data('id', data.uid);
    }
  };

  dataTableEntityInit($('#usuarios-table'), options);
});
</script>
<?= $this->end() ?>
