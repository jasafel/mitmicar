<div class="form content">
    <div id="form_creditos">
		<h1>Gestiona tus créditos:</h1>
		<h2>Dispones de <?php echo ($credits) ?> créditos</h2>
		<br>
		<?php
			echo $this->Html->link($this->Html->image('BuyCredits.png', ['alt' => 'Comprar créditos']), ['controller' => 'Users', 'action' => 'buycredits'], ['escape' => false]); 
			echo $this->Html->link($this->Html->image('SellCredits.png', ['alt' => 'Vender créditos']), ['controller' => 'Users', 'action' => 'sellcredits'], ['escape' => false]); 
		?>
	</div>
</div>
