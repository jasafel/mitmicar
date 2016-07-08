<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Users;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;

class VehiclesController extends AppController {

    public function view($id) {

        $vehiclesTable = TableRegistry::get('Vehicles');
        $vehiclequery = $vehiclesTable->find('ByIdExtended', ['vehicle_id' => $id]);
        foreach ($vehiclequery  as $vehicle) {}
         $this->set(compact('vehicle'));
    }

    public function add() {
   		
   		/* Creo el nuevo registro en la tabla */
   		$vehiclesTable = TableRegistry::get('Vehicles');
		$vehicle = $vehiclesTable->newEntity();

        /*Busco la información en las otras tablas para los desplegables */
        $makesTable = TableRegistry::get('Makes');
        $makes = $makesTable->find('list')->order(['name'=>'ASC']);

        $modelsTable = TableRegistry::get('Models');
        $models = $modelsTable->find('list')->order(['name'=>'ASC']);
        $this->set(compact('makes','models'));
		
 		if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
            $this->request->data['created'] = Time::now();
            $vehicle = $vehiclesTable->patchEntity($vehicle, $this->request->data);
            if ($vehiclesTable->save($vehicle)) {
                $this->Flash->success(__('Vehículo creado'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
            } else {
                $this->Flash->error(__('El vehículo no se ha creado, por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('vehicle'));
	}

    public function modify() {
        
        $vehiclesTable = TableRegistry::get('Vehicles');
        $this->paginate = ['finder'=>['OwnedBy'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 1];
        $vehicles = $this->paginate($vehiclesTable);
   
        if (is_null($vehicles->first())) {         // Verifico primero si hay información que poder modificar         
                $this->Flash->error(__('No tienes vehículos creados'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }

        /*Busco la información en las otras tablas para los desplegables */
        $makesTable = TableRegistry::get('Makes');
        $makes = $makesTable->find('list')->order(['name'=>'ASC']);
        
        $modelsTable = TableRegistry::get('Models');
        $models = $modelsTable->find('list')->order(['name'=>'ASC']);
        $this->set(compact('makes','models'));
                
        if ($this->request->is('post') || $this->request->is('put')) {
            $chosenvehicle = $vehiclesTable->findById ($this->request->data['id'])->first();
            $chosenvehicle = $vehiclesTable->patchEntity($chosenvehicle, $this->request->data);
            if ($vehiclesTable->save($chosenvehicle)) {
                $this->Flash->success(__('Vehículo actualizado'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
            } else {
                $this->Flash->error(__('El vehículo no se ha modificado, por favor, inténtelo de nuevo.'));
            }
        }
        else {
            $this->request->data = $vehicles->first();
        }
        $this->set(compact('vehicles'));
    }
}	
