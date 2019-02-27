<?php
$this->extend('/Common/view');
$this->assign('title', 'Cuotas');
$this->Html->addCrumb('RMP', ['controller' => 'Home', 'action' => 'index', '#' => 'rmp']);
$this->Html->addCrumb('Cuotas');
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
        <span class="widget-caption">Cuotas</span>
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
          </div>
        </div>
        <table class="table table-hover table-striped table-bordered" id="mareas-table">
          <thead>
            <tr>
              <th>id</th>
              <th>Nave</th>
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

<?= $this->append('jquery') ?>
<script>
$(document).ready(function () {

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

  mareasOptions = {
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: '/api/cuotas',
      type: 'post'
    },
    loadUrl: '/api/cuotas',
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
      }
    ]
  };

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


    // Se inicializan las datatables
    dataTableEntityInit($('#mareas-table'), mareasOptions);

  });
  </script>
  <?= $this->end() ?>
