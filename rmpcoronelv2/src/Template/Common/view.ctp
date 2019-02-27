<?= $this->start('breadcrumb') ?>
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <?= $this->Html->getCrumbList([
            'firstClass' => false,
            'lastClass' => 'active',
            'class' => 'breadcrumb',
            'escape' => false,
        ], '<i class="fa fa-home"></i> '.__('Home')) ?>
    </ul>
</div>
<?= $this->end() ?>

<?= $this->fetch('content') ?>
