<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ProvincesTable extends Table {

	public function initialize(array $config) {
		
		$this->belongsTo('Regions');
		$this->hasMany('Municipalities');
		$this->hasMany('Users');
		$this->hasMany('Offers');
	}
}

?>