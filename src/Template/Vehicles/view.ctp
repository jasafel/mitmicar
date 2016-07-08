<div class="form content">
	<div id="detalle">
		<fieldset>
    	<legend><?= __('Información del vehículo seleccionado:') ?></legend>
		<h1>Matrícula: </h1>
		<?php echo $vehicle->regnumber; ?>
		<br>
		<h1>Marca: </h1>
		<?php echo $vehicle->make->name; ?>
		<br>
		<h1>Modelo: </h1>
		<?php echo $vehicle->model->name; ?>
		<br>
		<h1>Color: </h1>
		<?php echo $vehicle->colour; ?>
		<br>
		<br>
		<?php echo $this->Html->link($this->Html->image('../files/Vehicles/photo/' . $vehicle->photo_dir . '/small_' . $vehicle->photo), '../files/Vehicles/photo/' . $vehicle->photo_dir . '/' . $vehicle->photo, ['escape' => false]); ?>
		<br>
		<br>
		<?php echo $this->Form->button(('Cerrar'), ['type' => 'button', 'onclick' => "self.close()"]) ?>
	</div>
</div>