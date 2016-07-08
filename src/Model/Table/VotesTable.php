<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;

class VotesTable extends Table {

	public function initialize(array $config)
	{
		$this->belongsTo('Reservations');
		$this->belongsTo('Users');
		$this->hasMany('Answers');
	}

	public function findPending(Query $query, array $options) {  // Para la gestión de las solicitudes recibidas
        
        $user_id = $options['user_id'];
        return $query
            ->where(['Votes.ispositive IS' => null, 'Votes.user_id' => $user_id])
            ->contain(['Reservations.Offers.Vehicles.Users', 'Reservations.Offers.Regions', 'Reservations.Offers.Provinces', 'Reservations.Offers.MunOrigin', 'Reservations.Offers.MunDestination']);
    }

    public function findEvaluation (Query $query, array $options) {  // Busca los votos de un usuario determinado
        
        $user_id = $options['user_id'];
        return $query
        	->contain(['Reservations.Offers.Vehicles'])
        	->where(['Reservations.user_id' => $user_id])	// Votos de reservas hechas por el usuario
        	->orWhere(['Vehicles.user_id' => $user_id])	// o sobre ofertas del usuario
        	->andWhere(['Votes.user_id != ' => $user_id]);		// ...pero que no sean votos del usuario
    }

    public function findPositives (Query $query, array $options) {  // Busca los votos de un usuario determinado
        
        $user_id = $options['user_id'];
        return $query
            ->contain(['Reservations.Offers.Vehicles'])
            ->where(['Reservations.user_id' => $user_id])   // Votos de reservas hechas por el usuario
            ->orWhere(['Vehicles.user_id' => $user_id])  // o sobre ofertas del usuario
            ->andWhere(['Votes.user_id != ' => $user_id])     // ...pero que no sean votos del usuario
            ->andWhere(['Votes.ispositive IS ' => true]);
    }        
}