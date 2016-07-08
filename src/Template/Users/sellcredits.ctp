<div class="form content">
    <div id="form_creditos">
        <?= $this->Form->create($credits) ?>
        <fieldset>
            <legend><?= __('Introduce el número de créditos que deseas vender:') ?></legend>
            <?php

                echo $this->Form->input('number', ['label' => '']);
                echo ('Dispones de ' . $user->credits . ' créditos y el precio de venta del crédito es ' . $creditvalue . ' euro/s.');
             ?>
        <br>
        <br>
        <?= $this->Form->button(__('Vender')) ?>
        <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
        </fieldset>
    </div>
</div>