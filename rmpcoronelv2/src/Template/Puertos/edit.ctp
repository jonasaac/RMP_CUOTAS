<?php
$this->layout = 'ajax';
if (!$this->request->is(['post', 'put'])) {
    $hash_id = hash('md5', time());
?>

<div class="row" id="<?=$hash_id?>">
    <div class="col-sm-12">
        <form id="puerto-form" class="form-horizontal">
            <legend>Puerto - <?=$puerto->nombre?></legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input
                    class="form-control input-xs"
                    name="nombre"
                    id="nombre"
                    value = "<?=$puerto->nombre?>"
                    placeholder="Ingrese nombre del puerto"/>
                </div>
            </div>

            <?php
              $puertos_ids = [];
              foreach ($puerto->recinto->areas as $area) {
                $puertos_ids[] = $area->id;
                }
            ?>
            <div class="form-group">
                <label class="col-sm-3 control-label">Areas</label>
                <div class="col-sm-9">
                    <select
                    class="form-control"
                    style="width: 100%"
                    name="area_id"
                    id="areas"
                    lang="es"
                    multiple="multiple">
                    <option></option>
                    <?php foreach($areas as $id => $area): ?>
                      <option "<?=$id?>"<?=in_array($id, $puertos_ids)?' selected="selected"':''?>><?=$area?></option>
                    <?php endforeach; ?>


                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <legend>Pontones</legend>
            </div>
            <div class="col-sm-12">
                <?= $this->Form->button('Añadir Ponton', ['id' => 'addPontonBtn', 'class' => 'btn']) ?>
            </div>
            <div class="col-sm-12" id="pontones-div">
                <?php
                $numPonton = 0;
                if(!empty($puerto->pontones))
                    foreach($puerto->pontones as $ponton){
                        echo '<div class="row form-group">'.
                             '<input type="hidden" name="pontones['.$numPonton.'][id]" value="'.$ponton->id.'">'.
                             '<label class="col-sm-4 control-label" style="text-align: left;">Nombre Ponton:</label>'.
                             '<div class="col-sm-6"><input type="text" class="form-control input-xs" name="pontones['.$numPonton.'][nombre]" value="'.$ponton->nombre.'" placeholder="Ingrese el nombre del pontón"></div>'.
                             '<div class="col-sm-2"><button class="btn btn-warning delete-ponton"><i class="fa fa-trash-o"></i></button></div>'.
                             '</div>';
                        $numPonton++;
                    }
                echo '</div>';
                ?>
            </div>
        </form>
    </div>
</div>


<script>
 $(document).ready(function () {
    var $thisModal = $('#<?=$hash_id?>');
    var numPonton = <?= $numPonton ?>;
    $('select').select2({
        dropdownParent : $thisModal
    })
    $("#pontones-div").on('click', '.delete-ponton', function( event ) {
        event.preventDefault();
        $(this).parents('.form-group').remove();
        numPonton--;
    });

    $("#addPontonBtn").click(function( event ) {
        event.preventDefault();
        $('#pontones-div').append('<div class="row form-group"><label class="col-sm-4 control-label">Nombre Pontón:</label><div class="col-sm-6"><input type="text" class="form-control input-xs" name="pontones['+numPonton+'][nombre]" placeholder="Ingrese el nombre del pontón"></div><div class="col-sm-2"><button class="btn btn-warning delete-ponton"><i class="fa fa-trash-o"></i></button></div></div>');
        numPonton++;
    });

     $('#puerto-form', $thisModal).validate({
         rules: {
             nombre: {
                 required: true,
                 minlength: 2
             }
         }
     });

     $('[name^="pontones"][name$="[nombre]"]', $thisModal).rules('add', {
         required: true,
         minlength: 2
     });
});
</script>
<?php
} else {
    echo json_encode([
        'status' => $status,
        'errors' => $puerto->errors(),
        'data' => $puerto
    ]);
}
?>
