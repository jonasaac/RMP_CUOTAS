<?php
$this->layout = 'ajax';
if(!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <form id="tipo-operacion-form" class="form-horizontal">
            <legend>Tipo de Operacion</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control input-xs"
                           name="nombre"
                           id="nombre"
                           value="<?=$tipoOperacion->nombre?>"
                           placeholder="Ingrese el nombre del Tipo de Operación"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Tipo</label>
                <div class="col-sm-9">
                  <select name="paridad" id="paridad"
                      class="form-control input-xs"
                      data-placeholder="Seleccione un Grupo"
                      placeholder="Seleccione un Grupo"
                      style="width:100%",
                      lang="es">
                        <option value></option>
                        <option value="1"<?=$tipoOperacion->paridad==1?' selected="selected"':''?>>Entrada</option>
                        <option value="2"<?=$tipoOperacion->paridad==1?' selected="selected"':''?>>Salida</option>
                      </select>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
  // Se inicializan los componentes necesarios para la vista
  var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal
  $('#paridad', $thisModal).select2();
  $('#tipo-operacion-form', $thisModal).validate({
  rules: {
    nombre: {
      required: true
    },
    paridad: {
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
        'errors' => $macro_zona->errors(),
        'data' => $macro_zona
    ]);
}
?>
