<?php
$this->layout = 'ajax';
if(!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <form id="macro-zona-form">
            <legend>Macro Zona de Pesca</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control input-xs" name="nombre" id="nombre" value="<?=$macro_zona->nombre?>" placeholder="Ingrese el nombre de la Macro Zona"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Zonas de Pesca</label>
                <div class="col-sm-9">
                    <input type="hidden" name="zonas_pesca[_ids][]" />
                    <select name="zonas_pesca[_ids][]" id="zonas-pesca"
                        multiple="multiple"
                        class="form-control input-xs"
                        data-placeholder="Seleccione las Zonas de Pesca"
                        placeholder="Seleccione las Zonas de Pesca"
                        style="width:100%"
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

    var zonas_pesca = [];
    $.ajax({
        'url': '/api/zonas_pesca.json',
        'dataType': 'json',
        'type': 'GET'
    })
    .done(function(data) {
        $.each(data.zonas_pesca, function(i, val) {
            zonas_pesca.push({id: val.id, text: val.nombre});
        });
        $("#zonas-pesca", $thisModal).prop("multiple", "multiple");
        $("#zonas-pesca", $thisModal).select2({data: zonas_pesca});
        $("#zonas-pesca", $thisModal).prop("disabled", false);
        var selectedValues = [<?=$macro_zona->zonas_pesca_ids?>];
        $("#zonas-pesca", $thisModal).val(selectedValues).trigger("change");
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
        $("#estado-id", $thisModal).val(<?=$macro_zona->estado_id?>).trigger("change");
    });

     $('#macro-zona-form', $thisModal).validate({
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
        'errors' => $macro_zona->errors(),
        'data' => $macro_zona
    ]);
}
?>
