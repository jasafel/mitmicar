<div class="form content">
    <div id="valoracion">
        <fieldset>
        <h1><?= __('Valoración general: ') ?></h1>
            <?php echo ('Votos positivos: ' . $positivevotes . '/' . $totalvotes . ' (' . $positivepercent . '% del total' . ')'); ?>
        </fieldset>
        <fieldset>
        <legend><?= __('Valoraciones recibidas por el usuario:') ?></legend>
        <table>
        <tr>
            <th><?= $this->Paginator->sort('ispositive', 'Valoración') ?></th>
            <th><?= $this->Paginator->sort('description', 'Descripción') ?></th>
            <th><?= $this->Paginator->sort('', '') ?></th>
        </tr>
           <?php foreach ($votes as $vote): ?>
        <tr>
            <?php if ($vote->ispositive) { ?>
                <td><?php echo ('Positiva'); ?></td>
            <?php } else { ?>
                <td><?php echo ('Negativa'); ?></td>
            <?php } ?>
            <td><?= $vote->description ?> </td>
            <td><?php echo $this->Html->link('Ver detalles', ['controller' => 'Votes', 'action' => 'view', $vote->id]); ?></td>
        </tr>
        <?php endforeach; ?>
        </fielset>
        </table>
        <ul class="pagination" align="center">
            <?= $this->Paginator->prev('« Anterior') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Siguiente »') ?>
        </ul>
        <?= $this->Html->link('Volver', '/', ['class' => 'button']) ?>
    </div>
</div>
