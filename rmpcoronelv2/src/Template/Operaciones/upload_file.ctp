<?php
$this->layout = 'ajax';
if (!$this->request->is('post')):
  $hash_id = hash('md5', time());
?>
<div class="row" id="<?=$hash_id?>">
  <form id="upload-file-form" class="form-horizontal">
    <div class="col-md-12">
      <div class="form-group">
        <label for="" class="col-sm-3 control-label">Adjunto</label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control input-xs file-input" id="adjunto-text-container" readonly="" placeholder="Seleccione un archivo">
            <span class="input-group-btn">
              <span class="btn btn-file">
                Seleccionar <input type="file" name="adjunto_file" id="adjunto-file">
              </span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function () {
  // Se inicializan los componentes necesarios para la vista
  var $thisModal = $('#<?=$hash_id?>'); //asigna un id unico al modal

  /** Configuracion de Adjunto **/
  $('#adjunto-file', $thisModal).on('change', function() {
      $('#adjunto-text-container', $thisModal).val($(this).val().replace(/C:\\fakepath\\/i, '...\\'));
  });
  /** FIN Configuracion de Adjunto **/

  /** Validaciones **/
  $('#upload-file-form', $thisModal).validate({
    rules: {
      adjunto_file: {
        required: true,
        fileExtension: ['pdf']
      }
    }
  });
  /** FIN Validaciones **/
});
</script>
<?php endif;?>
