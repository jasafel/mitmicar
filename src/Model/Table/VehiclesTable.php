<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class VehiclesTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('Users');
		$this->belongsTo('Makes');
		$this->belongsTo('Models');
		$this->hasMany('Offers');

		$this->addBehavior('Proffer.Proffer', [   // Para guardar fotos y sus miniaturas
    		'photo' => [                // Nombre del fichero (en base de datos)
        	  'dir' => 'photo_dir',   // Nombre de la carpeta (en base de datos)
        		'thumbnailSizes' => [
              'small' => [
                'w' => 200, 'h' => 200, 'jpeg_quality'  => 100, 'png_compression_level' => 9
              ],
            ], 'thumbnailMethod' => 'gd'
          ]
      ]);
	}

	public function validationDefault(Validator $validator) {

    $validator->provider('proffer', 'Proffer\Model\Validation\ProfferRules');

    return $validator
      ->add('regnumber', [
          'notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce una matrícula'], 
          'unique' => ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Ese número de matrícula ya existe.'],
        ])
      ->add('make_id', ['notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce una marca']])
      ->add('model_id', ['notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce un modelo']])
      ->add('photo', 'proffer', [
            'rule' => ['dimensions', ['min' => ['w' => 100, 'h' => 100], 'max' => ['w' => 2000, 'h' => 2000]]], 'message' => 'La foto no tiene las dimensiones correctas.', 'provider' => 'proffer'
          ])
      ->allowEmpty('photo', ['create', 'update']);
    }

    public function findOwnedBy(Query $query, array $options) {
        
        $user_id = $options['user_id'];
        return $query->where(['user_id' => $user_id]);
    }

    public function findByIdExtended (Query $query, array $options) { // Para obtener información de todas las entidades asociadas con el vehículo

     $vehicle_id = $options['vehicle_id'];
     return $query
      ->where(['Vehicles.id' => $vehicle_id])
      ->contain(['Makes', 'Models']);
  }

}
?>