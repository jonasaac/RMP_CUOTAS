<?php
$this->layout = 'void';
$this->assign('title', 'Login');
?>
<div id="main-container" class="container">
    <div class="row" style="margin: 8% auto 0;"></div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">
            <div class="row animated fadeInDown">
                <div class="row">
                    <div id="login-title" class="col-md-8 col-md-offset-2 text-center">
                        <h2>RMP Coronel</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                    <div class="loginPane">
                        <div class="loginPaneTop">
                            Account Login(Desarrollo)
                        </div>
                        <div class="loginPaneCenter text-center">
                            <div class="row">
                            <div class="col-md-12">
                            <?php
                            $this->Form->templates([
                                'formGroup' => '{{input}}{{error}}',
                            ]);
                            ?>
                            <?= $this->Form->create($login) ?>
                            <div class="form-group">
                                <label class="col-md-4">Username:</label>
                                <div class="col-md-8">
                                    <input type="text" name="username" class="form-control input-xs" placeholder="Nombre de Usuario" required="required" id="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4">Password:</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control input-xs" placeholder="<?= __('Password') ?>" required="required" name="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4">Grupo:</label>
                                <div class="col-md-8" style="text-align: left;">
                                    <select name="grupo_id" id="grupo-id" required="required" class="form-control input-xs" placeholder="Seleccione un grupo de permisos" data-placeholder="Seleccione un grupo de permisos" style="width: 100%;">
                                      <option></option>
                                      <?php foreach ($grupos as $id => $grupo): ?>
                                        <option value="<?=$id?>"><?=$grupo?></option>
                                      <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                v.<?=$rmp_version?>
                            </div>
                            <button type="submit" class="btn btn-default"><?= __('Account Login') ?></button>
                            <?= $this->Form->end() ?>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="http://www.irbits.cl">Irbits</a> <small>© 2015</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->append('jquery'); ?>
<script>
$(document).ready(function() {
  $('#grupo-id').select2();

  $('#username').on('blur change', function() {
    var username = $(this).val();
    console.log(username);
    $.get('/api/usuarios/get_grupo/' + username, function(data) {
      console.log(data);
      if (data) {
        $('#grupo-id').val(data).trigger('change');
      }
    })
  });
});
</script>
<?php $this->end(); ?>
