<div class="form content">
    <div id="form_vehiculo">
        <?= $this->Form->create($vehicle, ['type'=>'file']) ?>
        <fieldset>
            <legend><?= __('Crea un nuevo vehículo:') ?></legend>
            <?php
                echo $this->Form->input('regnumber', ['label' => 'Matrícula:']);
                echo $this->Form->input('make_id', ['label' => 'Marca:', 'empty'=>'(elige una marca)']);
                echo $this->Form->input('model_id', ['label' => 'Modelo:','empty'=>'(elige un modelo)']);
                echo $this->Form->input('colour', ['label' => 'Color:']);
                echo $this->Form->input('photo', ['label' => 'Fotografía:', 'type'=>'file']);
        ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php echo $this->Html->script('scripts.js'); ?>