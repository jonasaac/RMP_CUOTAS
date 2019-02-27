<?php
$this->extend('/Common/view');
$this->assign('Title', 'Guias');
$this->Html->addCrumb('RMP', ['controller' => 'Home', 'action' => 'index', '#' => 'rmp']);
$this->Html->addCrumb('Guias');

// Se agrega script para hacer scroll
$this->Html->script('scrollTo/jquery.scrollTo.min.js', ['block' => true]);

// templates
$this->Form->templates([
  'formGroup' => '{{input}}',
  'select' => '<select name="{{name}}" {{attrs}}>{{content}}</select>'
  ]);
  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="widget">
        <div class="widget-header">
          <span class="widget-caption">Guias</span>
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
              <!-- TODO divisiones -->
              <div class="col-md-8 col-sm-6">
                <?php if(array_in_array(['rmp_guia_add'], $current_user['privilegios'])): ?>
                  <button id="new-guia" class="btn btn-default">
                  Nueva Guia
                </button>
              <?php else: ?>
                <button id="new-guia" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                  Nueva Guia
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="input-group input-group-xs input-small pull-right">
                <span class="input-group-addon">Año</span>
                <?= $this->Form->input('guias-year', ['options' => $years, 'class' => 'input-xs form-control']) ?>
              </div>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-guias-cerradas">
                  <span class="text">Ver Guias Cerradas</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="guias-table">
          <thead>
            <tr>
              <th>Nro Guia</th>
              <th>Origen
                <?php if(array_in_array(['admin_ponton_add', 'admin_planta_add'], $current_user['privilegios'])): ?>
                  <button id="new-origen" class="btn pull-right">Nuevo</button>
                <?php else: ?>
                  <button id="new-origen" class="btn pull-right" disabled>Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Fecha Salida</th>
              <th>Destino
                <?php if(array_in_array(['admin_planta_add'], $current_user['privilegios'])): ?>
                  <button id="new-destino" class="btn pull-right">Nuevo</button>
                <?php else: ?>
                  <button id="new-destino" class="btn pull-right" disabled>Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Fecha Recepción</th>
              <th>Camión
                <?php if(array_in_array(['admin_camion_add'], $current_user['privilegios'])): ?>
                  <button id="new-camion" class="btn pull-right">Nuevo</button>
                <?php else: ?>
                  <button id="new-camion" class="btn pull-right" disabled>Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Chofer
                <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                  <button id="new-chofer" class="btn pull-right">Nuevo</button>
                <?php else: ?>
                  <button id="new-chofer" class="btn pull-right" disabled>Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->append('jquery') ?>
