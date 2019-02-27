<?php
$this->extend('/Common/view');
$this->assign('title', 'Estado de Cuotas');
$this->Html->addCrumb('Control de Cuotas', ['controller' => 'Home', 'action' => 'index', '#' => 'cuotas']);
$this->Html->addCrumb('Estado');
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
        <span class="widget-caption">Estado Cuotas</span>
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
        <div class="tabbable">
          <ul class="nav nav-tabs nav-justified" id="tabs">
            <li class="tab-red">
              <a data-toggle="tab" href="#total">Total</a>
            </li>
            <!--<li class="active">
              <a data-toggle="tab" href="#macro-zona">Macro Zona</a>
            </li> -->
            <li class="active">
              <a data-toggle="tab" href="#cuota-langostinos">Estado Cuota de Langostinos</a>
            </li>
          </ul>

          <div class="tab-content">
            <!-- TAB Total -->
            <div id="total" class="tab-pane">
              <div class="table-toolbar">
                <div class="row">
                  <div class="col-md-8 col-sm-6">
                      <div class="form-group">
                        <select name="especie" id="especies-select" class="form-control input-xs" data-placeholder="Especies a Mostrar" lang="es" multiple="multiple" style="width:100%;">
                          <?php foreach($especies as $especie): ?>
                            <option value="<?=$especie->Especies->id?>" selected><?=$especie->Especies->nombre?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                    <div class="form-group input-small pull-right">
                      <select name="years_total_select" id="year-total" class="form-control input-xs year-select" data-placeholder="Año" lang="es" style="width:100%;">
                        <?php foreach($years as $year): ?>
                          <option value="<?=$year?>"><?=$year?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <table class="table table-hover table-striped table-bordered" id="estado-total-table">
                <thead>
                  <tr id="meses-nombre">
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

            <!-- TAB macro_zona -->
            <div id="macro-zona" class="tab-pane">

            </div>

            <!-- cuotas langostinos -->
            <div id="cuota-langostinos" class="tab-pane active">
              <div class="table-toolbar">
                <div class="row">
                  <div class="col-md-8 col-sm-6">
                    <?php if (array_in_array(['cuotas_estado_add'], $current_user['privilegios'])): ?>
                    <button id="new-operacion" onclick="javascript:newEntity('Nuevo Estado de las Cuotas', '/estados_cuota/add/');" class="btn btn-default pull-left">
                      Registrar Estado de las Cuotas
                    </button>
                    <?php else: ?>
                    <button id="new-operacion" onclick="javascript:;" class="btn btn-default" disabled="disabled">
                      Registrar Estado de las Cuotas
                    </button>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-4 col-sm-6">
                    <div class="form-group input-small pull-right">
                      <select name="years_langostinos_select" id="year-langostinos-select" class="form-control input-xs year-select" data-placeholder="Año" lang="es" style="width:100%;">
                        <?php foreach($years as $year): ?>
                          <option value="<?=$year?>"><?=$year?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <legend>Langostino Amarillo</legend>
              <table class="table table-hover table-striped table-bordered" id="cuota-langostino-amarillo-table">
                <thead>
                  <tr id="macro-zonas-langostino-amarillo">
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <hr>
              <legend>Langostino Colorado</legend>
              <table class="table table-hover table-striped table-bordered" id="cuota-langostino-colorado-table">
                <thead>
                  <tr id="macro-zonas-langostino-colorado">
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('jquery'); ?>
<script>
    var meses = [
        {id: "1", nombre: "Enero"},
        {id: "2", nombre: "Febrero"},
        {id: "3", nombre: "Marzo"},
        {id: "4", nombre: "Abril"},
        {id: "5", nombre: "Mayo"},
        {id: "6", nombre: "Julio"},
        {id: "7", nombre: "Junio"},
        {id: "8", nombre: "Agosto"},
        {id: "9", nombre: "Septiembre"},
        {id: "10", nombre: "Octubre"},
        {id: "11", nombre: "Noviembre"},
        {id: "12", nombre: "Diciembre"},
    ];

    $(document).ready(function() {
      $('select.year-select').select2();

      $('.widget-body').on('show.bs.tab', 'a[data-toggle="tab"]', function(e) {
        var target = e.target.hash
        if (target == '#total') {
          loadTotalTab();
        } else if (target == '#cuota-langostinos') {
          loadCuotaLangostinosTab();
        }
      });

      /** Funciones Axuliares para carga de Info */
      createCabecera = function () {
        $('#meses-nombre').html("<th></th>");
        $.each(meses, function(i, val) {
          var cabecera = "<th>" + val.nombre + "</th>";
          $('#meses-nombre').append(cabecera);
        });
      };

      updateTotalTable = function() {
        // $("#estado-total-table tbody").empty();
        $.each(showed_especies, function(i, especie) {
          if ($('#estado-total-table tbody').find('tr[data-especieId="'+especie.id+'"]').length) {return true;}

          var fila = '<tr role="row" data-especieId="' + especie.id + '"><td class="head">' + especie.nombre + '</td>';
          for (i=0;i<12;++i) {
            fila += '<td role="cell" class="cell-num" data-mes="'+ (i+1) +'">' + '0,000' + '</td>';
          }
          fila += "</tr>";
          $("#estado-total-table tbody").append(fila);
          $.ajax({
            url: '/api/estado_cuotas/totales_por_mes.json?year=' + $('#year-select').val() + '&especie=' + especie.id,
            type: 'GET',
            dataType: 'json'
          }).done(function (data) {
            $.each(data.totales_captura, function(i, e){
              $('#estado-total-table tbody')
                .find('tr[data-especieId="'+e.especie_id+'"] td[data-mes="'+e.mes+'"]')
                .html(toggleNumberFormat(e.total));
            });
          });
        });
      };

      operaciones_langostino_amarillo = [];
      macro_zonas_langostino_colorado = [];
      createCabeceraLangostinos = function () {
        $('#macro-zonas-langostino-amarillo').html("<th></th>");
        $.ajax({
          url: '/api/operaciones/obtenerTotalPorEspecie.json?especie=9&macro_zonas=true',
          type: 'GET',
          dataType: 'json'
        })
        .done(function (data) {
          operaciones_langostino_amarillo = data.operaciones;
          console.log(data.operaciones);
          $.each(data.operaciones, function(i, val) {
            var cabecera = '<th><a class="detalle-macro-zona" data-macroZonaId="'+val.macro_zona.id+'" data-especieId="9">' + val.macro_zona.nombre + '<span class="pull-right"><b>' +  val.total + "</b></span></a></th>";
            $('#macro-zonas-langostino-amarillo').append(cabecera);
          });
          updateLangistinosATables();
        });

        $('#macro-zonas-langostino-colorado').html("<th></th>");
        $.ajax({
          url: '/api/macro_zonas/obtenerPorEspecie.json?especie=10',
          type: 'GET',
          dataType: 'json'
        })
        .done(function (data) {
          macro_zonas_langostino_colorado = data.macro_zonas;
          $.each(data.macro_zonas, function(i, val) {
            var cabecera = "<th>" + val.nombre + "</th>";
            $('#macro-zonas-langostino-colorado').append(cabecera);
          });
          updateLangistinosCTables();
        });
      };

      updateLangistinosATables = function() {
        $('#cuota-langostino-amarillo-table tbody').html("");
        $.each(meses, function (i, mes) {
          var fila = '<tr role="row" data-mes="' + mes.id + '"><td class="head">' + mes.nombre + '</td>';
          $.each(operaciones_langostino_amarillo, function(i, operacion) {
            fila += '<td role="cell" class="cell-num" data-macroZonaId="'+operacion.macro_zona.id+'">' + '0,000' + '</td>';
          });
          fila += "</tr>";
          $("#cuota-langostino-amarillo-table tbody").append(fila);
        });
      };
      updateLangistinosCTables = function() {
        $('#cuota-langostino-colorado-table tbody').html("");
        $.each(meses, function (i, mes) {
          var fila = '<tr role="row" data-mes="' + mes.id + '"><td class="head">' + mes.nombre + '</td>';
          $.each(macro_zonas_langostino_colorado, function(i, macro_zona) {
            fila += '<td role="cell" class="cell-num" data-macroZonaId="'+macro_zona.id+'">' + '0,000' + '</td>';
          });
          fila += "</tr>";
          $("#cuota-langostino-colorado-table tbody").append(fila);
        });
      };
      /** FIN Funciones Axuliares para carga de Info */

      /** Carga la información del tab de Total **/
      loadTotalTab = function () {
        especies = []
        $.ajax({
          url: '/api/especies.json',
          dataType: 'json',
          type: 'GET'
        })
        .done( function(data) {
          especies = data.especies;
          $('#especies-select').trigger('change');
        });
        $('#especies-select').select2();

        $('#year-select').on('change', function() {
          updateTotalTable();
        });

        showed_especies = [];
        $('#especies-select').on('change', function() {
          var selected_especies = $(this).val();
          $.each(showed_especies, function(i, val) {
            if (!selected_especies || selected_especies.indexOf(val.id.toString()) == -1) {
              $('#estado-total-table tbody').find('tr[data-especieId="'+val.id+'"]').remove();
            }
          });
          showed_especies = [];
          $.each(especies, function(i, val) {
            if (selected_especies && selected_especies.indexOf(val.id.toString()) != -1) {
              showed_especies.push(val);
            }
          });
          updateTotalTable();
        });
        createCabecera();
      };
      /** FIN Carga la información del tab de Total **/

      /** Carga la informacion del tab de Langostinos **/
      createCabeceraLangostinos();  // Inicialmente carga langostinos
      loadCuotaLangostinosTab = function () {
        createCabeceraLangostinos();
      }
      /** FIN Carga la informacion del tab de Langostinos **/

      /** Mostrar detalle de cuotas **/
      $('table').on('click', '.detalle-macro-zona', function () {
        console.log($(this).data());
      });
      /** FIN Mostrar detalle de cuotas **/
    });
</script>
<?php $this->end(); ?>
