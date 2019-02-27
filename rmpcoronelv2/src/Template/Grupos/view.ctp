<?php
$this->layout = 'ajax';
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Grupo <?= $grupo->nombre ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: block;">
                    <div class="row">
                        <div class="large-5 columns strings">
                            <h6 class="subheader"><?= __('Nombre') ?></h6>
                            <p><?= h($grupo->nombre) ?></p>
                        </div>
                        <div class="large-2 columns numbers end">
                            <h6 class="subheader"><?= __('Id') ?></h6>
                            <p><?= $this->Number->format($grupo->id) ?></p>
                            <h6 class="subheader"><?= __('Estado') ?></h6>
                            <p><?= $this->Number->format($grupo->estado) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="related row">
            <div class="column large-12">
                <h4 class="subheader"><?= __('Related Usuarios') ?></h4>
                <?php if (!empty($grupo->usuarios)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th><?= __('Uid') ?></th>
                            <th><?= __('Nombre') ?></th>
                            <th><?= __('Estado') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($grupo->usuarios as $usuario): ?>
                            <tr>
                                <td><?= h($usuario->uid) ?></td>
                                <td><?= h($usuario->nombre) ?></td>
                                <td><?= h($usuario->estado) ?></td>

                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Usuarios', 'action' => 'view', $usuario->uid]) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Usuarios', 'action' => 'edit', $usuario->uid]) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Usuarios', 'action' => 'delete', $usuario->uid], ['confirm' => __('Are you sure you want to delete # {0}?', $usuarios->uid)]) ?>

                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
