<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class QuestiontypesTable extends Table {

	public function initialize(array $config)
	{
		$this->hasMany('Questions');
	}