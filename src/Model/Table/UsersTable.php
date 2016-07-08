<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\RulesChecker;

class UsersTable extends Table {

  public function initialize(array $config) {

    $this->belongsTo('Regions');
    $this->belongsTo('Provinces');
    $this->belongsTo('Municipalities');
    $this->belongsTo('PrivDni', ['className' => 'Privacies', 'foreignKey' => 'priv_dni_id']);
    $this->belongsTo('PrivEmail', ['className' => 'Privacies', 'foreignKey' => 'priv_email_id']);
    $this->belongsTo('PrivAddress', ['className' => 'Privacies', 'foreignKey' => 'priv_address_id']);
    $this->belongsTo('PrivPostCode', ['className' => 'Privacies', 'foreignKey' => 'priv_postcode_id']);
    $this->belongsTo('PrivMunicipality', ['className' => 'Privacies', 'foreignKey' => 'priv_municipality_id']);
    $this->belongsTo('PrivProvince', ['className' => 'Privacies', 'foreignKey' => 'priv_province_id']);
    $this->belongsTo('PrivRegion', ['className' => 'Privacies', 'foreignKey' => 'priv_region_id']);
    $this->hasMany('Vehicles');
    $this->hasMany('Reservations');
    $this->hasMany('Favourites');

		$this->addBehavior('Proffer.Proffer', [   // Para guardar fotos y sus miniaturas
    		'photo' => [                // Nombre del fichero (en base de datos)
        	   	'dir' => 'photo_dir',   // Nombre de la carpeta (en base de datos)
        		'thumbnailSizes' => [
        			'small' => [
        				'w' => 200,
        				'h' => 200,
                		'jpeg_quality'  => 100,
           				'png_compression_level' => 9
            		],
            	],
        		'thumbnailMethod' => 'gd'  // Options are Imagick, Gd or Gmagick
        	]
		]);
	}

  public function validationDefault(Validator $validator) {

    $validator->provider('proffer', 'Proffer\Model\Validation\ProfferRules');

    return $validator
      
      ->add('username', [
          'notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce un nombre de cuenta'], 
          'between'=> ['rule' => ['lengthBetween', 4, 100], 'message' => 'El nombre de la cuenta debe tener entre 4 y 100 caracteres.'],
          'unique' => ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'El nombre de cuenta elegido ya existe.'],
          'alphaNumeric' => ['rule' => 'alphaNumeric', 'message' => 'Sólo letras y números']
        ])
      ->add('password', [
          'notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce una contraseña'],
          'minLength' => ['rule' => ['minLength', 8], 'message' => 'La contraseña debe tener al menos 8 caracteres.'],
          'alphaNumeric' => ['rule' => 'alphaNumeric', 'message' => 'Sólo letras y números']
        ])
      ->add('photo', 'proffer', [
            'rule' => ['dimensions', ['min' => ['w' => 100, 'h' => 100], 'max' => ['w' => 500, 'h' => 500]]], 'message' => 'La foto no tiene las dimensiones correctas.', 'provider' => 'proffer'
          ])
      ->allowEmpty('photo', ['create', 'update']);
  }

  public function validationPassword (Validator $validator) {

    return $validator
      
      ->add('old_password', [
        'notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce una contraseña'],
        'custom'=> ['rule'=> function($value, $context) {
          $user = $this->get($context['data']['id']);
          if ($user) {
            if ((new DefaultPasswordHasher)->check($value, $user->password)) {
              return true;
            }
          }
          return false;
        }, 'message'=>'La contraseña introducida no coincide con la actual']
      ])
      ->add('password1', [
        'notBlank' => ['rule' => 'notBlank', 'message'=>'Introduce una contraseña'],
        'minlength' => ['rule' => ['minLength', 8], 'message'=>'La contraseña debe tener la menos 8 caracteres'],
        'alphaNumeric' => ['rule' => 'alphaNumeric', 'message' => 'Sólo letras y números'],
        'match'=>['rule'=> ['compareWith','password2'], 'message'=>'Las contraseñas no coinciden']
      ])
      ->add('password2', [
        'notBlank' => ['rule' => 'notBlank', 'message' => 'Introduce una contraseña'],
        'minlength' => ['rule' => ['minLength', 8], 'message'=>'La contraseña debe tener la menos 8 caracteres'],
        'alphaNumeric' => ['rule' => 'alphaNumeric', 'message' => 'Sólo letras y números'],
        'match'=>['rule'=> ['compareWith','password1'], 'message'=>'Las contraseñas no coinciden']
        ]);
  }

  public function findByIdExtended (Query $query, array $options) { // Para obtener información de todas las entidades asociadas con el usuario

     $user_id = $options['user_id'];
     return $query
      ->where(['Users.id' => $user_id])
      ->contain(['Regions', 'Provinces', 'Municipalities',
        'PrivRegion', 'PrivProvince', 'PrivMunicipality', 'PrivAddress', 'PrivEmail', 'PrivDni', 'PrivPostCode']);
  }
}


