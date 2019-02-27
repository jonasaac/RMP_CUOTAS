<?php
$this->layout = 'ajax';
if(!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
      <form id="marea-form" class="form-horizontal">
        <legend>Marea</legend>
        <div class="form-group">
            <label class="col-sm-3 control-label">Nave</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select style="width: 100%" class="form-control input-xs" name="nave_id" id="nave-id" data-placeholder="Seleccione una Nave" lang="es">
                  <option value></option>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
                    <a id="new-nave" class="btn btn-default input-xs">Nueva</a>
                  <?php else: ?>
                    <a id="new-nave" class="btn btn-default input-xs" disabled>Nueva</a>
                  <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Arte de Pesca</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" style="width: 100%" name="arte_pesca_id" id="arte-pesca-id" data-placeholder="Seleccione el arte de pesca" lang="es">
                    <option></option>
                    <?php foreach($artePesca as $arte_pesca): ?>
                        <option value="<?=$arte_pesca->id?>" data-recurso-id="<?=$arte_pesca->recurso_id?>"><?=$arte_pesca->nombre?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="recurso-id" name="recurso_id">
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_artePesca_add'], $current_user['privilegios'])): ?>
                    <a id="new-arte-pesca" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-arte-pesca" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Fecha de Zarpe</label>
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-7">
                <div class="input-group input-group-xs date-picker" id="fecha-zarpe-date-container">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input name="fecha_zarpe_date" id="fecha-zarpe-date" type="text" class="form-control">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="input-group input-group-xs time-picker" id="fecha-zarpe-time-container">
                  <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                  <input name="fecha_zarpe_time" id="fecha-zarpe-time" type="text" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Capitán</label>
            <div class="col-sm-9">
              <div class="input-group">
                    <select style="width: 100%" class="form-control input-xs" name="capitan_id" id="capitan-id" data-placeholder="Seleccione un Capitán" lang="es">
                        <option value></option>
                    </select>
                    <div class="input-group-btn">
                    <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                      <a id="new-capitan" class="btn btn-default input-xs">Nuevo</a>
                    <?php else: ?>
                      <a id="new-capitan" class="btn btn-default input-xs" disabled>Nuevo</a>
                    <?php endif; ?>
                    </div>
              </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Puerto Zarpe</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select style="width: 100%" class="form-control input-xs" name="puerto_id" id="puerto-id" data-placeholder="Seleccione un Puerto" lang="es">
                    <option value></option>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_puerto_add'], $current_user['privilegios'])): ?>
                    <a id="new-puerto" class="btn btn-default input-xs">Nuevo</a>
                  <?php else: ?>
                    <a id="new-puerto" class="btn btn-default input-xs" disabled>Nuevo</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Observaciones</label>
          <div class="col-sm-9">
            <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
          </div>
        </div>
      </form>
    </div>
</div>
<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal
    $('#nave-id', $thisModal).select2({
      dropdownParent: $thisModal,
      minimumInputLength: 2,
      ajax: {
        url: '/api/naves/listar_filtrado.json',
        dataType: 'json',
        type: 'GET',
        delay: 350,
        cache: true,
        data: function (params) {
          return {
            q: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;

          var naves = [];
          $.each(data.naves, function(i, nave) {
            naves.push({
              id: nave.id,
              text: nave.nombre,
              capitan_id: nave.capitan_id,
              recursos_ids: nave.recursos_ids
            });
          });
          return {
            results: naves,
            pagination: {
              more: (params.page * 30) < data.total_count
            }
          };
        }
      }
    });
    capitanes = [];
    $.ajax({
      url: '/api/auxiliares/listar_filtrado.json?funcion=capitan',
      type: 'GET',
      dataType: 'json'
    })
    .done(function (data) {
      $.each(data.auxiliares, function(i, capitan) {
        capitanes.push({id: i, text: capitan});
      });
      $('#capitan-id', $thisModal).select2({
        dropdownParent: $thisModal,
        data: capitanes
      });
    });
    $('#capitan-id', $thisModal).select2();
    puertos = [];
    $.ajax({
      url: '/api/puertos/listar_filtrado.json',
      type: 'GET',
      dataType: 'json'
    })
    .done(function (data) {
      $.each(data.puertos, function(i, puerto) {
        puertos.push({id: i, text: puerto});
      });
      $('#puerto-id', $thisModal).select2({
        dropdownParent: $thisModal,
        data: puertos
      });
    });
    $('#puerto-id', $thisModal).select2();
    $('#arte-pesca-id', $thisModal).select2();

    $('#fecha-zarpe-date', $thisModal).val(moment().format('DD-MMM-YYYY'));
    $('#fecha-zarpe-date-container', $thisModal).datetimepicker(dateOptions(moment().utc()));
    $('#fecha-zarpe-time', $thisModal).val(moment().format('HH:mm'));
    $('#fecha-zarpe-time-container', $thisModal).datetimepicker(timeOptions(moment().utc()));

     <?php if(array_in_array(['admin_nave_add'], $current_user['privilegios'])): ?>
     $('#new-nave', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Nave', '/naves/add', {
             successCallback: function ( data ){
                 var $select = $('#nave-id', $thisModal);
                 $select.append('<option value="'+data.data.id+'" data-capitan="'+data.data.capitan_id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_artePesca_add'], $current_user['privilegios'])): ?>
     $('#new-arte-pesca', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Arte de Pesca', '/arte_pesca/add', {
             successCallback: function ( data ){
                 var $select = $('#arte-pesca-id', $thisModal);
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
     $('#new-capitan', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Capitan', '/auxiliares/add/capitan', {
             successCallback: function ( data ){
                 var $select = $('[name="capitan_id"]');
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre_completo+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>
     <?php if(array_in_array(['admin_puerto_add'], $current_user['privilegios'])): ?>
     $('#new-puerto', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nuevo Puerto', '/puertos/add', {
             successCallback: function ( data ){
                 var $select = $('#puerto-id');
                 $select.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $select.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>

     /**
      * Al cambiar una nave se asigna el capitan por defecto y se habilitan o desabilitan
      * los tipos de arte de pesca correspondientes
      */
     $('#nave-id', $thisModal).on('select2:select', function(e) {
       $('#capitan-id', $thisModal)
          .val(e.params.data.capitan_id)
          .trigger('change');

       var naveRecursos = e.params.data.recursos_ids;
       $('select#arte-pesca-id option', $thisModal).each(function (i, val) {
         if ( $(this).text().length == 0 || $.inArray($(this).data('recursoId'), naveRecursos) !== -1 ) {
           $(this).prop('disabled', false);
         } else {
           $(this).prop('disabled', 'disabled');
         }
       });
       //$('#arte-pesca-id', $thisModal).select2('val', artePesca);
     });
     /*$('#nave-id', $thisModal).on('change', function (e) {
       console.log($(this).find('selected'));

     });*/

     $('#arte-pesca-id').on('change', function (e) {
       $('#recurso-id').val( $('option:selected', $(this)).data('recursoId') );
     });

     $('#marea-form', $thisModal).validate({
         rules: {
             nave_id: {
                 required: true
             },
             arte_pesca_id: {
                 required: true
             },
             fecha_zarpe_date: {
                 required: true
             },
             fecha_zarpe_time: {
                 required: true
             },
             capitan_id: {
                 required: true
             },
             puerto_id: {
                 required: true
             }
         }
     });
 });
</script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $marea->errors(),
        'data' => $marea
    ]);
}
?>
