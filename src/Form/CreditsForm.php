<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CreditsForm extends Form               // Utilizado para el formulatio de compraventa de créditos
{

    protected function _buildSchema(Schema $schema) {
        return $schema->addField('number', ['type' => 'int']);
    }


    protected function _execute(array $data) {
        return true;
    }
}