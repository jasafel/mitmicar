<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MakesTable extends Table {

	public function initialize(array $config) {

		$this->hasMany('Models');
		$this->hasMany('Vehicles');
	}
}
?>