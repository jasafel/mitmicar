<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PrivaciesTable extends Table {

	public function initialize(array $config)
	{
		$this->hasMany('Users');
	}
}

?>