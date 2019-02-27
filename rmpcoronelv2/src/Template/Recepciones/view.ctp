<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Recepcione'), ['action' => 'edit', $recepcione->descarga_encabezado_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Recepcione'), ['action' => 'delete', $recepcione->descarga_encabezado_id], ['confirm' => __('Are you sure you want to delete # {0}?', $recepcione->descarga_encabezado_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Recepciones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recepcione'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descarga Encabezados'), ['controller' => 'DescargaEncabezados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['controller' => 'DescargaEncabezados', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Auxiliares'), ['controller' => 'Auxiliares', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Auxiliare'), ['controller' => 'Auxiliares', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="recepciones view large-10 medium-9 columns">
    <h2><?= h($recepcione->descarga_encabezado_id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Descarga Encabezado') ?></h6>
            <p><?= $recepcione->has('descarga_encabezado') ? $this->Html->link($recepcione->descarga_encabezado->id, ['controller' => 'DescargaEncabezados', 'action' => 'view', $recepcione->descarga_encabezado->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Auxiliare') ?></h6>
            <p><?= $recepcione->has('auxiliare') ? $this->Html->link($recepcione->auxiliare->id, ['controller' => 'Auxiliares', 'action' => 'view', $recepcione->auxiliare->id]) : '' ?></p>
        </div>
    </div>
</div>
