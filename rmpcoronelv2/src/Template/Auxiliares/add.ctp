<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
  <div class="col-lg-12">
    <form id="auxiliar-form" class="form-horizontal">
        <div class="row">
          <div class="col-sm-3 control-label">
              <label>Tipo Auxiliar <strong data-toggle="tooltip" data-placement="right" data-original-title="Seleccione el tipo de auxiliar que desea registrar">?</strong></label>
          </div>
          <div class="col-sm-9">
            <fieldset id="tipo-auxiliar">
              <div class="radio radio-inline">
                  <label><input name="tipo_entidad" type="radio" value="1" checked="checked" id="persona-natural-check"/><span class="text">Persona Natural</span></label>
              </div>
              <div class="radio radio-inline">
                  <label><input name="tipo_entidad" type="radio" value="2" id="razon-social-check"/><span class="text">Razón Social</span></label>
              </div>
            </fieldset>
          </div>
        </div>
    <div class="row">
      <div class="col-md-12">
        <legend>Datos</legend>
      </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3 control-label">RUT</label>
                  <div class="col-sm-9">
                      <input
                      class="form-control input-xs"
                      name="rut"
                      id="rut"
                      maxlength="12"
                      placeholder="Ingrese un RUT"/>
                  </div>
              </div>
          </div>

        <div class="col-md-6" id="div-nombre-razon-social">
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre Razón Social</label>
                <div class="col-sm-9">
                    <input class="form-control input-xs" name="nombre_razon_social" id="nombre-razon-social" placeholder="Ingrese una Razón Social"/>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="div-nombre">
          <div class="form-group">
              <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input
                    class="form-control input-xs"
                    name="nombre"
                    id="nombre"
                    placeholder="Ingrese el Nombre"/>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="div-apellido-paterno">
          <div class="form-group">
            <label class="col-sm-3 control-label">Apellido Paterno</label>
            <div class="col-sm-9">
                <input
                class="form-control input-xs" name="apellido_paterno" id="apellido-paterno" placeholder="Ingrese el apellido paterno"/>
            </div>
          </div>
        </div>

        <div class="col-md-6" id="div-apellido-materno">
          <div class="form-group">
              <label class="col-sm-3 control-label">Apellido Materno</label>
                <div class="col-sm-9">
                    <input
                    class="form-control input-xs"
                    name="apellido_materno"
                    id="apellido-materno"
                    placeholder="Ingrese el Apellido Materno"/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Domicilio</label>
            <div class="col-sm-9">
                <input
                class="form-control input-xs" name="domicilio" id="domicilio" placeholder="Ingrese la dirección del domicilio"/>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Ciudad</label>
            <div class="col-sm-9">
              <div class="input-group">
                <select class="form-control input-xs" name="ciudad_id" id="ciudad-id" data-placeholder="Seleccione una Ciudad" placeholder="Seleccione una Ciudad" lang="es" style="width:100%;">
                  <option></option>
                  <?php foreach($ciudades as $id => $ciudad): ?>
                    <option value="<?=$id?>"><?=$ciudad?></option>
                  <?php endforeach; ?>
                </select>
                <div class="input-group-btn">
                  <?php if(array_in_array(['admin_auxiliar_add'], $current_user['privilegios'])): ?>
                    <a id="new-ciudad" class="btn btn-default input-xs">Nueva</a>
                  <?php else: ?>
                    <a id="new-ciudad" class="btn btn-default input-xs" disabled>Nueva</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12"><legend>Funciones</legend></div>
        <div class="col-md-12">
            <div class="form-group">
            <label class="col-sm-3 control-label">Funciones</label>
            <div class="col-sm-9">
            <?php
            $i = 0;
            foreach ($funciones as $id => $funcion) {
                echo '<div class="col-md-4 col-sm-6" id="div-'.$id.'"><div class="checkbox">'.
                     '<input type="hidden" name="'.$id.'" value="0">'.
                     '<label>'.
                     ($auxiliar->$id ? '<input type="hidden" class="funciones" value="1" name="'.$id.'">' : '').
                     '<input type="checkbox" value="1" name="'.$id.'" id="funcion-'.$id.'"'.
                     ($auxiliar->$id ? ' checked="checked" disabled="disabled"' : '').
                     '>'.
                     '<span class="text">'.$funcion.'</span>'.
                     '</label></div></div>';
            }
            ?>
            </div>
        </div>
      </div>

      <div class="col-md-12"><legend>Areas</legend></div>
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 control-label">Areas</label>
          <div class="col-md-10">
            <input type="hidden" id="areas-ids" name="areas[_ids][]" />
              <select class="form-control input-xs" name="areas[_ids][]" id="areas-ids" multiple="multiple" lang="es" style="width:100%;" data-placeholder="Seleccione las Areas" placeholder="Seleccione las Areas">
                <option></option>
                <?php foreach($areas as $id => $area): ?>
                  <option value="<?=$id?>"><?=$area?></option>
                <?php endforeach; ?>
              </select>
            </div>
        </div>
      </div>
