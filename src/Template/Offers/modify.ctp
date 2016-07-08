<div class="form content">
    <div id="form_oferta">
        <fieldset>
            <legend><?= __('Información de la oferta:') ?></legend>
            <?php foreach ($offers as $offer): ?>
            <?= $this->Form->create($offer) ?>
            <div id="form_oferta_izq">
                <?php
                    $this->Form->templates(['dateWidget'=>'{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}']);
                    echo $this->Form->input('id', ['type' => 'hidden']);
                    echo $this->Form->input('vehicle.regnumber', ['label' => 'Matrícula:', 'disabled' => true]);
                    echo $this->Form->input('vehicle.make_id', ['label' => 'Marca:', 'disabled' => true]);
                    echo $this->Form->input('vehicle.model_id', ['label' => 'Modelo:', 'disabled' => true]);
                    echo $this->Form->input('vehicle.colour', ['label' => 'Color:', 'disabled' => true]);
                ?>
            </div>
            <div id="form_oferta_der">
                <?php
                    echo $this->Form->input('date', ['label' => 'Fecha:', 'minYear'=>date('Y'), 'maxYear'=>date('Y')]);
                    echo $this->Form->input('time', ['label' => 'Hora:', 'interval'=>15]);
                    echo $this->Form->input('region_id', ['label' => 'Comunidad Autónoma:', 'empty'=>'(elige una comunidad)']);
                    echo $this->Form->input('province_id', ['label' => 'Provincia:','empty'=>'(elige una provincia)']);
                    echo $this->Form->input('mun_origin_id', ['label' => 'Municipio origen:',  'options' => $municipalities, 'empty'=>'(elige un municipio)']);
                    echo $this->Form->input('mun_destination_id', ['label' => 'Municipio destino:', 'options' => $municipalities, 'empty'=>'(elige un municipio)']);
                    echo $this->Form->input('seats', ['label' => 'Número de plazas ofrecidas:']);
                    echo $this->Form->input('onlyfavs', ['label' => '¿Sólo para usuarios favoritos?:', 'type' => 'select', 'options' => ['0' => 'No', '1'=>'Sí']]);
                ?>
            </div>
            <div id="form_oferta_abj">
                <ul class="pagination" align="center">
                    <?= $this->Paginator->prev('« Anterior') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('Siguiente »') ?>
                </ul>
            </div>
        </fieldset>
        <?php endforeach; ?>  
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php echo $this->Html->script('scripts.js'); ?>