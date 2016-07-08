<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class FeedbackForm extends Form               // Utilizado para el formulatio de respuesta al voto
{

    protected function _buildSchema(Schema $schema) {
        return $schema->addField('ispositive', ['type' => 'boolean'])
            ->addField('description', ['type' => 'textarea'])
            ->addField('values', ['type' => 'array()']);
    }

    protected function _execute(array $data) {
        return true;
    }
}