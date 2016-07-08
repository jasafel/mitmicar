<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use App\Form\CreditsForm;
use App\Form\PasswordForm;

class UsersController extends AppController {

	public function beforeFilter(Event $event) {
    
    	parent::beforeFilter($event);
    	$this->Auth->allow(['add', 'login']); // Métodos permitidos sin autenticación
    }

	public function login() {

	    if ($this->Auth->user('id')) {
	    	return $this->redirect($this->Auth->redirectUrl());
	    }
	    if ($this->request->is('post')) {
    	    $user = $this->Auth->identify();
    	    if ($user) {
	        	$this->Auth->setUser($user);
            	return $this->redirect($this->Auth->redirectUrl());
        	} else {
	            $this->Flash->error(__('Usuario o contraseña incorrectos'), ['key' => 'auth']);
        	}
	    }
	}

	public function logout() {
    	return $this->redirect($this->Auth->logout());
	}

    public function view($id) {

        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->find('ByIdExtended', ['user_id' => $id])->first();
		
		$favouritesTable = TableRegistry::get('Favourites');
		$isMyFavourite = $favouritesTable->isFavourite($this->request->session()->read('Auth.User.id'), $id);
		$imHisFavourite = $favouritesTable->isFavourite($id, $this->request->session()->read('Auth.User.id'));
		
		$private = ['dni' => 0, 'email' => 0, 'address' => 0 , 'postcode' => 0, 'municipality' => 0, 'province' => 0, 'region' => 0];

		// Para cada dato personal, si es privado o es sólo para favoritos y yo no lo soy, pongo el flag de privacidad para que la vista no muestre el dato
		if (($user->priv_dni_id == 1) || (($user->priv_dni_id == 2) && (!$imHisFavourite))) { 
			$private['dni'] = 1;	
		}
		if (($user->priv_email_id == 1) || (($user->priv_email_id == 2) && (!$imHisFavourite))) { 
			$private['email'] = 1;
		}
		if (($user->priv_address_id == 1) || (($user->priv_address_id == 2) && (!$imHisFavourite))) { 
			$private['address'] = 1;
		}
		if (($user->priv_postcode_id == 1) || (($user->priv_postcode_id == 2) && (!$imHisFavourite))) { 
			$private['postcode'] = 1;
		}
		if (($user->priv_municipality_id == 1) || (($user->priv_municipality_id == 2) && (!$imHisFavourite))) { 
			$private['municipality'] = 1;
		}
		if (($user->priv_province_id == 1) || (($user->priv_province_id == 2) && (!$imHisFavourite))) { 
			$private['province'] = 1;
		}
		if (($user->priv_region_id == 1) || (($user->priv_region_id == 2) && (!$imHisFavourite))) { 
			$private['region'] = 1;
		}

        $this->set(compact('user', 'isMyFavourite', 'private'));
    }

    public function changepass() {

		$usersTable = TableRegistry::get('Users');
		$user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();

		if ($this->request->is('post') || $this->request->is('put')) {
            $user = $usersTable->patchEntity($user, [
                    'old_password'=>$this->request->data['old_password'],
                    'password' => $this->request->data['password1'],
                    'password1' => $this->request->data['password1'],
                    'password2' => $this->request->data['password2']
                ],
                ['validate' => 'password']
            );
            if ($usersTable->save($user)) {
                $this->Flash->success('La contraseña ha sido actualizada');
       			return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
            } else {
                $this->Flash->error('La contraseña no se ha actualizado, por favor, inténtalo de nuevo');
            }
        }
		$this->set(compact('user'));	   
    }	

