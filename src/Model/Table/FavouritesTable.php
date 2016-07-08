<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;

class FavouritesTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('User1', ['className' => 'Users', 'foreignKey' => 'user1_id']);
        $this->belongsTo('User2', ['className' => 'Users', 'foreignKey' => 'user2_id']);
	}

	public function isFavourite($id1, $id2) {

		$favourite = $this->find()->where([
			'user1_id' => $id1,
			'user2_id' => $id2
		])->first();
		if ($favourite == null) {
			return false;
		} else {
			return true;
		}
	}

	public function findFavs(Query $query, array $options) {

		$user_id = $options['user_id'];
		return $query->find('all')->where(['user1_id' => $user_id])->contain(['User2']);
	}

	public function findFollowers(Query $query, array $options) {

		$user_id = $options['user_id'];
		$existingfavs = $this->find()->select('user2_id')->where(['user1_id' => $user_id]); 	// Los favoritos del usuario seguido
		return $query->find('all')
			->where(['user2_id' => $user_id])		// Que hayan marcado al usuario como favorito
			->andWhere(['ischecked IS NOT' => true])  // Sólo usuarios que no hayan sido ya revisados
			->andWhere(['user1_id NOT IN ' => $existingfavs])		// Sólo usuarios que no sean ya favoritos
			->contain(['User1']);
	}
}
?>