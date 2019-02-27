<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $privilegio->nombre],
                ['confirm' => __('Are you sure you want to delete # {0}?', $privilegio->nombre)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Privilegios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Grupos'), ['controller' => 'Grupos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grupo'), ['controller' => 'Grupos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="privilegios form large-10 medium-9 columns">
    <?= $this->Form->create($privilegio) ?>
    <fieldset>
        <legend><?= __('Edit Privilegio') ?></legend>
        <?php
            echo $this->Form->input('grupos._ids', ['options' => $grupos]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
