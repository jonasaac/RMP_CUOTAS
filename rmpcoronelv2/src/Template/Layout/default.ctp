<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title><?=$this->fetch('title')?> | RMP Coronel</title>

    <meta name="description" content="blank page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?= $this->Html->css('bootstrap.min.css')?>
    <?= $this->Html->css('bootstrap-dialog.min.css')?>
    <?= $this->Html->css('font-awesome.min.css')?>
    <?= $this->Html->css('../fonts/OpenSans.css')?>
    <?= $this->Html->css('animate.min.css')?>
    <!--<?= $this->Html->css('bootstrap-datetimepicker.css')?>-->
    <?= $this->Html->css('/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>
    <?= $this->Html->css('/lib/select2/css/select2.min.css'); ?>
    <?= $this->Html->css('select2-bootstrap.css')?>
    <!-- <?= $this->Html->css('jquery.dataTables.min.css')?> -->
    <!-- <?= $this->Html->css('dataTables.bootstrap.css')?> -->
    <?= $this->Html->css('/lib/datatables/css/jquery.dataTables.min.css')?>
    <?= $this->Html->css('/lib/datatables/css/dataTables.bootstrap.min.css')?>
    <?= $this->Html->css('dataTables.fontAwesome.css')?>
    <?= $this->Html->css('beyond.css')?>
    <!--<?= $this->Html->css('beyond-prev.css')?>-->
    <?= $this->Html->css('rmp.css')?>
    <?= $this->fetch('css') ?>
</head>
<!-- /Head -->
<!-- Body -->
<body>
    <!-- Loading Container -->
    <div class="loading-container">
        <div class="loader"></div>
    </div>
    <!--  /Loading Container -->
    <!-- Navbar -->
    <?php
      //echo $this->element('navbar');
      echo $this->element('newnavbar');
    ?>
    <!-- Main Container -->
    <div class="main-container container-fluid">
        <!-- Page Container -->
        <div class="page-container">
            <!-- Page Content -->
            <div class="page-content">
                <!-- Page Breadcrumb -->
                <!-- <?= $this->fetch('breadcrumb') ?>-->
                <!-- /Page Breadcrumb -->
                <!-- Page Body -->
                <div class="page-body">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content'); ?>
                </div>
                <!-- /Page Body -->
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Container -->
        <!-- Main Container -->

    </div>

    <!--Basic Scripts-->
    <!-- <?= $this->Html->script('jquery.min.js') ?> -->
    <!-- <?= $this->Html->script('jquery-1.11.3.min.js') ?> -->
    <?= $this->Html->script('/lib/jquery-1.12.4.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.number.min.js') ?>
    <?= $this->Html->script('slimscroll/jquery.slimscroll.min.js') ?>
    <?= $this->Html->script('toastr/toastr.js') ?>
    <?= $this->Html->script('jasny/jasny-bootstrap.min.js') ?>
    <?= $this->Html->script('datetime/moment.min.js') ?>
    <!-- <?= $this->Html->script('datetime/bootstrap-datetimepicker.js') ?> -->
    <?= $this->Html->script('/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>
    <?= $this->Html->script('readonly/readonly.js') ?>
    <?= $this->Html->script('bootstrap-dialog/bootstrap-dialog.js')?>
    <!--<?= $this->Html->script('datatable/jquery.dataTables.min.js')?>
    <?= $this->Html->script('datatable/dataTables.bootstrap.js')?>-->
    <?= $this->Html->script('/lib/datatables/js/jquery.dataTables.min.js')?>
    <?= $this->Html->script('/lib/datatables/js/dataTables.bootstrap.js')?>
    <!--<?= $this->Html->script('select2/select2.js')?>-->
    <?= $this->Html->script('/lib/select2/js/select2.full.min.js');?>
    <?= $this->Html->script('/lib/select2/js/i18n/es.js');?>
    <?= $this->Html->script('validation/jquery.validate.min.js')?>
    <?= $this->Html->script('validation/additional-methods.min.js')?>
    <?= $this->Html->script('validation/localization/messages_es.js')?>
    <?= $this->Html->script('validation/localization/methods_es_CL.min.js')?>
    <?= $this->Html->script('validation/jquery-validate.bootstrap-tooltip.js')?>
    <?= $this->Html->script('validation-rut/jquery.Rut.js')?>
    <?= $this->Html->script('bootstrap-session-timeout/bootstrap-session-timeout.min.js')?>
    <?= $this->Html->script('/lib/jquery-form/jquery.form.min.js'); ?>
    <?= $this->Html->script('beyond.js') ?>
    <!-- Application Scripts -->
    <?= $this->Html->script('rmp/validation.js?v=1.1.0')?>
    <?= $this->Html->script('rmp/global.js?v=1.3.0') ?>
    <?= $this->Html->script('rmp/mantenedores.js?v=1.0.0')?>
    <!--Page Related Scripts-->
    <?= $this->fetch('script') ?>
    <script>
     $(document).ready(function () {
         moment.locale('es');
         moment.defaultFormat = 'DD-MMM-YYYY HH:mm';
         $('.btn').addClass('shiny');
         $('.btn:not(.btn-lg)').addClass('btn-xs');

         // valida los select
         $(document).on('change', 'form select', function () {
             $(this).valid();
         });

         $.validator.setDefaults({
             ignore: '.select2-offscreen, .select2-input, input[type="text"]:hidden, input[type="hidden"], .select2-container:hidden~select, input.file-input',
             validClass: 'has-success',
             errorClass: 'has-error',
             highlight: function (element, errorClass, validClass){
                 $(element).parents('.form-group').addClass(errorClass).removeClass(validClass);
             },
             unhighlight: function (element, errorClass, validClass){
                 var $formGroup = $(element).parents('.form-group');
                 if ($formGroup.find('.has-error').length == 0)
                     $(element).parents('.form-group').removeClass(errorClass).addClass(validClass);
             },
         });

         $.sessionTimeout({
             title: 'La sesión está cerca de expirar.',
             message: 'La sesión será cerrada en un minuto.',
             logoutUrl: '/usuarios/logout',
             redirUrl: '/usuarios/logout',
             keepAliveUrl: '/keepAlive',
             keepAliveInterval: 300000,
             keepAliveButton: 'Seguir conectado',
             logoutButton: 'Salir',
             warnAfter: 3540000,
             countdownBar: true,
             redirAfter: 3600000
         });
     });

     $(document).bind('DOMSubtreeModified', function () {
         $('.btn').addClass('shiny');
         $('.bootstrap-datetimepicker-widget .btn').removeClass('shiny');
         $('.btn:not(.btn-lg)').addClass('btn-xs');
     });
    </script>
    <?= $this->fetch('jquery') ?>
  </body>
<!--  /Body -->
</html>
