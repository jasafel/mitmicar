<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ReqstatesTable extends Table {

	public function initialize(array $config) {
		
		$this->hasMany('Reservations');
	}
}