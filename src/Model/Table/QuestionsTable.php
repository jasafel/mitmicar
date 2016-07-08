<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class QuestionsTable extends Table {

	public function initialize(array $config)
	{
		$this->belongsTo('QuestionTypes');
		$this->hasMany('Answers');
	}
}