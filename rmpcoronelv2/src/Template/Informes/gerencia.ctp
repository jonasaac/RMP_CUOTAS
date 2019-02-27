<div class="row">
  <div class="col-md-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption"></span>
      </div>
      <div class="widget-body">
        <div class="row">
          <div class="col-md-6">
            <form method="post" action="/informes/gerencia">
              <label class="col-sm-3 control-label">Fecha de Consulta</label>
              <div class="col-sm-6">
                <div class="input-group input-group-xs date-picker" id="fecha-consulta-container">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input name="fecha_consulta" id="fecha-consulta" type="text" class="form-control">
                  <input type="hidden" name="fecha_consulta_unix" id="fecha-consulta-unix">
                </div>
              </div>
              <div class="col-sm-1">
                <button type="submit" class="btn" id="update-btn">Ir</button>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <label class="col-sm-3 control-label">Exportar a Excel</label>
            <div class="col-sm-9">
              <a href="/informes/gerenciaExcel/<?=$fechaConsulta?>" class="btn">Exportar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Pesca de Flota</span>
      </div>
      <div class="widget-body">
        <h3>Flota Industrial Jurel</h3>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nombre Nave</th>
              <th>Toneladas Diarias</th>
              <th>Toneladas Semanales</th>
              <th>Toneladas Mensuales</th>
              <th>Toneladas Anuales</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($totalesIndustrialJurel as $nombre => $total): ?>
            <tr>
              <td><?=$nombre?></td>
              <td class="diario"><?=$total['diario']?></td>
              <td class="semanal"><?=$total['semanal']?></td>
              <td class="mensual"><?=$total['mensual']?></td>
              <td class="anual"><?=$total['anual']?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td>Total</td>
              <td class="total diario">Diario</td>
              <td class="total semanal">Semanal</td>
              <td class="total mensual">Mensual</td>
              <td class="total anual">Anual</td>
            </tr>
          </tfoot>
        </table>

        <h3>Flota Industrial Sardina</h3>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nombre Nave</th>
              <th>Toneladas Diarias</th>
              <th>Toneladas Semanales</th>
              <th>Toneladas Mensuales</th>
              <th>Toneladas Anuales</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($totalesIndustrialSardina as $nombre => $total): ?>
            <tr>
              <td><?=$nombre?></td>
              <td class="diario"><?=$total['diario']?></td>
              <td class="semanal"><?=$total['semanal']?></td>
              <td class="mensual"><?=$total['mensual']?></td>
              <td class="anual"><?=$total['anual']?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td>Total</td>
              <td class="total diario">Diario</td>
              <td class="total semanal">Semanal</td>
              <td class="total mensual">Mensual</td>
              <td class="total anual">Anual</td>
            </tr>
          </tfoot>
        </table>

        <h3>Flota Artesanal</h3>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nombre Nave</th>
              <th>Toneladas Diarias</th>
              <th>Toneladas Semanales</th>
              <th>Toneladas Mensuales</th>
              <th>Toneladas Anuales</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($totalesArtesanalSardina as $nombre => $total): ?>
            <tr>
              <td><?=$nombre?></td>
              <td class="diario"><?=$total['diario']?></td>
              <td class="semanal"><?=$total['semanal']?></td>
              <td class="mensual"><?=$total['mensual']?></td>
              <td class="anual"><?=$total['anual']?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td>Total</td>
              <td class="total diario">Diario</td>
              <td class="total semanal">Semanal</td>
              <td class="total mensual">Mensual</td>
              <td class="total anual">Anual</td>
            </tr>
          </tfoot>
        </table>

        <h3>Total Entradas</h3>
        <table id="total-entradas-table" class="table table-striped table-bordered">
          <tfoot>
            <tr>
              <td>Total</td>
              <td class="total diario">Diario</td>
              <td class="total semanal">Semanal</td>
              <td class="total mensual">Mensual</td>
              <td class="total anual">Anual</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Plantas</span>
      </div>
      <div class="widget-body">
        <h3>Destino Pesca</h3>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nombre Nave</th>
              <th>Toneladas Diarias</th>
              <th>Toneladas Semanales</th>
              <th>Toneladas Mensuales</th>
              <th>Toneladas Anuales</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($totalesPlantas as $nombre => $total): ?>
            <tr>
              <td><?=$nombre?></td>
              <td class="diario"><?=$total['diario']?></td>
              <td class="semanal"><?=$total['semanal']?></td>
              <td class="mensual"><?=$total['mensual']?></td>
              <td class="anual"><?=$total['anual']?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td>Total</td>
              <td class="total diario">Diario</td>
              <td class="total semanal">Semanal</td>
              <td class="total mensual">Mensual</td>
              <td class="total anual">Anual</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->start('jquery'); ?>
<script type="text/javascript">
  $(document).ready(function () {
    $('#fecha-consulta-container').val(moment().format('DD-MMM-YYYY')).datetimepicker({
      locale: moment.locale('es_CL'),
      useCurrent: true,
      format: 'DD-MMM-YYYY',
      maxDate: moment().subtract(1, 'days'),
      sideBySide: true,
      allowInputToggle: true,
      debug: false
    });

    <?php if($this->request->is(['post'])): ?>
      <?php if( !empty($this->request->data('fecha_consulta')) ): ?>
        $('#fecha-consulta').val('<?= $this->request->data('fecha_consulta') ?>');
        $('#fecha-consulta-unix').val('<?= $this->request->data('fecha_consulta_unix') ?>');
      <?php endif ?>
    <?php endif; ?>

    $('#fecha-consulta-container').on('dp.change', function () {
      var fecha_consulta = $('#fecha-consulta-container').data('DateTimePicker').date();
      fecha_consulta = fecha_consulta.unix();
      $('#fecha-consulta-unix').val(fecha_consulta);
    });

    var cells = $('table:not(#total-entradas-table) tfoot tr td').nextAll(), count = cells.length;
    $('table:not(#total-entradas-table) tfoot tr td').each(function (i, v) {
      if ( $(this).hasClass('total') ) {
        var tmpTotal = 0;
        var totalClass = $(this).attr('class').split(/\s+/)[1];
        $(this).parents('table').find('tbody tr td').each(function () {
          if ( $(this).hasClass( totalClass ) ) {
            tmpTotal += Number($(this).text());
          }
        });

        $(this).text(tmpTotal.toFixed(0));
      }
    }).promise().done(function () {
      $('#total-entradas-table tfoot tr td').each(function (i, v) {
        if ( $(this).hasClass('total') ) {
          var tmpTotal = 0;
          var totalClass = $(this).attr('class').split(/\s+/)[1];
          $(this).parents('div.widget').find('table:not(#total-entradas-table) tfoot tr td').each(function () {
            if ( $(this).hasClass( totalClass ) ) {
              tmpTotal += Number($(this).text());
            }
          });

          $(this).text(tmpTotal.toFixed(0));
        }
      });
    });
  });
</script>
<?php $this->end(); ?>
