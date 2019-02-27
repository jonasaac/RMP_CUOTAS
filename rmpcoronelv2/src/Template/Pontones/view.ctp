<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Pontone'), ['action' => 'edit', $pontone->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pontone'), ['action' => 'delete', $pontone->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pontone->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pontones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pontone'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Recintos'), ['controller' => 'Recintos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recinto'), ['controller' => 'Recintos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Puertos'), ['controller' => 'Puertos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Puerto'), ['controller' => 'Puertos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="pontones view large-10 medium-9 columns">
    <h2><?= h($pontone->nombre) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Recinto') ?></h6>
            <p><?= $pontone->has('recinto') ? $this->Html->link($pontone->recinto->nombre, ['controller' => 'Recintos', 'action' => 'view', $pontone->recinto->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Puerto') ?></h6>
            <p><?= $pontone->has('puerto') ? $this->Html->link($pontone->puerto->nombre, ['controller' => 'Puertos', 'action' => 'view', $pontone->puerto->id]) : '' ?></p>
        </div>
    </div>
</div>
