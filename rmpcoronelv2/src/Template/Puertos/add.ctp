<?php
$this->layout = 'ajax';
if (!$this->request->is('post')) {
    $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
    <div class="col-md-12">
        <form id="puerto-form" class="form-horizontal">
            <legend>Puerto</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                    <input
                    class="form-control input-xs"
                    name="nombre"
                    id="nombre"
                    placeholder="Ingrese nombre del puerto"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Areas</label>
                <div class="col-sm-9">
                    <select
                    class="form-control"
                    name="area_id"
                    id="areas"
                    lang="es"
                    style="width: 100%"
                    multiple="multiple">
                        <option></option>
                        <?php foreach($areas as $id => $area): ?>
                            <option value="<?=$id?>" ><?=$area?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <legend>Pontones</legend>
            <a id="addPontonBtn" class="btn btn-default input-xs">Añadir Pontón</a>

            <div class="col-sm-12" id="pontones-div">
                <?php
                $numPonton = 0;
                echo $this->Form->hidden('pontones[]');
                echo '<div class="row form-group">'.
                     '<label class="col-sm-4 control-label" style="text-align: left;">Nombre Pontón:</label>'.
                     '<div class="col-sm-6"><input type="text" class="form-control input-xs" name="pontones['.$numPonton.'][nombre]" placeholder="Ingrese el nombre del pontón"></div>'.
                     '<div class="col-sm-2"><button class="btn btn-warning delete-ponton"><i class="fa fa-trash-o"></i></button></div>'.
                     '</div>';
                echo '<div class="row">';
                $numPonton++;
                if(!empty($puerto['pontones']))
                    foreach($puerto['pontones'] as $ponton){
                        echo $this->Form->input('pontones.'.$numPonton.'.nombre', ['label' => 'Nombre Ponton:']);
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
  // Se inicializan los componentes necesarios para la vista
  var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal
  var numPonton = <?= $numPonton ?>;
  $('select').select2({
      dropdownParent : $thisModal
  })

  $("#pontones-div", $thisModal).on('click', '.delete-ponton', function( event ) {
      event.preventDefault();
      $(this).parents('.form-group').remove();
      numPonton--;
  });

  $("#addPontonBtn", $thisModal).click(function( event ) {
      event.preventDefault();
      $('#pontones-div').append('<div class="row form-group"><label class="col-sm-4 control-label">Nombre Pontón:</label><div class="col-sm-6"><input type="text" class="form-control input-xs" name="pontones['+numPonton+'][nombre]" placeholder="Ingrese el nombre del pontón"></div><div class="col-sm-2"><button class="btn btn-warning delete-ponton"><i class="fa fa-trash-o"></i></button></div></div>');
      numPonton++;

      $('[name^="pontones"][name$="[nombre]"]', $thisModal).rules('add', {
          required: true,
          minlength: 2
      });
  });

  $('#puerto-form', $thisModal).validate({
      rules: {
          nombre: {
              required: true,
              minlength: 2
          },
          'areas[_ids]': {
            minlength: 1
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
