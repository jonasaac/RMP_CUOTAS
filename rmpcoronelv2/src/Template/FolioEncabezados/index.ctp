<?php
$this->extend('/Common/view');
$this->assign('title', 'Folios');
$this->Html->addCrumb('Producción', ['controller' => 'Home', 'action' => 'index', '#' => 'produccion']);
$this->Html->addCrumb('Folios');
$this->Html->addCrumb($recurso->nombre);

// Se agrega script para hacer scroll
$this->Html->script('scrollTo/jquery.scrollTo.min.js', ['block' => true]);

//Permisos
$is_admin = array_in_array(['admin'], $current_user['privilegios']);

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
          <span class="widget-caption">Folios</span>
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
              <div class="col-md-8 col-sm-6">
                <?php if(array_in_array(['produccion_folio_add'], $current_user['privilegios'])): ?>
                  <button id="new-folio"
                  onclick="javascript:newEntity('Nuevo Folio',
                  '/folio_encabezados/add/',
                  newFolioOptions,
                  msgs.produccion.folios.encabezado);"
                  class="btn btn-default">
                  Nuevo Folio
                </button>
              <?php else: ?>
                <button id="new-folio" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                  Nuevo Folio
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="input-group input-group-xs input-small pull-right">
                <span class="input-group-addon">Año</span>
                <?= $this->Form->input('folios-year', ['options' => $years, 'class' => 'input-xs form-control']) ?>
              </div>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-folios-cerrados">
                  <span class="text">Ver Folios Cerrados</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="folios-table">
          <thead>
            <tr>
              <th>Nro Folio</th>
              <th>Fecha Recepción</th>
              <th>Lotes (A/T)</th>
              <th>Especie</th>
              <th>Total CJS</th>
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
          <span class="widget-caption">Lotes</span>
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
                <?php if(array_in_array(['produccion_folio_add'], $current_user['privilegios'])): ?>
                  <button id="new-lote"
                  onclick="javascript:newEntity('Nuevo Lote',
                  '/lote_encabezados/add/' + folioSelected,
                  newLoteOptions,
                  msgs.produccion.lotes);"
                  class="btn btn-default">
                  Nuevo Lote
                </button>
              <?php else: ?>
                <button id="new-lote" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                  Nuevo Lote
                </button>
              <?php endif; ?>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" class="form-control" id="ver-lotes-cerrados">
                  <span class="text">Ver Lotes Cerrados</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="lotes-table">
          <thead>
            <tr>
              <th></th>
              <th>Secuencial</th>
              <th>CJS PT Totales</th>
              <th>KLS PT Totales</th>
              <th>Rendimiento</th>
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
  $('#folios-year').select2();

  /*********************************************************
  *  -- VARIABLES GLOBALES DEL MODULO --
  ********************************************************/

  foliosEstado = 'ABIERTO';
  lotesEstado = 'ABIERTO';
  folioSelected = null;

  /*********************************************************
  *  -- FOLIOS --
  ********************************************************/

  $('#folios-year').on('change', function() {
    console.debug('Se realiza un cambio de año');
    $('#folios-table').dataTable().DataTable().ajax.url('/api/folios/' + $(this).val() + '/' + foliosEstado).load();
    $('#lotes-table').DataTable().clear().draw();
  });

  $('#ver-folios-cerrados').change(function () {
    var actionbuttons = $('#folios-table').parents('.dataTables_wrapper').find('.action-buttons');

    $('#folios-table').data('selected', null);
    $('#lotes-table').DataTable().clear().draw();

    if( $(this).is(':checked') ) {
      foliosEstado = 'CERRADO';
      $('#folios-table').DataTable().ajax.url( '/api/folios/' + $('#folios-year').val() + '/CERRADO').load();
      $('#new-folio').hide();
      actionbuttons.find('#edit-btn').hide();
      actionbuttons.find('#lock-btn').hide();
      actionbuttons.find('#unlock-btn').show();
    } else {
      folioEstado = 'ABIERTO';
      $('#folios-table').DataTable().ajax.url( '/api/folios/' + $('#folios-year').val() + '/ABIERTO').load();

      $('#new-folio').show();
      actionbuttons.find('#edit-btn').show();
      actionbuttons.find('#lock-btn').show();
      actionbuttons.find('#unlock-btn').hide();
    }
  });

  foliosOptions = {
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: '/api/folios/' + $('#folios-year').val(),
      type: 'post'
    },
    loadUrl: '/api/folios/' + $('#folios-year').val(),
    actionButtons: <?php if(array_in_array(['produccion_folio_lock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:lockEntity(\'/folio_encabezados/lock/\', $(\'#folios-table\'));" id="lock-btn" class="btn btn-xs"><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php else: ?>
    '<button id="lock-btn" class="btn btn-xs" disabled><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['produccion_folio_unlock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:unlockEntity(\'/folio_encabezados/unlock/\', $(\'#folios-table\'));" id="unlock-btn" class="btn btn-xs" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php else: ?>
    '<button id="unlock-btn" class="btn btn-xs" style="display: none;" disabled><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['produccion_folio_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Folio\', \'/folio_encabezados/edit/\', editFolioOptions, msgs.produccion.folios.encabezado)"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['produccion_folio_delete'], $current_user['privilegios'])): ?>
    '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/folio_encabezados/delete/\', $(\'#folios-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {"data": "nro_folio"},
      {"data": {
        "_": function (row) { return row?moment.utc(row.fecha_recepcion).format('DD-MMM-YYYY'):null;},
        "sort": "fecha_recepcion"
      }},
      //{"data": function (row) { return row?'<strong>' + toggleNumberFormat(row.rendimiento, 2) + ' %</strong>':'-';}},
      {"data": function (row) { return row?row.nro_lotes:'-';}},
      {"data": "especie"},
      {"data": function (row){ return row?toggleNumberFormat(row.total_cajas):'-'}}
    ],
    rowCallback: function (nRow, aData, iDisplayIndex) {
      $('td:eq(2)', nRow).data("fecha", aData.fecha_recepcion);
      return nRow;
    },
    selectCallback: function(id, row) {
      console.log('/api/lotes/' + id + '/' + lotesEstado);
      if (id) {
        $('#lotes-table').dataTable().DataTable().ajax.url('/api/lotes/' + id + '/' + lotesEstado).load();
        folioSelected = id;
      } else {
        row.removeClass('selected');
      }
    },
    unselectCallback: function() {
      $('#lotes-table').DataTable().clear().draw();
      folioSelected = null;
    }
  }


  newFolioOptions = {
    dialogSize: BootstrapDialog.SIZE_WIDE,
    oTable: $('#folios-table'),
    sTableReloadPage: '/api/folios/' + $('#folios-year').val(),
    fnPreSubmit: function () {
      if (!detallesData.length) {
        console.debug('Folio sin detalles!');
        errorNotify(msgs.produccion.folios.detalles.emptySave);
        return false;
      }
      return true;
    },
    fnCreateCallback: function ($message) {

    }
  }
  editFolioOptions = {
    dialogSize: BootstrapDialog.SIZE_WIDE,
    oTable: $('#folios-table'),
    sTableReloadPage: '/api/folios/' + $('#folios-year').val(),
    fnPreSubmit: function () {
      if (!detallesData.length) {
        console.debug('Folio sin detalles!');
        errorNotify(msgs.produccion.folios.detalles.emptySave);
        return false;
      }
      return true;
    },
    fnCreateCallback: function ($message) {
    }
  }

  /*********************************************************
  *  -- LOTES --
  ********************************************************/

  $('#ver-lotes-cerrados').change(function () {
    var actionbuttons = $('#lotes-table').parents('.dataTables_wrapper').find('.action-buttons');

    $('#lotes-table').data('selected', null);

    if( $(this).is(':checked') ) {
      lotesEstado = 'CERRADO';
      $('#lotes-table').DataTable().ajax.url( '/api/lotes/' + $('#folios-table').data('selected') + '/CERRADO').load();
      $('#new-lote').hide();
      actionbuttons.find('#edit-btn').hide();
      actionbuttons.find('#lock-btn').hide();
      actionbuttons.find('#unlock-btn').show();
    } else {
      lotesEstado = 'ABIERTO';
      $('#lotes-table').DataTable().ajax.url( '/api/lotes/' + $('#folios-table').data('selected') + '/ABIERTO').load();

      $('#new-lote').show();
      actionbuttons.find('#edit-btn').show();
      actionbuttons.find('#lock-btn').show();
      actionbuttons.find('#unlock-btn').hide();
    }
  });

  lotesOptions = {
    loadUrl: null,
    tableType: 'EXPANDABLE',
    tableSelector: 'tr.details table>tbody>tr',
    allowDetailsClick: true,
    expandedContent: function (data) {
      var $rows = $('<tbody></tbody>');
      $.each(data.lotes, function (i, lote) {
        var sRow = '<tr>';
        sRow += '<td>'+lote.lote+'</td>';
        sRow += '<td>'+toggleNumberFormat(Number(lote.cajas_totales), 0)+'</td>';
        sRow += '<td>'+toggleNumberFormat(Number(lote.kilos_totales), 3)+'</td>';
        sRow += '<td>'+lote.calibres+'</td>';
        sRow += '</tr>';
        var $row = $(sRow);
        $row.data('id', lote.id);
        $row.data('data', lote);
        $rows.append($row);
      });

      var $tempTable = $('<table class="table-lotes table table-bordered table-striped table-hover no-padding"><thead><tr><th>Lote</th><th>CJS PT Total</th><th>KLS PT Total</th><th>Calibres</th></tr></thead></table>');
      $('thead', $tempTable).after($rows);

      return $tempTable;
    },
    actionButtons: <?php if(array_in_array(['produccion_folio_lock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:lockEntity(\'/lote_encabezados/lock/\', $(\'#lotes-table\'));" id="lock-btn" class="btn btn-xs"><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php else: ?>
    '<button id="lock-btn" class="btn btn-xs" disabled><i class="fa fa-lock"></i> Cerrar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['produccion_folio_unlock'], $current_user['privilegios'])): ?>
    '<button onclick="javascript:unlockEntity(\'/lote_encabezados/unlock/\', $(\'#lotes-table\'));" id="unlock-btn" class="btn btn-xs" style="display: none;"><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php else: ?>
    '<button id="unlock-btn" class="btn btn-xs" style="display: none;" disabled><i class="fa fa-unlock"></i> Abrir</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['produccion_folio_edit'], $current_user['privilegios'])): ?>
    '<button id="edit-btn" class="btn" onClick="editEntity(\'Editar Lote\', function() {return \'/lote_encabezados/edit/\'+ folioSelected + \'/\';}, editLoteOptions, msgs.produccion.lotes.encabezado)"><i class="fa fa-edit"></i> Editar</button> ' +
    <?php else: ?>
    '<button id="edit-btn" class="btn" disabled><i class="fa fa-edit"></i> Editar</button> ' +
    <?php endif; ?>
    <?php if(array_in_array(['produccion_folio_delete'], $current_user['privilegios'])): ?>
    '<button id="delete-btn" class="btn" onclick="deleteEntity(\'/lote_encabezados/delete/\', $(\'#lotes-table\'))"><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php else: ?>
    '<button id="delete-btn" class="btn" disabled><i class="fa fa-trash-o"></i> Borrar</button>'
    <?php endif; ?>,
    dataColumns: [
      {
        "data": null,
        "defaultContent": '<i class="fa fa-plus-square-o row-details fa-lg"></i>',
        "sortable": false
      },
      {"data": "secuencial"},
      {"data": function (row) {return toggleNumberFormat(row.total_cjs_pt, 0);}},
      {"data": function (row) {return toggleNumberFormat(row.total_kls_pt, 3);}},
      {"data": function (row) {return '<strong>' + toggleNumberFormat(row.rendimiento, 2) + ' %</strong>';}},
      {
          "data": function (row) {
              return row.estado.nombre + ' - ' + row.estado.id;
          }
      },
    ],
    rowCallback: function (nRow, aData, iDisplayIndex) {
      $('td:eq(2)', nRow).data("fecha", aData.fecha_recepcion);
      return nRow;
    }
  }

  newLoteOptions = {
    dialogSize: BootstrapDialog.SIZE_WIDE,
    oTable: $('#lotes-table'),
    sTableReloadPage: function() {
      return '/api/lotes/' + $('#folios-table').data('selected') + '/' + lotesEstado;
    },
    fnPreCreate: function() {
      if (!$('#folios-table').data('selected')) {
        warningNotify('Debe seleccionar un folio primero.');
        return false;
      }
      return true;
    },
    fnCreateCallback: function ($message) {
    }
  }
  editLoteOptions = {
    dialogSize: BootstrapDialog.SIZE_WIDE,
    oTable: $('#lotes-table'),
    sTableReloadPage: function() {
      return '/api/lotes/' + $('#folios-table').data('selected') + '/' + lotesEstado;
    },
    fnCreateCallback: function ($message) {
    }
  }

  dataTableEntityInit($('#folios-table'), foliosOptions);
  dataTableEntityInit($('#lotes-table'), lotesOptions);
});
</script>
<?= $this->end() ?>
