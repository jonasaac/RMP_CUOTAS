<?php
use Cake\Core\Configure;

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

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
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<div class="row">
  <div class="col-lg-12 body-404">
    <div class="error-header"> </div>
    <div class="container">
        <section class="error-container text-center">
            <h1>400</h1>
            <div class="error-divider">
                <h2></h2>
                <p class="description">PAGINA NO ENCONTRADA.</p>
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
        <h2><?= h($message) ?></h2>
        <p class="error">
            <strong><?= __d('cake', 'Error') ?>: </strong>
            <?= sprintf(
                __d('cake', 'The requested address %s was not found on this server.'),
                "<strong>'{$url}'</strong>"
            ) ?>
        </p>
      </div>
    </div>
  </div>
</div>-->
