<div class="form content">
    <div id="form_oferta">
        <div id="form_oferta_izq">
            <?php foreach ($vehicles as $vehicle): ?>
                <?= $this->Form->create($vehicle) ?>
                <fieldset>
                <legend><?= __('Escoge un vehículo:') ?></legend>
                <?php
                    echo $this->Form->input('regnumber', ['label' => 'Matrícula:', 'disabled' => true]);
                    echo $this->Form->input('make_id', ['label' => 'Marca:', 'disabled' => true]);
                    echo $this->Form->input('model_id', ['label' => 'Modelo:', 'disabled' => true]);
                    echo $this->Form->input('colour', ['label' => 'Color:', 'disabled' => true]);
                ?>
                </fieldset>
            <?php endforeach; ?>  
            <?= $this->Form->end() ?>
            <ul class="pagination" align="center">
                <?= $this->Paginator->prev('« Anterior') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Siguiente »') ?>
            </ul>
        </div>
        <div id="form_oferta_der">
            <?= $this->Form->create($offer) ?>
            <fieldset>
                <legend><?= __('...y ofrécelo a otros usuarios:') ?></legend>
                <?php
                    $this->Form->templates(['dateWidget'=>'{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}']);
                    echo $this->Form->input('date', ['label' => 'Fecha:', 'minYear'=>date('Y'), 'maxYear'=>date('Y')]);
                    echo $this->Form->input('time', ['label' => 'Hora:', 'interval'=>15]);
                    echo $this->Form->input('region_id', ['label' => 'Comunidad Autónoma:', 'empty'=>'(elige una comunidad)']);
                    echo $this->Form->input('province_id', ['label' => 'Provincia:','empty'=>'(elige una provincia)']);
                    echo $this->Form->input('mun_origin_id', ['label' => 'Municipio origen:', 'empty'=>'(elige un municipio)']);
                    echo $this->Form->input('mun_destination_id', ['label' => 'Municipio destino:', 'empty'=>'(elige un municipio)']);
                    echo $this->Form->input('seats', ['label' => 'Número de plazas ofrecidas:']);
                    echo $this->Form->input('onlyfavs', ['label' => '¿Sólo para usuarios favoritos?:', 'type' => 'select', 'options' => ['0' => 'No', '1'=>'Sí']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php echo $this->Html->script('scripts.js'); ?>