<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Grupos Usuario'), ['action' => 'edit', $gruposUsuario->usuario_uid]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grupos Usuario'), ['action' => 'delete', $gruposUsuario->usuario_uid], ['confirm' => __('Are you sure you want to delete # {0}?', $gruposUsuario->usuario_uid)]) ?> </li>
        <li><?= $this->Html->link(__('List Grupos Usuarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grupos Usuario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grupos'), ['controller' => 'Grupos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grupo'), ['controller' => 'Grupos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="gruposUsuarios view large-10 medium-9 columns">
    <h2><?= h($gruposUsuario->usuario_uid) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Grupo') ?></h6>
            <p><?= $gruposUsuario->has('grupo') ? $this->Html->link($gruposUsuario->grupo->id, ['controller' => 'Grupos', 'action' => 'view', $gruposUsuario->grupo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Usuario') ?></h6>
            <p><?= $gruposUsuario->has('usuario') ? $this->Html->link($gruposUsuario->usuario->uid, ['controller' => 'Usuarios', 'action' => 'view', $gruposUsuario->usuario->uid]) : '' ?></p>
        </div>
    </div>
</div>
