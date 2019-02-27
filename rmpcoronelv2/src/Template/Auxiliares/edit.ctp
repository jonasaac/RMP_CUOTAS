<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>
    <div class="row" id="<?=$hash_id?>">
        <div class="col-md-12">
            <form class="form-horizontal" id="auxiliar-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-form">Tipo Auxiliar <strong data-toggle="tooltip" data-placement="right" data-original-title="Seleccione el tipo de auxiliar que desea registrar">?</strong></label>
                        <div class="col-sm-9">
                            <fieldset id="tipo-auxiliar">
                                <div class="radio radio-inline">
                                    <label><input name="tipo_entidad" type="radio" value="1" <?= $auxiliar->tipo_entidad == 1 ? 'checked="checked"' : '' ?> id="persona-natural-check"/><span class="text">Persona Natural</span></label>
                                </div>
                                <div class="radio radio-inline">
                                    <label><input name="tipo_entidad" type="radio" value="2" <?= $auxiliar->tipo_entidad == 2 ? 'checked="checked"' : '' ?> id="razon-social-check"/><span class="text">Razón Social</span></label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Estado</label>
                    <div class="col-sm-9">
                      <select name="estado_id" id="estado-id" class="form-control input-xs" data-placeholder="Seleccione el estado" lang="es" style="width:100%;">
                        <?php foreach($estados as $id => $estado):?>
                          <option value="<?=$id?>"<?=$auxiliar->estado_id==$id?' selected="selected"':''?>><?=$estado?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-md-12">
                    <legend>Datos - <?=$auxiliar->nombre_completo?></legend>
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
                                  placeholder="Ingrese un RUT"
                                  value="<?=$auxiliar->full_rut?>"
                                  />
                              </div>
                          </div>
                      </div>

                    <div class="col-md-6" id="div-nombre-razon-social">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre Razón Social</label>
                            <div class="col-sm-9">
                                <input class="form-control
                                input-xs" name="nombre_razon_social"
                                id="nombre-razon-social"
                                value = "<?=$auxiliar->nombre_razon_social?>"
                                placeholder="Ingrese una Razón Social"/>
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
                                value = "<?=$auxiliar->nombre?>"
                                placeholder="Ingrese el Nombre"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="div-apellido-paterno">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Apellido Paterno</label>
                        <div class="col-sm-9">
                            <input
                            class="form-control input-xs"
                            name="apellido_paterno"
                            value = "<?=$auxiliar->apellido_paterno?>"
                            id="apellido-paterno"
                             placeholder="Ingrese el apellido paterno"/>
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
                                value = "<?=$auxiliar->apellido_materno?>"
                                placeholder="Ingrese el Apellido Materno"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Domicilio</label>
                        <div class="col-sm-9">
                            <input
                            class="form-control input-xs" value="<?=$auxiliar->domicilio?>" name="domicilio" id="domicilio" placeholder="Ingrese la dirección del domicilio"/>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Ciudad</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <select class="form-control input-xs" style="width: 100%" name="ciudad_id" id="ciudad-id" placeholder="Seleccione una Ciudad" lang="es">
                              <option></option>
                              <?php foreach($ciudades as $id => $ciudad): ?>
                                <option value="<?=$id?>" <?= $auxiliar->ciudad_id == $id ? 'selected="selected"':'' ?>><?=$ciudad?></option>
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
                          foreach ($funciones as $id => $funcion) {
                              echo '<div class="col-md-4 col-sm-6" id="div-'.$id.'"><div class="checkbox">'.
                                   '<input type="hidden" name="'.$id.'" value="0">'.
                                   '<label>'.
                                   '<input type="checkbox" value="1" name="'.$id.'" id="funcion-'.$id.'"'.($auxiliar->$id ? ' checked="checked"' : '').'>'.
                                   '<span class="text">'.$funcion.'</span>'.
                                   '</label></div></div>';
                          }
                          ?>
                      </div>
                    </div>
                   </div>

                  <?php
                    $areas_ids = [];
                    foreach ($auxiliar->areas as $area) {
                      $areas_ids[] = $area->id;
                      }
                  ?>
                  <div class="col-md-12"><legend>Areas</legend></div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-md-2 control-label">Areas</label>
                      <div class="col-md-10">
                        <input type="hidden" id="areas-ids" name="areas[_ids][]" />
                          <select class="form-control input-xs" name="areas[_ids][]" id="areas-ids" multiple="multiple" lang="es" style="width:100%;" data-placeholder="Seleccione las Areas" placeholder="Seleccione las Areas">
                            <option value></option>
                            <?php foreach($areas as $id => $area): ?>
                              <option value="<?=$id?>"<?=in_array($id, $areas_ids)?' selected="selected"':''?>><?=$area?></option>
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
             dropdownparent : $thisModal
         })
         <?php if($auxiliar->tipo_entidad == 1):  ?>
         //oculta datos por defecto
         $('#div-nombre-razon-social').hide();
         $('#div-sindicato', $thisModal).hide();
     <?php else: ?>
     $('#div-nombre, #div-apellido-paterno, #div-apellido-materno').hide();
     <?php endif; ?>
     $('#estado-id', $thisModal).select2({dropdownParent: $thisModal});
     $('#ciudad-id', $thisModal).select2({dropdownParent: $thisModal});

     $('#new-ciudad').click(function (e) {
         e.stopPropagation();
         newEntity('Nueva Ciudad', '/ciudades/add', {
             successCallback: function ( data ){
                 var $selectCiudad = $('#ciudad-id');
                 $selectCiudad.append('<option value="'+data.data.id+'">'+data.data.nombre+'</option>');
             }
         });
     });

     $(':radio[name="tipo_entidad"]').on('change', function() {
         $('#div-nombre-razon-social').toggle();
         $('#div-nombre').toggle();
         $('#div-apellido-paterno').toggle();
         $('#div-apellido-materno').toggle();
         $('#div-sindicato').toggle();
     });

     var validobj = $('#auxiliar-form').validate({
         ignore: '.select2-offscreen, .select2-input, input[type="text"]:hidden',
         groups: {
             funciones: 'chofer armador encargado_planta capitan destinatario representante'
         },
         rules: {
             rut: {
                 required: true,
                 rut: true,
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
               minlength: 1
             }
         },
         tooltip_options: {
             rut: {placement: 'top'}
         }
     });

     $('#rut').helptooltip({
         'title': 'Ingrese un RUT con el formato: 12.345.678-9'
     });

     $("#rut").Rut({
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
