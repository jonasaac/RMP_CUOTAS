<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Unidade'), ['action' => 'edit', $unidade->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Unidade'), ['action' => 'delete', $unidade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unidade->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Unidades'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unidade'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="unidades view large-10 medium-9 columns">
    <h2><?= h($unidade->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($unidade->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($unidade->id) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($unidade->estado) ?></p>
        </div>
    </div>
</div>
