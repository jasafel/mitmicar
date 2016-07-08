<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class AnswersTable extends Table {

	public function initialize(array $config)
	{
		$this->belongsTo('Votes');
		$this->belongsTo('Questions');
	}
}