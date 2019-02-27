<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $recepcione->descarga_encabezado_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $recepcione->descarga_encabezado_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Recepciones'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Descarga Encabezados'), ['controller' => 'DescargaEncabezados', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Descarga Encabezado'), ['controller' => 'DescargaEncabezados', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Auxiliares'), ['controller' => 'Auxiliares', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Auxiliare'), ['controller' => 'Auxiliares', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="recepciones form large-10 medium-9 columns">
    <?= $this->Form->create($recepcione) ?>
    <fieldset>
        <legend><?= __('Edit Recepcione') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
