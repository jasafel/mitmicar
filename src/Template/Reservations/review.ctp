<div class="form content">
    <div id="form_grid">
        <div id="form_grid_tabla">
            <fieldset>
            <legend><?= __('Listado de solicitudes recibidas:') ?></legend>
            <table>
            <tr>
                <th><?= $this->Paginator->sort('mun_origin_id', 'Origen') ?></th>
                <th><?= $this->Paginator->sort('mun_destination_id', 'Destino') ?></th>
                <th><?= $this->Paginator->sort('region_id', 'Comunidad') ?></th>
                <th><?= $this->Paginator->sort('province', 'Provincia') ?></th>
                <th><?= $this->Paginator->sort('date', 'Fecha') ?></th>
                <th><?= $this->Paginator->sort('time', 'Hora') ?></th>
                <th><?= $this->Paginator->sort('seats', 'Asientos') ?></th>
                <th><?= $this->Paginator->sort('id_vehicle', 'Vehículo') ?></th>
                <th><?= $this->Paginator->sort('id_user', 'Solicitante') ?></th>
                <th><?= $this->Paginator->sort('', 'Estado') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>
            </tr>
               <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= $reservation->offer->mun_origin->name ?> </td>
                <td><?= $reservation->offer->mun_destination->name ?> </td>
                <td><?= $reservation->offer->region->name ?> </td>
                <td><?= $reservation->offer->province->name ?> </td>
                <td><?= $reservation->offer->date->i18nFormat('dd-MM-yyyy'); ?> </td>
                <td><?= $reservation->offer->time->i18nFormat('HH:mm');?> </td>
                <td><?= $reservation->offer->seats ?> </td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Vehicles', 'action' => 'view', $reservation->offer->vehicle_id], ['target' => '_blank']); ?></td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Users', 'action' => 'view', $reservation->user_id], ['target' => '_blank']); ?></td>
                <td><?= $reservation->reqstate->name ?> </td>
                <?php if ($reservation->reqstate->name == 'Pendiente') { ?>
                        <td><?php echo $this->Html->link('Aprobar solicitud', ['controller' => 'Reservations', 'action' => 'approve', $reservation->id], ['confirm' => '¿Estás seguro de que quieres aprobar esta solicitud?']); ?></td>
                        <td><?php echo $this->Html->link('Denegar la solicitud', ['controller' => 'Reservations', 'action' => 'deny', $reservation->id], ['confirm' => '¿Estás seguro de que quieres denegar esta solicitud?']); ?></td>
                <?php } ?>
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