	public function add() {
   		
   		/* Creo el nuevo registro en la tabla */
   		$usersTable = TableRegistry::get('Users');
		$user = $usersTable->newEntity();
		
		/* Busco la información en las otras tablas para los desplegables */
		$regionsTable = TableRegistry::get('Regions');
		$regions = $regionsTable->find('list')->order(['name'=>'ASC']);

		$privaciesTable = TableRegistry::get('Privacies');
		$privacies = $privaciesTable->find('list');

		$this->set(compact('user', 'regions','provinces','municipalities','privacies'));

		$parametersTable = TableRegistry::get('Parameters');
		$initialcredits = $parametersTable->findByCode('INICREDITS')->first()->value;
	
 		if ($this->request->is('post')) {
            $user->created = Time::now();
            $user->credits = $initialcredits;
            $user = $usersTable->patchEntity($user, $this->request->data);
            if ($usersTable->save($user)) {
                $this->Flash->success(__('Usuario creado'));
                return $this->redirect(array('action' => 'login'));
            } else {
                $this->Flash->error(__('El usuario no se ha creado, por favor, inténtalo de nuevo.'));
            }
        }
	}

	public function modify() {
	   
		$usersTable = TableRegistry::get('Users');
		$user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();

		/*Busco la información en las otras tablas para los desplegables */
		$regionsTable = TableRegistry::get('Regions');
		$regions = $regionsTable->find('list')->order(['name'=>'ASC']);

		$privaciesTable = TableRegistry::get('Privacies');
		$privacies = $privaciesTable->find('list');
		$this->set(compact('regions','provinces','municipalities','privacies'));

    	if ($this->request->is('post') || $this->request->is('put')) {
	        if ($this->request->data['region_id'] == 0) {
	        	$this->request->data['region_id'] = null;	
	        }
	        if ($this->request->data['province_id'] == 0) {
	        	$this->request->data['province_id'] = null;	
	        }
	        if ($this->request->data['municipality_id'] == 0) {
	        	$this->request->data['municipality_id'] = null;	
	        }
	        $user = $usersTable->patchEntity($user, $this->request->data);

        	if ($usersTable->save($user)) {
       			$this->Flash->success(__('Usuario actualizado'));
       			return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
            } else {
                $this->Flash->error(__('El usuario no se ha podido actualizar, por favor, inténtalo de nuevo.'));
            }
    	} else {
			$this->request->data = $user;
		}
	   	$this->set(compact('user'));
	}	

	public function credits() {

		$usersTable = TableRegistry::get('Users');
		$credits = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first()->credits;
		$this->set(compact('credits'));
	}
	
	public function buycredits() {

		$usersTable = TableRegistry::get('Users');
		$user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();

		$parametersTable = TableRegistry::get('Parameters');
		
		$creditcost = $parametersTable->findByCode('CREDITCOST')->first()->value;
		$credits = new CreditsForm();
        
        if ($this->request->is('post')) {
            if ($credits->execute($this->request->data)) {
            	$spent = $this->request->data['number'] * $creditcost;
				$user->credits += $this->request->data['number'];
				$user = $usersTable->patchEntity($user, $this->request->data);
				if ($usersTable->save($user)) {
	       			$this->Flash->success(__('Has gastado ' . $spent . ' euros. Tus créditos han sido actualizados'));
	       			return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
	            } else {
	                $this->Flash->error(__('No se han podido actualizar tus créditos, por favor, inténtalo de nuevo.'));
	            }
	        }
		}
		$this->set(compact('user', 'credits', 'creditcost'));
	}

	public function sellcredits() {

		$usersTable = TableRegistry::get('Users');
		$user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();
		$parametersTable = TableRegistry::get('Parameters');
		$creditvalue = $parametersTable->findByCode('CREDITVALUE')->first()->value;
		$credits = new CreditsForm();
        if ($this->request->is('post')) {
            if ($credits->execute($this->request->data)) {
				if ($user->credits >= $this->request->data['number']) {
					$earned = $this->request->data['number'] * $creditvalue;
					$user->credits -= $this->request->data['number'];
					$user = $usersTable->patchEntity($user, $this->request->data);
					if ($usersTable->save($user)) {
		       			$this->Flash->success(__('Has ganado ' . $earned . ' euros. Tus créditos han sido actualizados'));
		       			return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
		            } else {
		                $this->Flash->error(__('No se han podido actualizar tus créditos, por favor, inténtalo de nuevo.'));
		            }
		        } else {
		        	$this->Flash->error(__('No dispones de créditos suficientes'));
		       		return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
		        }
	        }
		}
		$this->set(compact('user', 'credits', 'creditvalue'));
	}
}
?>