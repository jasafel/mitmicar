<div class="form content">
    <div id="form_password">
		<?= $this->Form->create($user) ?>
		<fieldset>
		    <legend><?= __('Cambia tu contraseña') ?></legend>
		    <?php
		    	echo $this->Form->input('old_password', ['type' => 'password' , 'label'=>'Introduce la contraseña actual:', 'empty' => true]);
		    	echo $this->Form->input('password1', ['type'=>'password', 'label'=>'Introduce la nueva contraseña:', 'empty' => true]);
		    	echo $this->Form->input('password2', ['type' => 'password' , 'label'=>'Repite la nueva contraseña:', 'empty' => true]);
		    ?>
		    <br>
        	<br>
			<?= $this->Form->button(__('Guardar')) ?>
			<?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
			<?= $this->Form->end() ?>
		</fieldset>
	</div>
</div>