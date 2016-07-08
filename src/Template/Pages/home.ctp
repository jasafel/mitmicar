<div id="principal">
	<div id="principal_izq">
		<br>
		<h1>Si quieres compartir vehículo...</h1>
		<br>
		<br>
		<?php
			echo $this->Html->link($this->Html->image('AddVehicles.png', ['alt' => 'Añadir vehículo']), ['controller' => 'Vehicles', 'action' => 'add'], ['escape' => false]); 
			echo $this->Html->link($this->Html->image('AddOffers.png', ['alt' => 'Ofertar transporte']), ['controller' => 'Offers', 'action' => 'add'], ['escape' => false]); 
		?>
		<br>
		<?php
			echo $this->Html->link($this->Html->image('ModifyVehicles.png', ['alt' => 'Gestiona tus vehículos']), ['controller' => 'Vehicles', 'action' => 'modify'], ['escape' => false]); 
			echo $this->Html->link($this->Html->image('ModifyOffers.png', ['alt' => 'Gestiona tus ofertas']), ['controller' => 'Offers', 'action' => 'modify'], ['escape' => false]); 
			echo $this->Html->link($this->Html->image('ReviewReservations.png', ['alt' => 'Revisa las solicitudes recibidas']), ['controller' => 'Reservations', 'action' => 'review'], ['escape' => false]); 
		?>
	</div>
	<div id="principal_der">
		<br>
		<h1>...o si necesitas uno:</h1>
		<br>
		<br>
		<?php
			echo $this->Html->link($this->Html->image('SearchOffers.png', ['alt' => 'Buscar transporte']), ['controller' => 'Offers', 'action' => 'search'], ['escape' => false]); 
		?>
		<br>
		<?php
			echo $this->Html->link($this->Html->image('ModifyReservations.png', ['alt' => 'Revisa las reservas realizadas']), ['controller' => 'Reservations', 'action' => 'modify'], ['escape' => false]); 
		?>
	</div>
	<br>
	<div id="principal_abj">
		<br>
		<h1>Otras opciones:</h1>
		<br>
		<br>
		<?php
			echo $this->Html->link($this->Html->image('AddVotes.png', ['alt' => 'Valora tu experiencia con otros usuarios']), ['controller' => 'Votes', 'action' => 'review'], ['escape' => false]); 
			echo $this->Html->link($this->Html->image('CreditsUsers.png', ['alt' => 'Gestiona tus créditos']), ['controller' => 'Users', 'action' => 'credits'], ['escape' => false]); 
			echo $this->Html->link($this->Html->image('ModifyFavourites.png', ['alt' => 'Gestiona tus usuarios favoritos']), ['controller' => 'Favourites', 'action' => 'review'], ['escape' => false]); 
		?>
	</div>
</div>
