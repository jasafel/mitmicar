<div class="form content">
    <div id="form_grid">
        <div id="form_grid_tabla">
            <fieldset>
            <legend><?= __('Listado de votos pendientes:') ?></legend>
            <table>
            <tr>
                <th><?= $this->Paginator->sort('mun_origin_id', 'Origen') ?></th>
                <th><?= $this->Paginator->sort('mun_destination_id', 'Destino') ?></th>
                <th><?= $this->Paginator->sort('region_id', 'Comunidad') ?></th>
                <th><?= $this->Paginator->sort('province', 'Provincia') ?></th>
                <th><?= $this->Paginator->sort('date', 'Fecha') ?></th>
                <th><?= $this->Paginator->sort('time', 'Hora') ?></th>
                <th><?= $this->Paginator->sort('id_vehicle', 'Vehículo') ?></th>
                <th><?= $this->Paginator->sort('id_user1', 'Propietario') ?></th>
                <th><?= $this->Paginator->sort('id_user2', 'Pasajero') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>
            </tr>
            <?php foreach ($votes as $vote): ?>
            <tr>
                <td><?= $vote->reservation->offer->mun_origin->name ?> </td>
                <td><?= $vote->reservation->offer->mun_destination->name ?> </td>
                <td><?= $vote->reservation->offer->region->name ?> </td>
                <td><?= $vote->reservation->offer->province->name ?> </td>
                <td><?= $vote->reservation->offer->date->i18nFormat('dd-MM-yyyy'); ?> </td>
                <td><?= $vote->reservation->offer->time->i18nFormat('HH:mm');?> </td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Vehicles', 'action' => 'view', $vote->reservation->offer->vehicle_id], ['target' => '_blank']); ?></td>
                <?php if ($vote->reservation->offer->vehicle->user_id == $this->request->session()->read('Auth.User.id')) { ?>
                    <td><?php echo ('¡Eres tú!'); ?></td>
                <?php } else { ?>
                    <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Users', 'action' => 'view', $vote->reservation->offer->vehicle->user_id], ['target' => '_blank']); ?></td>
                <?php } ?>
                <?php if ($vote->reservation->user_id == $this->request->session()->read('Auth.User.id')) { ?>
                    <td><?php echo ('¡Eres tú!'); ?></td>
                <?php } else { ?>
                    <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Users', 'action' => 'view', $vote->reservation->user_id], ['target' => '_blank']); ?></td>
                <?php } ?>
                <td><?php echo $this->Html->link('VOTAR', ['controller' => 'Votes', 'action' => 'feedback', $vote->id], ['confirm' => '¿Quieres valorar esta experiencia?']); ?></td>
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

