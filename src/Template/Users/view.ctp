<div class="form content">
	<div id="detalle">
		<fieldset>
	    <legend><?= __('Información del usuario seleccionado:') ?></legend>
		<h1>Nombre: </h1>
		<?php echo $user->name, ' ', $user->surname1, ' ', $user->surname2; ?>
		<br>
		<h1>DNI: </h1>
		<?php 
			if ((!$private['dni']) && (isset($user->dni))) {
				echo $user->dni;
			}
			else if ($private['dni']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->dni)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<h1>Correo electrónico: </h1>
		<?php
			if ((!$private['email']) && (isset($user->email))) {
				echo $user->email;
			}
			else if ($private['email']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->email)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<h1>Dirección: </h1>
		<?php
			if ((!$private['address']) && (isset($user->address))) {
				echo $user->address;
			}
			else if ($private['address']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->address)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<h1>Código postal: </h1>
		<?php
			if ((!$private['postcode']) && (isset($user->postcode))) {
				echo $user->postcode;
			}
			else if ($private['postcode']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->postcode)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<h1>Municipio: </h1>
		<?php
			if ((!$private['municipality']) && (isset($user->municipality_id))) {
				echo $user->municipality->name;
			}
			else if ($private['municipality']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->municipality_id)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<h1>Provincia: </h1>
		<?php
			if ((!$private['province']) && (isset($user->province_id))) {
				echo $user->province->name;
			}
			else if ($private['province']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->province_id)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<h1>Comunidad Autónoma: </h1>
		<?php
			if ((!$private['region']) && (isset($user->region_id))) {
				echo $user->region->name;
			}
			else if ($private['region']) {
				echo '(el usuario ha marcado esta información como privada)';
			}
			else if (!isset($user->region_id)) {
				echo '(información no disponible)';
			}
		?>
		<br>
		<br>
		<?php echo $this->Html->link($this->Html->image('../files/Users/photo/' . $user->photo_dir . '/small_' . $user->photo), '../files/Users/photo/' . $user->photo_dir . '/' . $user->photo, ['escape' => false]); ?>
		<?php
			if ($isMyFavourite) {
				echo $this->Html->image('Fav.png', ['alt' => 'Usuario Favorito']);
			} else {
				echo $this->Html->link('Añadir como favorito', ['controller' => 'favourites', 'action' => 'add', $user->id], ['confirm' => '¿Quieres añadir a este usuario como uno de tus favoritos?', 'class' => 'button']);
			}
		?>	
		<br>
		<br>
		<?php echo $this->Form->button(('Cerrar'), ['type' => 'button', 'onclick' => "self.close()"]) ?>
		<?php echo $this->Html->link('Ver valoraciones', ['controller' => 'Votes', 'action' => 'history', $user->id], ['class' => 'button']); ?>
	</div>
</div>