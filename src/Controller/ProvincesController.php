<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ProvincesController extends AppController {

	public function beforeFilter(Event $event) {
    
    	parent::beforeFilter($event);
    	$this->Auth->allow(['get']); // Métodos permitidos sin autenticación
    }

	public function get() {

		$this->autoRender = false;
 		$region_to_find = $_GET['region_id'];
		$provincesTable = TableRegistry::get('Provinces');
		if ($region_to_find > 0) {
			$provinces = $provincesTable->find('list')->where(['region_id' => $region_to_find]);
		} else {
			$provinces = null;
		}
		header("Content-Type: application/json", true);
		echo json_encode($provinces, JSON_UNESCAPED_UNICODE);
	}
}