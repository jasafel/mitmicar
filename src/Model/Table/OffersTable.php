<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class OffersTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('Vehicles');
        $this->belongsTo('Regions');
        $this->belongsTo('Provinces');
        $this->belongsTo('MunOrigin', ['className' => 'Municipalities', 'foreignKey' => 'mun_origin_id']);
        $this->belongsTo('MunDestination', ['className' => 'Municipalities', 'foreignKey' => 'mun_destination_id']);
		$this->hasOne('Reservations');
    }

	public function validationDefault(Validator $validator) {

    	return $validator
      		->notEmpty('date', 'Introduzca una fecha')
      		->notEmpty('time', 'Introduzca una hora')
            ->notEmpty('region_id', 'Introduzca una comunidad autónoma')
            ->notEmpty('province_id', 'Introduzca una provincia')
            ->notEmpty('mun_origin_id', 'Introduzca un municipio de origen')
            ->notEmpty('mun_destination_id', 'Introduzca un municipio de destino')
            ->notEmpty('seats', 'Introduzca un número de plazas');
	}

	public function findOfferedBy(Query $query, array $options) {  // Para la gestión de las ofertas del propio usuario
        
        $user_id = $options['user_id'];
        return $query->find('all')->where(['Vehicles.user_id' => $user_id])->contain(['Vehicles']);
    }

    public function findNotOfferedBy(Query $query, array $options) {    // Para la búsqueda de ofertas
        
        $user_id = $options['user_id'];
        $region_id = $options['region_id'];
        $province_id = $options['province_id'];
        $municipality_id = $options['municipality_id'];

        $conditions = ['Vehicles.user_id !=' => $user_id]; // No muestro ofertas del propio usuario
        array_push ($conditions, ['Offers.seats > ' => 0]); // Con plazas disponibles

        $favouritesTable = TableRegistry::get('Favourites');
        $followers = $favouritesTable->find()->select('user1_id')->where(['user2_id' => $user_id]); // Los que tienen como favorito al usuario
        // Añado la condición de que, o bien la oferta sea pública, o bien el usuario sea uno de sus favoritos
        array_push ($conditions, ['OR' => [['Offers.onlyfavs' => false], ['Vehicles.user_id IN ' => $followers]]]);

        // Aplico más condiciones si se ha filtrado por ubicación
        if ($region_id) {
            array_push ($conditions, ['Offers.region_id' => $region_id]);
        }
        if ($province_id) {
            array_push ($conditions, ['Offers.province_id' => $province_id]);
        }
        if ($municipality_id) {
            array_push ($conditions, ['Offers.mun_origin_id' => $municipality_id]);
        }

        return $query
            ->where($conditions)
            ->contain(['Vehicles.Users', 'Regions', 'Provinces', 'MunOrigin', 'MunDestination']);
    }
}

?>