<script>
$(document).ready(function () {
  $('#guias-year').select2();

  /*********************************************************
  *  -- VARIABLES GLOBALES DEL MODULO --
  ********************************************************/

  guiasEstado = 'ABIERTO';

  $('#guias-year').on('change', function() {
    console.debug('Se realiza un cambio de año');
    $('#guias-table').dataTable().DataTable().ajax.url('/api/guias/' + $(this).val() + '/' + guiasEstado).load();
  });

  // Manejo especial para las guias -- Se determina el recurso para el cual se creara la guia

  /*newEntity('Nueva Guia', '/guia_encabezados/add/', newGuiaOptions, msgs.rmp.guias.encabezado);"*/
  $('#new-guia').click(function (e) {
    e.stopPropagation();
    newEntityTitle = 'Nueva Guia';
    entityName = 'guia';
    BootstrapDialog.show({
      closable: false,
      message: '¿A que recursos desea asociar la nueva guia?',
      buttons: [
        <?php foreach($recursos as $id => $recurso): ?>
        {
          label: '<?=$recurso?>',
          action: function ( dialog ) {
            dialog.close();
            newEntity('Nueva Guia', '/guia_encabezados/add/<?=$id?>/', newGuiaOptions, msgs.rmp.guias.encabezado);
          }
        },
        <?php endforeach;?>
        {
        label: 'Cancelar',
        action: function ( dialog ) {
          dialog.close();
        }
      }]
    })
  });

  <?php if(array_in_array(['admin_camion_add'], $current_user['privilegios'])): ?>
  $('#new-camion').click(function (e) {
    e.stopPropagation();
    newEntity('Nuevo Camión', '/camiones/add/');
  });
  <?php endif; ?>
  <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
  $('#new-chofer').click(function (e) {
    e.stopPropagation();
    newEntity('Nuevo Chofer', '/auxiliares/add/chofer');
  });
  <?php endif; ?>
  <?php if(array_in_array(['admin_ponton_add', 'admin_planta_add'], $current_user['privilegios'])): ?>
  $('#new-origen').click(function (e) {
    e.stopPropagation();
    newEntityTitle = 'Nueva Planta';
    entityName = 'plantas';
    BootstrapDialog.show({
      closable: false,
      message: '¿Que origen desea ingresar?',
      buttons: [{
        label: 'Planta',
        action: function ( dialog ) {
          dialog.close();
          newEntity('Nueva Planta', '/plantas/add', {
            successCallback: function ( data ){
              var $select = $('#origen-id', $thisModal);
              $select.find('[label="Plantas"]').append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
            }
          });
        }
      }, {
        label: 'Ponton',
        action: function ( dialog ) {
          dialog.close();
          newEntity('Nuevo Ponton', '/pontones/add', {
            successCallback: function ( data ){
              var $select = $('#origen-id', $thisModal);
              $select.find('[label="Pontones"]').append('<option value="'+data.data.id+'">'+data.data.puerto.nombre+' - '+data.data.nombre+'</option>');
            }
          });
        }
      },{
        label: 'Cancelar',
        action: function ( dialog ) {
          dialog.close();
        }
      }]
    })
  });
  <?php endif; ?>
  <?php if(array_in_array(['admin_planta_add'], $current_user['privilegios'])): ?>
  $('#new-destino').click(function (e) {
    e.stopPropagation();
    newEntity('Nueva Plata de Destino', '/plantas/add');
  });
  <?php endif; ?>


  $('#ver-guias-cerradas').change(function () {
    var actionbuttons = $('#guias-table').parents('.dataTables_wrapper').find('.action-buttons');

    $('#guias-table').data('selected', null);

    if( $(this).is(':checked') ) {
      $('#guias-table').DataTable().ajax.url( '/api/guias/' + $('#guias-year').val() + '/CERRADO').load();
      $('#new-guia').hide();
      actionbuttons.find('#edit-btn').hide();
      actionbuttons.find('#lock-btn').hide();
      actionbuttons.find('#unlock-btn').show();
    } else {
      $('#guias-table').DataTable().ajax.url( '/api/guias/' + $('#guias-year').val() + '/ABIERTO').load();

      $('#new-guia').show();
      actionbuttons.find('#edit-btn').show();
      actionbuttons.find('#lock-btn').show();
      actionbuttons.find('#unlock-btn').hide();
    }
  });

  options = {
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: '/api/guias/' + $('#guias-year').val(),
      type: 'post'
    },
    loadUrl: '/api/guias/' + $('#guias-year').val(),
    actionButtons: <?php if(array_in_array(['rmp_guia_lock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:lockEntity(\'/guia_encabezados/lock/\', $(\'#guias-table\'));" id="lock-btn" class="btn btn-xs"><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php else: ?>
    '<button id="lock-btn" class="btn btn-xs" disabled><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['rmp_guia_unlock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:unlockEntity(\'/guia_encabezados/unlock/\', $(\'#guias-table\'));" id="unlock-btn" class="btn btn-xs" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php else: ?>
    '<button id="unlock-btn" class="btn btn-xs" style="display: none;" disabled><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['rmp_guia_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Guia\', \'/guia_encabezados/edit/\', editGuiaOptions, msgs.rmp.guias.encabezado)"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['rmp_guia_delete'], $current_user['privilegios'])): ?>
    '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/guia_encabezados/delete/\', $(\'#guias-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {"data": "nro_guia"},
      {"data": "origen.nombre"},
      {"data": {
        "_": function(row){return row?moment.utc(row.fecha_salida).format('DD-MMM-YYYY HH:mm'):null;},
        "sort": "fecha_salida"
      }},
      {"data": "destino.nombre"},
      {"data": {
        "_": function (row) { return row?(row.fecha_recepcion?moment.utc(row.fecha_recepcion).format('DD-MMM-YYYY HH:mm'):'NO RECIBIDO'):'NO RECIBIDO';},
        "sort": function (row) { return row?(row.fecha_recepcion?row.fecha_recepcion:'NO RECIBIDO'):'NO RECIBIDO';}
      }},
      {"data": function (row) { return row.virtual == 0 ? row.camion.patente : 'VIRTUAL' }},
      {"data": function (row) { return row.virtual == 0 ? row.chofer.nombre_completo : 'VIRTUAL' }},
      {"data": function (row) { return row.total_guia;},
       "class": 'text-right'
      },
    ],
    rowCallback: function (nRow, aData, iDisplayIndex) {
      $('td:eq(2)', nRow).data("fecha", aData.fecha_salida);
      $('td:eq(4)', nRow).data("fecha", aData.fecha_recepcion);
      //$('td:eq(5)', nRow).text(moment(aData.fecha_recepcion).format('DD-MM-YYYY HH:mm'));
      return nRow;
    }
  }


  newGuiaOptions = {
    dialogSize: BootstrapDialog.SIZE_WIDE,
    oTable: $('#guias-table'),
    sTableReloadPage: '/api/guias/' + $('#guias-year').val(),
    fnPreSubmit: function () {
      if (!detallesData.length) {
        console.debug('Guia sin detalles!');
        errorNotify(msgs.rmp.guias.detalles.emptySave);
        return false;
      }
      return true;
    },
    fnCreateCallback: function ($message) {

    }
  }
  editGuiaOptions = {
    dialogSize: BootstrapDialog.SIZE_WIDE,
    oTable: $('#guias-table'),
    sTableReloadPage: '/api/guias/' + $('#guias-year').val(),
    fnPreSubmit: function () {
      if (!detallesData.length) {
        console.debug('Guia sin detalles!');
        errorNotify(msgs.rmp.guias.detalles.emptySave);
        return false;
      }
      return true;
    },
    fnCreateCallback: function ($message) {
    }
  }
  dataTableEntityInit($('#guias-table'), options);
});
</script>
<?= $this->end() ?>