</form>
  </div>
</div>
<script>
 $(document).ready(function () {
     var $thisModal = $('#<?=$hash_id?>');
     $thisModal.parents('.modal-dialog').addClass('modal-lg');
     $('select', $thisModal).select2({
         dropdownParent : $thisModal
     })
     // Oculta datos por defecto
     $('#div-nombre-razon-social').hide();
     $('#div-sindicato', $thisModal).hide();
     $('#ciudad-id', $thisModal).select2({dropdownParent: $thisModal});

     <?php if (array_in_array(['admin_ciudad_add'], $current_user['privilegios'])): ?>
     $('#new-ciudad', $thisModal).click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Ciudad', '/ciudades/add', {
             successCallback: function ( data ){
                 var $selectCiudad = $('#ciudad-id');
                 $selectCiudad.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
                 $selectCiudad.select2('val', data.data.id);
             }
         });
     });
     <?php endif; ?>

     $(':radio[name="tipo_entidad"]', $thisModal).on('change', function() {
         $('#div-nombre-razon-social', $thisModal).toggle();
         $('#div-nombre', $thisModal).toggle();
         $('#div-apellido-paterno', $thisModal).toggle();
         $('#div-apellido-materno', $thisModal).toggle();
         // Se oculta el sindicato por defecto para personas naturales
         $('#div-sindicato', $thisModal).toggle();
     });

     var validobj = $('#auxiliar-form', $thisModal).validate({
         groups: {
             funciones: 'chofer armador encargado_planta capitan destinatario representante'
         },
         rules: {
             rut: {
                 required: true,
                 rut: true,
                 remote: {
                     url: '/auxiliares/checkRut',
                     type: 'post',
                     data: {
                         rut: function () {
                             var rut = $('#rut', $thisModal).val();
                             rut = rut.split('-')[0].split('.').join('');
                             console.log(rut);
                             return rut;
                         }
                     }
                 }
             },
             'nombre_razon_social': {
               required: function(){return $('input[name="tipo_entidad"]:checked', $thisModal).val() == 2},
               minlength: 2
             },
             nombre: {
               required: function(){return $('input[name="tipo_entidad"]:checked', $thisModal).val() == 1},
               minlength: 2
             },
             'apellido_paterno': {
               required: function(){return $('input[name="tipo_entidad"]:checked', $thisModal).val() == 1},
               minlength: 2
             },
             'apellido_materno': {
                 minlength: 2
             },
             domicilio: {
                 required: true,
                 minlength: 2
             },
             'ciudad_id': {
                 required: true
             },
             'areas[_ids][]': {
               required: true
             }
         },
         messages: {
            rut: {
              remote: "RUT asociado a otro auxiliar."
            }
         },
         tooltip_options: {
             rut: {placement: 'top'}
         }
     });

     $('#rut').helptooltip({
         'title': 'Ingrese un RUT con el formato: 12.345.678-9'
     });

     $("#rut", $thisModal).Rut({
         validation: false,
         format_on: 'keyup'
     });
 });
</script>
<?php
    } else {
        echo json_encode([
            'status' => $status,
            'errors' => $auxiliar->errors(),
            'data' => $auxiliar
        ]);
    }
?>
