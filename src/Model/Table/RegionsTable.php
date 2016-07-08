<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class RegionsTable extends Table {

	public function initialize(array $config) {
				
		$this->hasMany('Provinces');
		$this->hasMany('Users');
		$this->hasMany('Offers');
	}
}
?>