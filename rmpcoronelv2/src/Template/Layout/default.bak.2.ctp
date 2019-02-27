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

    <!--Basic Styles-->
    <?= $this->Html->css('bootstrap.min.css')?>
    <?= $this->Html->css('font-awesome.min.css')?>

    <!--Fonts-->
    <?= $this->Html->css('../fonts/OpenSans.css')?>

    <!--Beyond styles-->
    <?= $this->Html->css('beyond.css')?>
    <?= $this->Html->css('animate.min.css')?>
    <?= $this->Html->css('skins/camanchaca.css')?>

    <!-- Page Related Styles -->
    <?= $this->Html->css('bootstrap-datetimepicker.css')?>
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
    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <?= $this->Html->image('camanchaca-header.svg') ?>
                        </small>
                    </a>
                </div>
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings --->
                <div class="navbar-header pull-right">
                    <div class="navbar-account">
                        <ul class="account-area">
                            <li>
                                <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                    <section>
                                        <h2><span class="profile"><span>Daniel Campos</span></span></h2>
                                    </section>
                                </a>
                            </li>
                            <!-- /Account Area -->
                            <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                        </ul>
                    </div>
                </div>
                <!-- /Account Area and Settings -->
            </div>
        </div>
    </div>
    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
        <!-- Page Container -->
        <div class="page-container">
            <!-- Page Sidebar -->
            <?= $this->element('sidebar') ?>
            <!-- /Page Sidebar -->
            <!-- Page Content -->
            <div class="page-content">
                <!-- Page Breadcrumb -->
                <?= $this->fetch('breadcrumb') ?>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            <?= $this->fetch('title') ?>
                        </h1>
                    </div>
                    <!--Header Buttons-->
                    <div class="header-buttons">
                        <a class="sidebar-toggler" href="#">
                            <i class="fa fa-arrows-h"></i>
                        </a>
                        <a class="refresh" id="refresh-toggler" href="">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        <a class="fullscreen" id="fullscreen-toggler" href="#">
                            <i class="glyphicon glyphicon-fullscreen"></i>
                        </a>
                    </div>
                    <!--Header Buttons End-->
                </div>
                <!-- /Page Header -->
                <!-- Page Body -->
                <div class="page-body">
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
<!--  /Body -->
</html>
