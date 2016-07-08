<div class="form content">
    <div id="form_grid">
        <?= $this->Form->create() ?>
        <fieldset>
        <legend><?= __('Filtra los transportes disponibles por el lugar de salida:') ?></legend>
        <div id="form_buscar_arr1">
            <?= $this->Form->input('region_id', ['label' => 'Comunidad Autónoma:', 'empty'=>'(elige una comunidad)']); ?>
        </div>
        <div id="form_buscar_arr2">
            <?= $this->Form->input('province_id', ['label' => 'Provincia:', 'empty'=>'(elige una provincia)']); ?>
        </div>
        <div id="form_buscar_arr3">
            <?= $this->Form->input('municipality_id', ['label' => 'Municipio:', 'empty'=>'(elige un municipio)']); ?>

        </div>
        <div id="form_buscar_arr4">
            <?= $this->Form->button(__('Filtrar')) ?>
        </div>
        </fieldset>
        <?= $this->Form->end() ?>
        <div id="form_grid_tabla">

            <table>
            <tr>
                <th><?= $this->Paginator->sort('mun_origin_id', 'Salida') ?></th>
                <th><?= $this->Paginator->sort('mun_destination_id', 'Destino') ?></th>
                <th><?= $this->Paginator->sort('region_id', 'Comunidad') ?></th>
                <th><?= $this->Paginator->sort('province', 'Provincia') ?></th>
                <th><?= $this->Paginator->sort('date', 'Fecha') ?></th>
                <th><?= $this->Paginator->sort('time', 'Hora') ?></th>
                <th><?= $this->Paginator->sort('seats', 'Plazas libres') ?></th>
                <th><?= $this->Paginator->sort('id_vehicle', 'Vehículo') ?></th>
                <th><?= $this->Paginator->sort('id_vehicle', 'Propietario') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>

            </tr>
            <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= $offer->mun_origin->name ?> </td>
                <td><?= $offer->mun_destination->name ?> </td>
                <td><?= $offer->region->name ?> </td>
                <td><?= $offer->province->name ?> </td>
                <td><?= $offer->date->i18nFormat('dd-MM-yyyy'); ?> </td>
                <td><?= $offer->time->i18nFormat('HH:mm');?> </td>
                <td><?= $offer->seats ?> </td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Vehicles', 'action' => 'view', $offer->vehicle_id], ['target' => '_blank']); ?></td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Users', 'action' => 'view', $offer->vehicle->user_id], ['target' => '_blank']); ?></td>
                <td><?php echo $this->Html->link('¡RESERVA!', ['controller' => 'Reservations', 'action' => 'add', $offer->id], ['confirm' => '¿Estás seguro de que quieres hacer esta reserva?']); ?></td>
            </tr>
            <?php endforeach; ?>
            </table>
            
        </div>
        <div id="form_grid_abj">
            <ul class="pagination" align="center">
                <?= $this->Paginator->prev('« Anterior') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Siguiente »') ?>
            </ul>
            <?= $this->Html->link('Volver', '/', ['class' => 'button']) ?>
        </div>
    </div>
</div>

<?php echo $this->Html->script('scripts.js'); ?>