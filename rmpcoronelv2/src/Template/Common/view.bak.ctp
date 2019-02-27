<?= $this->start('breadcrumb') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= $this->fetch('title') ?></h2>
        <?= $this->Html->getCrumbList([
            'firstClass' => false,
            'lastClass' => 'active',
            'class' => 'breadcrumb'
        ], __('Home')) ?>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<?= $this->end(); ?>

<?= $this->fetch('content') ?>
