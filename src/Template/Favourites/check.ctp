<div class="form content">
    <div id="form_grid">
        <div id="form_grid_tabla">
            <fieldset>
            <legend><?= __('Listado de usuarios que te han marcado como favorito:') ?></legend>
            <table>
            <tr>
                <th><?= $this->Paginator->sort('name', 'Nombre') ?></th>
                <th><?= $this->Paginator->sort('surname1', 'Primer apellido') ?></th>
                <th><?= $this->Paginator->sort('surname2', 'Segundo apellido') ?></th>
                <th><?= $this->Paginator->sort('detail', 'Más información') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>
                <th><?= $this->Paginator->sort('', '') ?></th>
            </tr>
               <?php foreach ($favourites as $favourite): ?>
            <tr>
                <td><?= $favourite->user1->name ?> </td>
                <td><?= $favourite->user1->surname1 ?> </td>
                <td><?= $favourite->user1->surname2 ?> </td>
                <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Users', 'action' => 'view', $favourite->user1_id], ['target' => '_blank']); ?></td>
                <td><?php echo $this->Html->link('Ignorar', ['controller' => 'Favourites', 'action' => 'ignore', $favourite->id], ['confirm' => '¿Estás seguro de que no deseas marcar a este usuario como favorito?']); ?></td>
                <td><?php echo $this->Html->link('Añadir', ['controller' => 'Favourites', 'action' => 'add', $favourite->user1_id], ['confirm' => '¿Estás seguro de que deseas marcar a este usuario como favorito?']); ?></td>
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