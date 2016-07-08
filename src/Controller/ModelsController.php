<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ModelsController extends AppController {

    public function beforeFilter(Event $event) {
    
        parent::beforeFilter($event);
        $this->Auth->allow(['get']); // Métodos permitidos sin autenticación
    }

    public function get() {

        $this->autoRender = false;
        $make_to_find = $_GET['make_id'];
        $modelsTable = TableRegistry::get('Models');
        if (is_null($make_to_find)) {
            $models = $modelsTable->find('list');
        } else {
            $models = $modelsTable->find('list', array('conditions' => array('make_id' => $make_to_find)));
        }
        header("Content-Type: application/json", true);
        echo json_encode($models);
    }
}