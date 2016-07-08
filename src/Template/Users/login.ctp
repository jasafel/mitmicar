<div class="form content">
    <div id="login">
        <h1>Si eres usuario registrado, inicia sesión</h1>
        <?= $this->Flash->render('auth') ?>
        <?= $this->Form->create('User') ?>
        <fieldset>
            <legend><?= __('Introduce tus credenciales') ?></legend>
            <?php
                echo $this->Form->input('username', ['label' => 'Nombre de usuario:', 'class' => 'centrado']);
                echo $this->Form->input('password', ['label' => 'Contraseña:']);
            ?>
        <?= $this->Form->button(__('Entrar')) ?>       
        <?= $this->Form->end() ?>
        </fieldset>
        <h1>...y si no registrate 
        <?php
            echo $this->Html->link('AQUÍ.', ['controller' => 'Users', 'action' => 'add']);
        ?>
        </h1>
    </div>
</div>
