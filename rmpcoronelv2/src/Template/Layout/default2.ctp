<html>
    <head>
        <title>RMP Coronel</title>
        <?= $this->Html->css('font-awesome.min.css')?>
        <?= $this->Html->css('portlet.css')?>
        <?= $this->fetch('css'); ?>
    </head>
    <body>
        <?= $this->fetch('content'); ?>
            <!--Basic Scripts-->
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('slimscroll/jquery.slimscroll.min.js') ?>
    <?= $this->Html->script('toastr/toastr.js') ?>
    <?= $this->Html->script('jasny/jasny-bootstrap.min.js') ?>
    <?= $this->Html->script('datetime/moment.min.js') ?>
    <?= $this->Html->script('datetime/bootstrap-datetimepicker.js') ?>
    <?= $this->Html->script('readonly/readonly.js') ?>
    <?= $this->Html->script('beyond.js') ?>

    <!-- Application Scripts -->
    <?= $this->Html->script('rmp/global.js') ?>

    <!--Page Related Scripts-->
    <?= $this->fetch('script') ?>
    <script>
     $(document).ready(function () {
         <?= $this->fetch('jquery') ?>
     });
    </script>
    </body>
</html>
