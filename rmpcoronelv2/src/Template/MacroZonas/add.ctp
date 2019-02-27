<?php
$this->layout = 'ajax';
if(!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <form id="macro-zona-form" class="form-horizontal">
            <legend>Macro Zona de Pesca</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control input-xs" name="nombre" id="nombre" placeholder="Ingrese el nombre de la Macro Zona"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Zonas de Pesca</label>
                <div class="col-sm-9">
                    <select name="zonas_pesca[_ids][]" id="macro-zonas"
                        multiple="multiple"
                        class="form-control input-xs"
                        data-placeholder="Seleccione las Zonas de Pesca"
                        placeholder="Seleccione las Zonas de Pesca"
                        style="width:100%",
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
            'url': '/api/zonas_pesca.json',
            'dataType': 'json',
            'type': 'GET',
            'processResults': function (data, params) {
                return {
                    results: data.zonas_pesca.map(function (item) {
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
