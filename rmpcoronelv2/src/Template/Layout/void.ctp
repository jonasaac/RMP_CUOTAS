<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= $this->fetch('title') ?> | RMP Coronel</title>

        <?= $this->Html->css('bootstrap.min.css') ?>
        <?= $this->Html->css('animate.min.css') ?>
        <?= $this->Html->css('select2-bootstrap.css')?>
        <?= $this->Html->css('/lib/select2/css/select2.min.css'); ?>
        <?= $this->Html->css('beyond.css') ?>
        <?= $this->Html->css('font-awesome.css') ?>
        <?= $this->Html->css('rmp.css') ?>
        <?= $this->fetch('css') ?>
    </head>

    <body class="bg-white">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

        <!-- Mainly scripts -->
        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('bootstrap.min.js') ?>
        <!--<?= $this->Html->script('select2/select2.js')?>-->
        <?= $this->Html->script('/lib/select2/js/select2.full.min.js');?>
        <?= $this->Html->script('/lib/select2/js/i18n/es.js');?>
        <?= $this->Html->script('slimscroll/jquery.slimscroll.min.js') ?>
        <?= $this->Html->script('toastr/toastr.js') ?>
        <?= $this->Html->script('jasny/jasny-bootstrap.min.js') ?>
        <?= $this->Html->script('beyond.js') ?>
        <?= $this->fetch('script') ?>
        <script>
         $(document).ready(function () {
             $('.btn').addClass('shiny');
             $('.btn:not(".btn-lg")').addClass('btn-xs');
         });
        </script>
        <?= $this->fetch('jquery') ?>
    </body>
</html>
