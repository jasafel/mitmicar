<div class="form content">
    <div id="detalle">
        <fieldset>
        <legend><?= __('Detalles del voto seleccionado:') ?></legend>
        <table>
        <tr>
            <th><?= $this->Paginator->sort('question', 'Pregunta') ?></th>
            <th><?= $this->Paginator->sort('value', 'Valoración') ?></th>
        </tr>
           <?php foreach ($answers as $answer):  ?>
        <tr>
            <td><?php echo ($answer->question->name); ?></td>
            <td><?php echo ($answer->value); ?> </td>
        </tr>
        <?php endforeach; ?>
        </table>
        <?= $this->Html->link('Volver', '/', ['class' => 'button']) ?>
    </div>  
</div>