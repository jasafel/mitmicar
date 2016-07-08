<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MunicipalitiesTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('Provinces');
		$this->hasMany('Users');
		$this->hasMany('Offers');
	}
}

?>