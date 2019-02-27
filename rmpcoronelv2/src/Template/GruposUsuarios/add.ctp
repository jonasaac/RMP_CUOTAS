<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Grupos Usuarios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Grupos'), ['controller' => 'Grupos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grupo'), ['controller' => 'Grupos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="gruposUsuarios form large-10 medium-9 columns">
    <?= $this->Form->create($gruposUsuario) ?>
    <fieldset>
        <legend><?= __('Add Grupos Usuario') ?></legend>
        <?php
            echo $this->Form->input('grupo_id', ['options' => $grupos, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
