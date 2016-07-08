<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class MunicipalitiesController extends AppController {

	public function beforeFilter(Event $event) {
    
    	parent::beforeFilter($event);
    	$this->Auth->allow(['get']); // Métodos permitidos sin autenticación
    }

	public function get() {

		$this->autoRender = false;
 		$province_to_find = $_GET['province_id'];
		$municipalitiesTable = TableRegistry::get('Municipalities');
		if ($province_to_find > 0) {
			$municipalities = $municipalitiesTable->find('list')->where(['province_id' => $province_to_find]);
		} else {
			$municipalities = null;
		}
		header("Content-Type: application/json", true);
		echo json_encode($municipalities, JSON_UNESCAPED_UNICODE);
	}
}