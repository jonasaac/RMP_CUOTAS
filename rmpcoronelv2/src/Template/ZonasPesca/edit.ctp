<?php
$this->layout = 'ajax';
if(!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <form id="zona-pesca-form">
            <legend>Zona de Pesca</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control input-xs" name="nombre" id="nombre" value="<?=$zona_pesca->nombre?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Macro Zonas</label>
                <div class="col-sm-9">
                    <input type="hidden" name="macro_zonas[_ids][]" />
                    <select name="macro_zonas[_ids][]" id="macro-zonas"
                        disabled="disabled"
                        class="form-control input-xs"
                        data-placeholder="Seleccione las Macro Zonas"
                        placeholder="Seleccione las Macro Zonas"
                        style="width:100%;"
                        lang="es"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Estado</label>
                <div class="col-sm-9">
                    <select class="form-control input-xs" style="width: 100%" name="estado_id" id="estado-id" disabled="disabled"></select>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal

    var macro_zonas = [];
    $.ajax({
        'url': '/api/macro_zonas.json',
        'dataType': 'json',
        'type': 'GET'
    })
    .done(function(data) {
        $.each(data.macro_zonas, function(i, val) {
            macro_zonas.push({id: val.id, text: val.nombre});
        });
        $("#macro-zonas", $thisModal).prop("multiple", "multiple");
        $("#macro-zonas", $thisModal).select2({data: macro_zonas});
        $("#macro-zonas", $thisModal).prop("disabled", false);
        var selectedValues = [<?=$zona_pesca->macro_zonas_ids?>];
        $("#macro-zonas", $thisModal).val(selectedValues).trigger("change");
    });

    var estados = []
    $.ajax({
        'url': '/api/estados.json?paridad=1',
        'dataType': 'json',
        'type': 'GET'
    })
    .done(function(data) {
        $.each(data.estados, function(i, val) {
            estados.push({id: i, text: val});
        });
        $("#estado-id", $thisModal).select2({data: estados});
        $("#estado-id", $thisModal).prop("disabled", false);
        $("#estado-id", $thisModal).val(<?=$zona_pesca->estado_id?>).trigger("change");
    });


     $('#zona-pesca-form', $thisModal).validate({
         rules: {
             nombre: {
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
        'errors' => $zona_pesca->errors(),
        'data' => $zona_pesca
    ]);
}
?>
