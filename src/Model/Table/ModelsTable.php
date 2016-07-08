<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ModelsTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('Makes');
		$this->hasMany('Vehicles');
	}
}
?>