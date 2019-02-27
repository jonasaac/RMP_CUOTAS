<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Regimene'), ['action' => 'edit', $regimene->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Regimene'), ['action' => 'delete', $regimene->id], ['confirm' => __('Are you sure you want to delete # {0}?', $regimene->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Regimenes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Regimene'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="regimenes view large-10 medium-9 columns">
    <h2><?= h($regimene->nombre) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($regimene->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($regimene->id) ?></p>
        </div>
    </div>
</div>
