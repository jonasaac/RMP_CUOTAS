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
                    <input class="form-control input-xs" name="nombre" id="nombre" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Macro Zonas</label>
                <div class="col-sm-9">
                    <input type="hidden" name="macro_zonas[_ids][]" />
                    <select name="macro_zonas[_ids][]" id="macro-zonas"
                        multiple="multiple"
                        class="form-control input-xs"
                        data-placeholder="Seleccione las Macro Zonas"
                        placeholder="Seleccione las Macro Zonas"
                        style="width:100%;"
                        lang="es"></select>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
  $(document).ready(function () {
    // Se inicializan los componentes necesarios para la vista
    var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal

    $("#macro-zonas", $thisModal).select2({
        'ajax': {
            'url': '/api/macro_zonas.json',
            'dataType': 'json',
            'type': 'GET',
            'processResults': function (data, params) {
                return {
                    results: data.macro_zonas.map(function (item) {
                        return {
                            id: item.id,
                            text: item.nombre
                        }
                    })
                };
            },
            'cache': true
        }
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
