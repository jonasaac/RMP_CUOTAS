
<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?= Debugger::dump($error->params) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>

<div class="row">
  <div class="col-lg-12 body-500">
    <div class="error-header"> </div>
    <div class="container">
        <section class="error-container text-center">
            <h1>500</h1>
            <div class="error-divider">
                <h2></h2>
                <p class="description">HA OCURRIDO UN ERROR INTERNO.</p>
            </div>
            <a href="/" class="btn btn-shiny" style="margin-top:50px;margin-bottom:50px"><i class="fa fa-home"></i>Inicio</a>
        </section>
    </div>
  </div>
</div>

<!--<div class="row">
  <div class="col-lg-12">
    <div class="widget">
      <div class="widget-header">
        <span class="widget-caption">Página no Encontrada</span>
      </div>
      <div class="widget-body">
        <h2><?= __d('cake', 'An Internal Error Has Occurred') ?></h2>
        <p class="error">
            <strong><?= __d('cake', 'Error') ?>: </strong>
            <?= h($message) ?>
        </p>
      </div>
    </div>
  </div>
</div>-->
