<div class="form content">
    <div id="form_vehiculo">
        <?php foreach ($vehicles as $vehicle): ?>
            <?= $this->Form->create($vehicle, ['type'=>'file']) ?>
            <fieldset>
                <legend><?= __('Modifica tus vehículos:') ?></legend>
                <?php
                    echo $this->Form->input('id', ['type' => 'hidden']);
                    echo $this->Form->input('regnumber', ['label' => 'Matrícula:']);
                    echo $this->Form->input('make_id', ['label' => 'Marca:', 'empty'=>'(elige una marca)']);
                    echo $this->Form->input('model_id', ['label' => 'Modelo:','empty'=>'(elige un modelo)']);
                    echo $this->Form->input('colour', ['label' => 'Color:']);
                    echo $this->Form->input('photo', ['label' => 'Fotografía:', 'type'=>'file']);
                    echo $this->Html->link($this->Html->image('../files/Vehicles/photo/' . $vehicle->photo_dir . '/small_' . $vehicle->photo), '../files/Vehicles/photo/' . $vehicle->photo_dir . '/' . $vehicle->photo, ['escape' => false]);
                ?>
        <?php endforeach; ?>  
        <br>
        <br>
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
        <br>
        <ul class="pagination" align="center">
            <?= $this->Paginator->prev('« Anterior') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Siguiente »') ?>
        </ul>
        </fieldset>
    </div>
</div>

<?php echo $this->Html->script('scripts.js'); ?>
