<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;

class ReservationsTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('Users');
		$this->belongsTo('Offers');
        $this->belongsTo('Reqstates');
        $this->hasMany('Votes');
	}

	public function findReservedBy(Query $query, array $options) {  // Para la gestión de las reservas realizadas
        
        $user_id = $options['user_id'];
        return $query
            ->where(['Reservations.user_id' => $user_id])
            ->contain(['Offers.Vehicles.Users', 'Offers.Regions', 'Offers.Provinces', 'Offers.MunOrigin', 'Offers.MunDestination', 'Reqstates']);
    }

    public function findRequested(Query $query, array $options) {  // Para la gestión de las solicitudes recibidas
        
        $user_id = $options['user_id'];
        return $query
            ->where(['Reservations.reserved IS NOT' => null])
            ->contain([
                'Offers.Regions', 'Offers.Provinces', 'Offers.MunOrigin', 'Offers.MunDestination', 'Reqstates',
                'Offers.Vehicles.Users'])
            ->matching('Offers.Vehicles.Users')
            ->where(['Users.id' => $user_id]);      // Reservas sólo del usuario
    }
}

?>