<div class="form content">
    <div id="form_grid">
        <div id="form_grid_tabla">
            <fieldset>
            <legend><?= __('Listado de usuarios favoritos:') ?></legend>
            <table>
            <tr>
                <th><?= $this->Paginator->sort('name', 'Nombre') ?></th>
                <th><?= $this->Paginator->sort('surname1', 'Primer apellido') ?></th>
                <th><?= $this->Paginator->sort('surname2', 'Segundo apellido') ?></th>
                <th><?= $this->Paginator->sort('detail', 'Más información') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>
            </tr>
               <?php foreach ($favourites as $favourite): ?>
            <tr>
                <td><?= $favourite->user2->name ?> </td>
                <td><?= $favourite->user2->surname1 ?> </td>
                <td><?= $favourite->user2->surname2 ?> </td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Users', 'action' => 'view', $favourite->user2_id], ['target' => '_blank']); ?></td>
                <td><?php echo $this->Html->link('Eliminar favorito', ['controller' => 'Favourites', 'action' => 'delete', $favourite->id], ['confirm' => '¿Estás seguro de que quieres eliminar a este usuario como favorito?']); ?></td>
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
            <br>
            <br>
            <?php if ($followers) {
                echo $this->Html->link('¡¡¡Hay ' . $followers . ' usuario/s que te ha/n marcado como favorito!!!', ['controller' => 'Favourites', 'action' => 'check']);
            }
            ?>
        </div>
    </div>
</div>