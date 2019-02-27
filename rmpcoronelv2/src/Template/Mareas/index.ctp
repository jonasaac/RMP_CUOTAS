<?php
$this->extend('/Common/view');
$this->assign('title', 'Mareas');
$this->Html->addCrumb('RMP', ['controller' => 'Home', 'action' => 'index', '#' => 'rmp']);
$this->Html->addCrumb('Mareas');
?>
<?php
$this->Form->templates([
  'formGroup' => '{{input}}',
  'select' => '<select name="{{name}}" {{attrs}}>{{content}}</select>',
]);
?>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Mareas</span>
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
              <?php if (array_in_array(['rmp_marea_add'], $current_user['privilegios'])): ?>
                <button id="new-marea" onclick="javascript:newEntity('Nueva Marea', '/mareas/add/', newMareaOptions, msgs.rmp.mareas.mareas);" class="btn btn-default">
                  Nueva Marea
                </button>
              <?php else: ?>
                <button id="new-marea" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                  Nueva Marea
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="input-group input-group-xs input-small pull-right">
                <span class="input-group-addon">Año</span>
                <?= $this->Form->input('mareas-year', ['options' => $years, 'class' => 'input-xs form-control']) ?>
              </div>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-mareas-cerradas">
                  <span class="text">Ver Mareas Cerradas</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="mareas-table">
          <thead>
            <tr>
              <th>id</th>
              <th>Nave
                <?php if (array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                  <button id="new-nave" class="btn pull-right">Nueva</button>
                <?php else: ?>
                  <button id="new-nave" class="btn pull-right" disabled>Nueva</buton>
                <?php endif; ?>
              </th>
              <th>Fecha Zarpe</th>
              <th>Capitan
                <?php if (array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                  <button id="new-capitan" class="btn pull-right">Nuevo</button>
                <?php else: ?>
                  <button id="new-capitan" class="btn pull-right" disabled>Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Puerto
                <?php if (array_in_array(['admin_puerto_add'], $current_user['privilegios'])): ?>
                  <button id="new-puerto" class="btn pull-right">Nuevo</button>
                <?php else: ?>
                  <button id="new-puerto" class="btn pull-right" disabled>Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Recaladas (A/T)</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Recaladas</span>
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
              <?php if (array_in_array(['rmp_recalada_add'], $current_user['privilegios'])): ?>
                <button id="new-recalada" onclick="javascript:newEntity('Nueva Recalada - '+naveSelected+' Zarpe:'+moment.utc(fechaMarea).format('DD-MMM-YYYY'), '/recaladas/add/', newRecaladaOptions, msgs.rmp.mareas.recaladas);" class="btn btn-default pull-left">
                  Nueva Recalada
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" id="ver-recaladas-cerradas">
                  <span class="text">Ver Recaladas Cerradas</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-striped table-hover table-bordered" id="recaladas-table">
          <thead>
            <tr role="row">
              <th>id</th>
              <th>Fecha Recalada</th>
              <th>Ponton
                <?php if (array_in_array(['admin_ponton_add'], $current_user['privilegios'])): ?>
                  <button id="new-ponton" class="btn pull-right">Nuevo</button>
                <?php endif; ?>
              </th>
              <th>Descargas (A/T)</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Descarga</span>
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
              <?php if (array_in_array(['rmp_descarga_add'], $current_user['privilegios'])): ?>
                <button id="new-descarga" onclick="javascript:newEntity('Nueva Descarga - '+naveSelected+' - Zarpe: '+moment.utc(fechaMarea).format('DD-MMM-YYYY')+', Recalada: '+pontonRecalada+' '+moment.utc(fechaRecalada).format('DD-MMM-YYYY'), '/descarga_encabezados/add/' + recursoSelected, newDescargaOptions, msgs.rmp.mareas.descargas);" class="btn btn-default pull-left">
                  Nueva Descarga
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" id="ver-descargas-cerradas">
                  <span class="text">Ver Descargas Cerradas</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-bordered table-striped" id="descargas-table">
          <thead>
            <tr role="row">
              <th>Codigo</th>
              <th>Tipo Descarga</th>
              <th>Movimiento</th>
              <th>Inicio Desembarque</th>
              <th>Termino Desembarque</th>
              <th>Estado</th>
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
  $('#mareas-year').select2();

  /*********************************************************
  *  -- VARIABLES GLOBALES DEL MODULO --
  ********************************************************/

  // Estados de las tablas
  mareasEstado = 'ABIERTO';
  recaladasEstado = 'ABIERTO';
  descargasEstado = 'ABIERTO';

  // Datos obtenidos desde la marea
  tipoDescargaSelected = null; // Desde la nave seleccionada por la marea
  naveSelected = null;
  naveData = null; // Datos de la Nave
  fechaMarea = null;
  zonaPesca = null;
  recursoSelected = null; // obtenido desde el arte de pesca

  // Datos obtenidos desde la recalada
  fechaRecalada = null;
  pontonRecalada = null;

  /*********************************************************
  *  -- MAREAS --
  ********************************************************/

  $('#mareas-year').on('change', function() {
    $('#mareas-table').dataTable().DataTable().ajax.reload();

    // Se limpian las tablas de recaladas y tablas
    $('#recaladas-table').DataTable().clear().draw();
    $('#descargas-table').DataTable().clear().draw();
  });

  $('#ver-mareas-cerradas').change(function() {
    var actionbuttons = $('#mareas-table').parents('.dataTables_wrapper').find('.action-buttons');

    $('#mareas-table').data('selected', null);
    $('#recaladas-table').data('selected', null);
    $('#descargas-table').data('selected', null);
    $('#recaladas-table').DataTable().clear().draw();
    $('#descargas-table').DataTable().clear().draw();

    if ($(this).is(':checked')) {
      mareasEstado = 'CERRADO';
      $('#mareas-table').dataTable().DataTable().ajax.reload();
      $('#new-marea').hide();
      actionbuttons.find('#edit-btn').hide();
      actionbuttons.find('#lock-btn').hide();
      actionbuttons.find('#unlock-btn').show();

      $('#ver-recaladas-cerradas, #ver-descargas-cerradas').prop('disabled', true).prop('checked', true);
      recaladasEstado = 'CERRADO';
      descargasEstado = 'CERRADO';
    } else {
      mareasEstado = 'ABIERTO'
      $('#mareas-table').dataTable().DataTable().ajax.reload();

      $('#new-marea').show();
      actionbuttons.find('#edit-btn').show();
      actionbuttons.find('#lock-btn').show();
      actionbuttons.find('#unlock-btn').hide();
      $('#ver-recaladas-cerradas, #ver-descargas-cerradas').prop('disabled', false).prop('checked', false);
      recaladasEstado = 'ABIERTO';
      descargasEstado = 'ABIERTO';
    }
  });
  mareasOptions = {
    "serverSide": true,
    "ajax": {
      url: function() {return '/api/mareas/' + $('#mareas-year').val() + '/' + mareasEstado;},
      type: 'post'
    },
    loadUrl: '/api/mareas/' + $('#mareas-year').val(),
    actionButtons:
    <?php if (array_in_array(['rmp_marea_lock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:lockEntity(\'/mareas/lock/\', $(\'#mareas-table\'))" id="lock-btn" class="btn btn-xs"><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php else: ?>
    '<button id="lock-btn" class="btn btn-xs" disabled><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['rmp_marea_unlock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:unlockEntity(\'/mareas/unlock/\', $(\'#mareas-table\'));" id="unlock-btn" class="btn btn-xs" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php else: ?>
    '<button id="unlock-btn" class="btn btn-xs" style="display: none;" disabled><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['rmp_marea_edit'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:editEntity(\'Editar Marea\', \'/mareas/edit/\', editMareaOptions, msgs.rmp.mareas.mareas);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['rmp_marea_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteEntity(\'/mareas/delete/\', $(\'#mareas-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "name": "Mareas.id",
        "data": "id"
      }, {
        "name": "Naves.nombre",
        "data": "nave.nombre"
      }, {
        "name": "Mareas.fecha_zarpe",
        "data": {
          "_": function(row)
          {
            return row?moment.utc(row.fecha_zarpe).format('DD-MMM-YYYY HH:mm'):null;
          },
          "sort": "fecha_zarpe" // Se utiliza para ordenar por fecha
        }
      }, {
        "name": "Capitanes.nombre Capitanes.apellido_paterno Capitanes.apellido_materno",
        "data": "capitan.nombre_completo"
      }, {
        "name": "Puertos.Recintos.nombre",
        "data": "puerto.recinto.nombre"
      }, {
        "name": "Nro_Recaladas",
        "sortable": false,
        "data": function(row) {return row.nro_recaladas;}
      }, {
        "name": "Estados.id",
        "data": function(row) {return row.estado.nombre+' - '+row.estado.id},
        "sortable": false
      }
    ],
    rowCallback: function(row, data, index) {
      $('td:eq(2)', row).data('fecha', data.fecha_zarpe);
      $('td:eq(1)', row).data('nave', data.nave);
    },
    selectCallback: function(id, row) {
      console.log('/api/recaladas/' + id + '/' + recaladasEstado);
      if (id) {
        $('#recaladas-table').dataTable().DataTable().ajax.url('/api/recaladas/' + id + '/' + recaladasEstado).load();
        $('#descargas-table').DataTable().clear().draw(); // se limpia la tabla de mareas
        fechaMarea = $('td:eq(2)', row).data('fecha');
        naveSelected = $('td:eq(1)', row).data('nave').nombre;
        naveData = $('td:eq(1)', row).data('nave');
        recursoSelected = row.data('data').arte_pesca.recurso_id;
        if (row.data('data').nave.regimen_id == 1) {
          tipoDescargaSelected = 1;
        } else {
          tipoDescargaSelected = 2;
        }
      } else {
        row.removeClass('selected');
      }
    },
    unselectCallback: function() {
      $('#recaladas-table').DataTable().clear().draw();
      $('#descargas-table').DataTable().clear().draw();
      fechaMarea = null;
      naveSelected = null;
      naveData = null;
      recursoSelected = null;
    }
  };
  console.log(mareasOptions);

  newMareaOptions = {
    oTable: $('#mareas-table'),
    sTableReloadPage: function() {
      return '/api/mareas/' + $('#mareas-year').val();
    },
    successCallback: function(data) {
      console.log(data);
      $('#mareas-table').data('selected', data.data.id);
      fechaMarea = data.data.fecha_zarpe;
      naveSelected = data.data.nave.nombre;
      naveData = data.data.nave;
      recursoSelected = data.data.arte_pesca.recurso_id;

      // Se determina el tipo de descarga segun el regimen de la nave
      if (data.data.nave.regimen_id == 1) {
        tipoDescargaSelected = 1;
      } else {
        tipoDescargaSelected = 2;
      }

      BootstrapDialog.confirm({
        message: "¿Desea registrar una recalada?",
        size: BootstrapDialog.SIZE_SMALL,
        callback: function(result) {
          if (result) {
            newEntity('Nueva Recalada - ' + naveSelected + ' Zarpe:' + moment(fechaMarea).format('DD-MMM-YYYY'), '/recaladas/add/', newRecaladaOptions, msgs.rmp.mareas.recaladas);
            $('#recaladas-table').dataTable().DataTable().ajax.url('/api/recaladas/' + data.data.id + '/' + recaladasEstado).load();
          }
        }
      });
    }
  };

  editMareaOptions = {
    oTable: $('#mareas-table'),
    sTableReloadPage: function() {
      return '/api/mareas/' + $('#mareas-year').val();
    },
    fnSuccessCallback: function(data) {
      fechaMarea = data.data.fecha_zarpe;
      naveSelected = data.data.nave.nombre;
      naveData = data.data.nave;
      recursoSelected = data.data.arte_pesca.recurso_id;

      // Se determina el tipo de descarga segun el regimen de la nave
      if (data.data.nave.regimen_id == 1) {
        tipoDescargaSelected = 1;
      } else {
        tipoDescargaSelected = 2;
      }
    }
  };

  /*********************************************************
  *  -- RECALADAS --
  ********************************************************/

  $('#ver-recaladas-cerradas').change(function() {
    var actionbuttons = $('#recaladas-table').parents('.dataTables_wrapper').find('.action-buttons')

    $('#recaladas-table').data('selected', null);
    $('#descargas-table').data('selected', null);
    $('#descargas-table').DataTable().clear().draw();

    if ($(this).is(':checked')) {
      if ($('#mareas-table').data('selected')) {
        $('#recaladas-table').DataTable().ajax.url('/api/recaladas/' + $('#mareas-table').data('selected') + '/CERRADO').load();
      }

      actionbuttons.find('#edit-btn, #lock-btn').hide();
      actionbuttons.find('#unlock-btn').show();
      if ($(this).is(':disabled'))
      actionbuttons.find('#unlock-btn').prop('disabled', true);

      $('#new-recalada').hide();
      $('#ver-descargas-cerradas').prop('disabled', true).prop('checked', true);
      recaladasEstado = 'CERRADO';
      descargasEstado = 'CERRADO';
    } else {
      if ($('#mareas-table').data('selected')) {
        $('#recaladas-table').DataTable().ajax.url('/api/recaladas/' + $('#mareas-table').data('selected') + '/ABIERTO').load();
      }
      actionbuttons.find('#edit-btn, #lock-btn').show();
      actionbuttons.find('#unlock-btn').hide().prop('disabled', false);

      $('#new-recalada').show();
      $('#ver-descargas-cerradas').prop('disabled', false).prop('checked', false);
      recaldasEstado = 'ABIERTO';
      descargasEstado = 'ABIERTO';
    }
  });

  recaladasOptions = {
    "loadUrl": null,
    actionButtons:
    <?php if (array_in_array(['rmp_recalada_lock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:lockEntity(\'/recaladas/lock/\', $(\'#recaladas-table\'));" id="lock-btn" class="btn btn-xs"><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php else: ?>
    '<button id="lock-btn" class="btn btn-xs" disabled><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['rmp_recalada_unlock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:unlockEntity(\'/recaladas/unlock/\', $(\'#recaladas-table\'));" id="unlock-btn" class="btn btn-xs" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php else: ?>
    '<button id="unlock-btn" class="btn btn-xs" style="display: none;" disabled><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['rmp_recalada_edit'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:editEntity(\'Editar Recalada - \'+naveSelected+\' - Zarpe: \'+moment(fechaMarea).format(\'DD-MMM-YYYY\'), \'/recaladas/edit/\', editRecaladaOptions, msgs.rmp.mareas.recaladas);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if (array_in_array(['rmp_recalada_delete'], $current_user['privilegios'])): ?>
    '<button onclick="deleteEntity(\'/recaladas/delete/\', $(\'#recaladas-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn btn-xs" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [{
      "name": "Recaladas.id",
      "data": "id"
    }, {
      "name": "Recaladas.fecha_recalada",
      "data": {
        "_": function (row) { return row?moment.utc(row.fecha_recalada).format('DD-MMM-YYYY HH:mm'):null;},
        "sort": "fecha_recalada"
      }
    }, {
      "name": "Pontones.Recintos.nombre",
      "data": "ponton.recinto.nombre"
    }, {
      "name": "Nro_Descargas",
      "sortable": false,
      "data": function (row) {return row.nro_descargas;}
    }, {
      "name": "Estados.nombre",
      "data": function(row) {return row.estado.nombre+' - '+row.estado.id},
      "sortable": false
    }],
    rowCallback: function(row, data, index) {
      $('td:eq(1)', row).data('fecha_recalada', data.fecha_recalada);
    },
    selectCallback: function(id, row) {
      if (id) {
        $('#descargas-table').DataTable().ajax.url('/api/descargas/' + id + '/' + descargasEstado).load();
        fechaRecalada = $('td:eq(1)', row).data('fecha_recalada');
        pontonRecalada = $('td:eq(2)', row).text();
      } else {
        row.removeClass('selected');
      }
    },
    unselectCallback: function() {
      $('#descargas-table').DataTable().clear().draw();
      fechaRecalada = null;
    }
  };

  newRecaladaOptions = {
    oTable: $('#recaladas-table'),
    sTableReloadPage: function() {
      return '/api/recaladas/' + $('#mareas-table').data('selected') + '/' + recaladasEstado;
    },
    fnCreateCallback: function($message) {
      $('form', $message).append('<input type="hidden" value="' + $('#mareas-table').data('selected') + '" name="marea_id" id="marea-id">');
      //$('#fecha-recalada-date-container', $message).data("DateTimePicker").minDate(moment(fechaMarea)).date(moment(fechaMarea));
    },
    fnPreCreate: function() {
      if (!$('#mareas-table').data('selected')) {
        warningNotify('Debe seleccionar una marea primero.');
        return false;
      }
      return true;
    },
    successCallback: function(data) {
      console.debug(data);
      $('#recaladas-table').data('selected', data.data.id);
      fechaRecalada = data.data.fecha_recalada;
      pontonRecalada = data.data.ponton.recinto.nombre;
      BootstrapDialog.confirm({
        message: "¿Desea registrar una descarga?",
        size: BootstrapDialog.SIZE_SMALL,
        callback: function(result) {
          if (result) {
            newEntity(
              'Nueva Descarga - ' + naveSelected + ' - Zarpe: ' + moment(fechaMarea).format('DD-MMM-YYYY') + ', Recalada: ' + pontonRecalada + ' ' + moment(fechaRecalada).format('DD-MMM-YYYY'),
              '/descarga_encabezados/add/' + recursoSelected,
              newDescargaOptions,
              msgs.rmp.mareas.descargas);
              $('#descargas-table').DataTable().ajax.url('/api/descargas/' + data.data.id + '/' + descargasEstado).load();
            }
          }
        });
      }
    };

    editRecaladaOptions = {
      oTable: $('#recaladas-table'),
      sTableReloadPage: function() {
        return '/api/recaladas/' + $('#mareas-table').data('selected') + '/' + recaladasEstado;
      },
      fnCreateCallback: function($message) {
        //$('#fecha-recalada-date-container', $message).data("DateTimePicker").minDate(moment.utc(fechaMarea));
      },
      fnSuccessCallback: function(data) {
        fechaRecalada = data.data.fecha_recalada;
        pontonRecalada = data.data.ponton.recinto.nombre;
      }
    };

    /*********************************************************
    *  -- DOCUMENTOS DE DESCARGA --
    ********************************************************/

    $('#ver-descargas-cerradas').change(function() {
      var actionbuttons = $('#descargas-table').parents('.dataTables_wrapper').find('.action-buttons')

      $('#descargas-table').data('selected', null);

      if ($(this).is(':checked')) {
        if ($('#recaladas-table').data('selected')) {
          $('#descargas-table').DataTable().ajax.url('/api/descargas/' + $('#recaladas-table').data('selected') + '/CERRADO').load();
        }
        actionbuttons.find('#edit-btn, #lock-btn').hide();
        actionbuttons.find('#unlock-btn').show();
        if ($(this).is(':disabled'))
        actionbuttons.find('#unlock-btn').prop('disabled', true);

        $('#new-descarga').hide();
        descargasEstado = 'CERRADO';
      } else {
        if ($('#recaladas-table').data('selected')) {
          $('#descargas-table').DataTable().ajax.url('/api/descargas/' + $('#recaladas-table').data('selected') + '/ABIERTO').load();
        }
        $('#new-descarga').show();
        actionbuttons.find('#edit-btn, #lock-btn').show();
        actionbuttons.find('#unlock-btn').hide().prop('disabled', false);
        descargasEstado = 'ABIERTO';
      }
    });

    descargasOptions = {
      loadUrl: null,
      actionButtons:
      <?php if (array_in_array(['rmp_descarga_lock'], $current_user['privilegios'])): ?>
      '<button onclick="javascript:lockEntity(\'/descarga_encabezados/lock/\', $(\'#descargas-table\'));" id="lock-btn" class="btn btn-xs"><i class="fa fa-lock"></i> Cerrar</button> ' +
      <?php else: ?>
      '<button id="lock-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-lock"></i> Cerrar</button> ' +
      <?php endif; ?>
      <?php if (array_in_array(['rmp_descarga_unlock'], $current_user['privilegios'])): ?>
      '<button onclick="javascript:unlockEntity(\'/descarga_encabezados/unlock/\', $(\'#descargas-table\'));" id="unlock-btn" class="btn btn-xs" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
      <?php else: ?>
      '<button id="unlock-btn" class="btn btn-xs" disabled="disabled" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
      <?php endif; ?>
      <?php if (array_in_array(['rmp_descarga_edit'], $current_user['privilegios'])): ?>
      '<button onclick="javascript:editEntity(\'Editar Descarga - \'+naveSelected+\' - Zarpe: \'+moment(fechaMarea).format(\'DD-MMM-YYYY\')+\', Recalada: \'+moment.utc(fechaRecalada).format(\'DD-MMM-YYYY\'), \'/descarga_encabezados/edit/\' + recursoSelected + \'/\', editDescargaOptions, msgs.rmp.mareas.descargas);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
      <?php else: ?>
      '<button id="edit-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-edit"></i> Editar</button> ' +
      <?php endif; ?>
      <?php if (array_in_array(['rmp_descarga_delete'], $current_user['privilegios'])): ?>
      '<button onclick="deleteEntity(\'/descarga_encabezados/delete/\', $(\'#descargas-table\'))" id="delete-btn" class="btn btn-xs"><i class="fa fa-trash-o"></i> Borrar</button>'
      <?php else: ?>
      '<button id="delete-btn" class="btn btn-xs" disabled="disabled"><i class="fa fa-trash-o"></i> Borrar</button>'
      <?php endif; ?>,
      dataColumns: [{
        "data": "codigo_descarga"
      }, {
        "data": "tipo_descarga.tipo_descarga"
      }, {
        "data": "movimiento.movimiento"
      }, {
        "data": {
          "_": function (row) { return row?moment.utc(row.inicio_desembarque).format('DD-MMM-YYYY HH:mm'):null;},
          "sort": "inicio_desembarque"}
      }, {
        "data": {
          "_": function (row) { return row?moment.utc(row.termino_desembarque).format('DD-MMM-YYYY HH:mm'):null;},
          "sort": "termino_desembarque"}
      }, {
        "data": function(row) {return row.estado.nombre+' - '+row.estado.id},
      }],
      rowCallback: function(row, data, index) {
        $('td:eq(3)', row).data('fecha', data.inicio_desembarque);
        $('td:eq(4)', row).data('fecha', data.termino_desembarque);
      },
      selectCallback: function(id, row) {
        if (!id) {
          row.removeClass('selected');
        }
      }
    }

    newDescargaOptions = {
      dialogSize: BootstrapDialog.SIZE_WIDE,
      oTable: $('#descargas-table'),
      sTableReloadPage: function() {
        return '/api/descargas/' + $('#recaladas-table').data('selected') + '/' + descargasEstado;
      },
      fnCreateCallback: function($message) {
        $('form', $message).append('<input type="hidden" value="' + $('#recaladas-table').data('selected') + '" name="recalada_id" id="recalada-id">');

        if (naveData.regimen_id == 2) {
          switch (naveData.zona_operacion_id) {
            case 1:
            zonaPesca = '114';
            break; //VALDIVIA
            case 2:
            zonaPesca = '115';
            break; //CORONEL
            case 3:
            zonaPesca = '113';
            break; //TALCAHUANO
            case 4:
            zonaPesca = '112';
            break; //SAN ANTONIO
          }
          $('[name="descarga_detalles[0][zona_pesca]"]', $message).val(zonaPesca);
        }
      },
      fnPreCreate: function() {
        if (!$('#recaladas-table').data('selected')) {
          warningNotify('Debe seleccionar una recalada primero.');
          return false;
        }
        return true;
      }
    }

    editDescargaOptions = {
      dialogSize: BootstrapDialog.SIZE_WIDE,
      oTable: $('#descargas-table'),
      sTableReloadPage: function() {
        return '/api/descargas/' + $('#recaladas-table').data('selected') + '/' + descargasEstado;
      }
    }

    // Botones para nuevas Entidades
    $('#new-nave').click(function(e) {
      e.stopPropagation();
      newEntity('Nueva Nave', '/naves/add/');
    });
    $('#new-capitan').click(function(e) {
      e.stopPropagation();
      newEntity('Nuevo Capitan', '/auxiliares/add/capitan', {
        dialogSize: BootstrapDialog.SIZE_WIDE
      });
    });
    $('#new-puerto').click(function(e) {
      e.stopPropagation();
      newEntity('Nuevo Puerto', '/puertos/add/');
    });
    $('#new-ponton').click(function(e) {
      e.stopPropagation();
      newEntity('Nuevo Ponton', '/pontones/add');
    });

    // Se inicializan las datatables
    dataTableEntityInit($('#mareas-table'), mareasOptions);
    dataTableEntityInit($('#recaladas-table'), recaladasOptions);
    dataTableEntityInit($('#descargas-table'), descargasOptions);
  });
  </script>
  <?= $this->end() ?>
