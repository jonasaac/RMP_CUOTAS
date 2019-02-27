<?php
$this->layout = 'ajax';
?>
<div class="privilegios form large-10 medium-9 columns">
    <?= $this->Form->create($privilegio) ?>
    <fieldset>
        <legend><?= __('Add Privilegio') ?></legend>
        <?php
            echo $this->Form->input('nombre', ['type' => 'text']);
            echo $this->Form->input('grupos._ids', ['options' => $grupos]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
