<?php
$this->extend('/Common/view');
$this->assign('title', 'Control de Cuotas');
$this->Html->addCrumb('RMP', ['controller' => 'Home', 'action' => 'index', '#' => 'rmp']);
$this->Html->addCrumb('Control de Cuotas');
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
            <span class="widget-caption">Licencias de Pesca</span>
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
                  <?php if (true || array_in_array(['cuota_derecho_add'], $current_user['privilegios'])): ?>
                  <button id="new-resolucion-derecho" onclick="javascript:newEntity('Nueva Licencia', '/resolucion_derechos/add/', newResolucionDerechoOptions, msgs.cuotas.resder);" class="btn btn-default">
                    Nueva Licencia
                  </button>
                  <?php else: ?>
                  <button id="new-resolucion-derecho" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                    Nueva Licencia
                  </button>
                  <?php endif; ?>
                </div>
                <div class="col-md-4 col-sm-6">
                  <div class="input-group input-group-xs input-small pull-right">
                    <span class="input-group-addon">Especie</span>
                    <select name="especie" id="derechos-especie-id" class="input-xs form-control">
                      <option value="1">Sardina</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="checkbox pull-right">
                    <label>
                      <input type="checkbox" id="ver-resoluciones-cuotas-historicas" class="form-control">
                      <span class="text">Ver Historico</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <table class="table table-hover table-striped table-bordered" id="resoluciones-derechos-table">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Cod. Resolución</th>
                  <th>Especie</th>
                  <th>Macro Zona</th>
                  <th>% Cuota Global</th>
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
            <span class="widget-caption">Resoluciones de Cuota</span>
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
                  <?php if (true || array_in_array(['cuota_cuota_add'], $current_user['privilegios'])): ?>
                  <button id="new-resolucion-cuota" onclick="javascript:newEntity('Nueva Resolución', '/resolucion_cuotas/add/', newResolucionCuotaOptions, msgs.cuotas.resder);" class="btn btn-default pull-left">
                    Nueva Resolución
                  </button>
                  <?php else: ?>
                  <button id="new-resolucion-derecho" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                    Nueva Resolución
                  </button>
                  <?php endif; ?>
                </div>
                <div class="col-md-4 col-sm-6">
                  <div class="input-group input-group-xs input-small pull-right">
                    <span class="input-group-addon">Especie</span>
                    <select name="especie" id="cuotas-especie-id" class="input-xs form-control">
                      <option value="1">Sardina</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="checkbox pull-right">
                    <label>
                      <input type="checkbox" id="ver-resoluciones-cuotas-historicas" class="form-control">
                      <span class="text">Ver Historico</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="col-sm-12">
                  <legend>Resoluciones Activas</legend>
                </div>
                <div class="col-sm-12">
                  <table class="table table-striped table-hover table-bordered" id="resoluciones-cuotas-activas-table">
                    <thead>
                      <tr role="row">
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Disponible</th>
                        <th>Porcentaje</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-1 hidden-sm hidden-xs" style="height:430px; padding-top:200px">
                <button class="btn add-detalle" id="add-detalle"><i class="fa fa-chevron-right"></i></button>
                <button class="btn delete-detalle" id="delete-detalle"><i class="fa fa-chevron-left"></i></button>
              </div>
              <div class="col-md-1 hidden-lg hidden-md centered" style="padding-top: 10px; padding-bottom: 10px">
                <button class="btn add-detalle" id="add-detalle"><i class="fa fa-chevron-down"></i></button>
                <button class="btn delete-detalle" id="delete-detalle"><i class="fa fa-chevron-up"></i></button>
              </div>
              <div class="col-md-5">
                <div class="col-sm-12">
                  <legend>Resoluciones Inactivas</legend>
                </div>
                <div class="col-sm-12">
                  <table class="table table-striped table-hover table-bordered" id="resoluciones-cuotas-inactivas-table">
                    <thead>
                      <tr role="row">
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Disponible</th>
                        <th>Porcentaje</th>
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
      </div>
    </div>

    <?= $this->append('jquery') ?>
      <script>
        $(document).ready(function() {
          // Se crean los select2
          $('select').select2();

          /*******************************************************
          *  -- RESOLUCIONES DERECHOS --
          ********************************************************/

          resolucionDerechosOptions = {
            "processing": true,
            loadUrl: '/api/resolucion_derechos/' + $('#derechos-especie-id').val() + '.json',
            ajax: {
              'url': '/api/resolucion_derechos/' + $('#derechos-especie-id').val() + '.json',
              'type': 'GET',
              'dataType': 'json',
              'dataSrc': 'resolucionDerechos'
            },
            actionButtons:
            <?php if (true || array_in_array(['rmp_marea_edit'], $current_user['privilegios'])): ?>
            '<button onclick="javascript:editEntity(\'Editar Marea\', \'/mareas/edit/\', editMareaOptions, msgs.rmp.mareas.mareas);" id="edit-btn" class="btn btn-xs"><i class="fa fa-edit"></i> Editar</button> ' +
            <?php else: ?>
            '<button id="edit-btn" class="btn btn-xs" disabled><i class="fa fa-edit"></i> Editar</button> ' +
            <?php endif; ?>
            <?php if (true || array_in_array(['rmp_marea_delete'], $current_user['privilegios'])): ?>
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
                "data": "id"
              }, {
                "name": "Mareas.fecha_zarpe",
                "data": "id"
              }, {
                "name": "Nro_Recaladas",
                "sortable": false,
                "data": function(row) {return row.id;}
              }, {
                "name": "Estados.id",
                "data": "id",
                "sortable": false
              }
            ]
          };

          newResolucionDerechoOptions = {
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

          /*******************************************************
          *  -- RESOLUCIONES CUOTAS --
          ********************************************************/

          newResolucionCuotaOptions = {
            oTable: $('#resoluciones-cuotas-activas-table'),
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

          // Se inicializan las datatables
          dataTableEntityInit($('#resoluciones-derechos-table'), resolucionDerechosOptions);
          // dataTableEntityInit($('#resoluciones-cuotas-activas-table'), resolucionCuotasActivasOptions);
          // dataTableEntityInit($('#resoluciones-cuotas-inactivas-table'), resolucionCuotasInactivasOptions);

        });
      </script>
      <?= $this->end() ?>
