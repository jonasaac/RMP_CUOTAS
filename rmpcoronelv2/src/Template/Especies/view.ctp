<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Especy'), ['action' => 'edit', $especy->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Especy'), ['action' => 'delete', $especy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $especy->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Especies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Especy'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="especies view large-10 medium-9 columns">
    <h2><?= h($especy->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($especy->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($especy->id) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($especy->estado) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Tpl') ?></h6>
            <?= $this->Text->autoParagraph(h($especy->tpl)); ?>

        </div>
    </div>
</div>
