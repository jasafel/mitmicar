<div class="form content">
    <?= $this->Form->create($user, ['type'=>'file']) ?>
    <fieldset>
        <legend><?= __('Modifica tu perfil de usuario:') ?></legend>
        <div id="form_usuario">
            <div id="form_usuario_izq">
            <?php
                echo $this->Form->input('name', ['label' => 'Nombre:']);
                echo $this->Form->input('surname1', ['label' => 'Primer apellido:']);
                echo $this->Form->input('surname2', ['label' => 'Segundo apellido:']);
                echo $this->Form->input('photo', ['label' => 'Fotografía:', 'type'=>'file']);
                echo $this->Html->link($this->Html->image('../files/Users/photo/' . $user->photo_dir . '/small_' . $user->photo), '../files/Users/photo/' . $user->photo_dir . '/' . $user->photo, ['escape' => false]);
            ?>
            </div>
            <div id="form_usuario_cnt">
            <?php
                echo $this->Form->input('dni', ['label' => 'DNI:']);
                echo $this->Form->input('email', ['label' => 'Correo-e:']);
                echo $this->Form->input('address', ['label' => 'Dirección:']);
                echo $this->Form->input('postcode', ['label' => 'Código Postal:']);
                echo $this->Form->input('region_id', ['label' => 'Comunidad Autónoma:', 'empty'=>'(elige una comunidad)']);
                echo $this->Form->input('province_id', ['label' => 'Provincia:','empty'=>'(elige una provincia)']);
                echo $this->Form->input('municipality_id', ['label' => 'Municipio:', 'empty'=>'(elige un municipio)']);
            ?>
            </div>
            <div id="form_usuario_der">
            <?php
                echo $this->Form->input('priv_dni_id', ['label' => 'Privacidad DNI:', 'options' => $privacies]);
                echo $this->Form->input('priv_email_id', ['label' => 'Privacidad correo-e:', 'options' => $privacies]);
                echo $this->Form->input('priv_address_id', ['label' => 'Privacidad dirección:', 'options' => $privacies]);
                echo $this->Form->input('priv_postcode_id', ['label' => 'Privacidad código postal:', 'options' => $privacies]);
                echo $this->Form->input('priv_region_id', ['label' => 'Privacidad comunidad autónoma:', 'options' => $privacies]);
                echo $this->Form->input('priv_province_id', ['label' => 'Privacidad provincia', 'options' => $privacies]);
                echo $this->Form->input('priv_municipality_id', ['label' => 'Privacidad municipio', 'options' => $privacies]);
            ?>
            </div>
            <div id="form_usuario_abj">
                <?= $this->Form->button(__('Guardar')) ?>
                <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<?php echo $this->Html->script('scripts.js'); ?>