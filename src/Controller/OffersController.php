<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Users;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use App\Form\FilterForm;

class OffersController extends AppController {


    public function add() {
        
        /* Creo el nuevo registro en la tabla */
        $offersTable = TableRegistry::get('Offers');
        $offer = $offersTable->newEntity();

        /* Busco vehículos (el primero, de momento) del usuario actual */ 
        $vehiclesTable = TableRegistry::get('Vehicles');
        $this->paginate = ['finder'=>['OwnedBy'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 1];
        $vehicles = $this->paginate($vehiclesTable);

        if (is_null($vehicles->first())) {                // Verifico primero si el usuario tiene vehículos
                $this->Flash->error(__('No tienes aún ningún vehículo añadido'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        
        /* Busco la información en las otras tablas para los desplegables */
        $regionsTable = TableRegistry::get('Regions');
        $regions = $regionsTable->find('list')->order(['name'=>'ASC']);

        $makesTable = TableRegistry::get('Makes');
        $makes = $makesTable->find('list')->order(['name'=>'ASC']);

        $modelsTable = TableRegistry::get('Models');
        $models = $modelsTable->find('list')->order(['name'=>'ASC']);

        $this->set(compact('regions','provinces','municipalities','makes','models'));

        if ($this->request->is('post')) {
            $chosenvehicle = $vehicles->first();
            $this->request->data['vehicle_id'] = $chosenvehicle['id'];
            $offer = $offersTable->patchEntity($offer, $this->request->data);
            if ($offersTable->save($offer)) {
                $this->Flash->success(__('Oferta creada'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
            } else {
                $this->Flash->error(__('La oferta no se ha guardado, por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('vehicles','offer'));
    }

    public function modify() {

        $offersTable = TableRegistry::get('Offers');
        $this->paginate = ['finder'=>['OfferedBy'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 1];
        $offers = $this->paginate($offersTable);    // Obtengo un listado (paginado en 1) de las ofertas propias
              
        if (is_null($offers->first())) {          // Verifico primero si hay información que poder modificar
                $this->Flash->error(__('No tienes ofertas publicadas'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }

        /* Busco la información en las otras tablas para los desplegables */
        $regionsTable = TableRegistry::get('Regions');
        $regions = $regionsTable->find('list')->order(['name'=>'ASC']);

        $provincesTable = TableRegistry::get('Provinces');
        $provinces = $provincesTable->find('list')->order(['name'=>'ASC']);

        $municipalitiesTable = TableRegistry::get('Municipalities');
        $municipalities = $municipalitiesTable->find('list')->order(['name'=>'ASC']);

        $makesTable = TableRegistry::get('Makes');
        $makes = $makesTable->find('list')->order(['name'=>'ASC']);

        $modelsTable = TableRegistry::get('Models');
        $models = $modelsTable->find('list')->order(['name'=>'ASC']);

        $this->set(compact('vehicles','regions','provinces','municipalities','makes','models'));
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $chosenoffer = $offersTable->findById($this->request->data['id'])->first();
            $reservationsTable = TableRegistry::get('Reservations');
            if (is_null($reservationsTable->findByOfferId($chosenoffer['id'])->first())) {
                $chosenoffer = $offersTable->patchEntity($chosenoffer, $this->request->data);
                if ($offersTable->save($chosenoffer)) {
                    $this->Flash->success(__('Oferta modificada'));
                    return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
                } else {
                    $this->Flash->error(__('La oferta no se ha modificado, por favor, inténtelo de nuevo'));
                }
            }
            else {
                $this->Flash->error(__('Esta oferta tiene reservas y no se puede modificar'));
            }
        }
        $this->set(compact('offers'));
    }

    public function search () {

        /* Busco las ofertas disponibles */ 
        $offersTable = TableRegistry::get('Offers');
        $this->paginate = ['finder'=>['NotOfferedBy'=>[     // Busco las ofertas no hechas por el usuario
            'user_id' => $this->request->session()->read('Auth.User.id')]],
                'region_id' => '',
                'province_id' => '',
                'municipality_id' => '',
            'limit' => 5, 'contain' => ['Vehicles']];
        $offers = $this->paginate($offersTable);    
        if (is_null($offers->first())) {    // Verifico primero si hay ofertas disponibles      
                $this->Flash->error(__('Actualmente no hay disponible ninguna oferta'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        
        /* Busco la información en las otras tablas para los desplegables */
        $regionsTable = TableRegistry::get('Regions');
        $regions = $regionsTable->find('list')->order(['name'=>'ASC']);
       
        if ($this->request->is('post')) {       // Busco las ofertas, pero ahora filtradas
            $this->paginate = ['finder'=>['NotOfferedBy'=>[
                'user_id' => $this->request->session()->read('Auth.User.id'),
                'region_id' => $this->request->data['region_id'],
                'province_id' => $this->request->data['province_id'],
                'municipality_id' => $this->request->data['municipality_id']]],
                'limit' => 10, 'contain' => ['Vehicles']];
            $offers = $this->paginate($offersTable); // Filtro de nuevo las ofertas con los criterios establecidos
        }
        $this->set(compact('offers', 'regions'));
    }
}