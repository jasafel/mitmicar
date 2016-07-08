<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Users;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;

class FavouritesController extends AppController {

	public function add($id) {

		$this->autoRender = false;

        /* Creo el nuevo registro en la tabla */
   		$favouritesTable = TableRegistry::get('Favourites');
		$favourite = $favouritesTable->newEntity();
        $favourite['user1_id'] = $this->request->session()->read('Auth.User.id');
        $favourite['user2_id'] = $id;
        $favourite['ischecked'] = false;
        if ($favouritesTable->save($favourite)) {
            $this->Flash->success(__('El usuario ha sido marcado como favorito'));
            $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('La acción no se ha podido realizar, por favor, inténtelo de nuevo.'));
        }
	}

    public function review() {

        $favouritesTable = TableRegistry::get('Favourites');
        $this->paginate = ['finder'=>['Favs'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 5];
        $favourites = $this->paginate($favouritesTable);
        $followers = $favouritesTable->find('followers', ['user_id' => $this->request->session()->read('Auth.User.id')]);      // Recopilo los usuarios que me han marcado como favoritos
        
        if (!is_null($followers->first())) {    // Verifico si hay algún resultado
            $followers = $followers->count();       // Si algo, los cuento
        }
        else {
            $followers = 0;     // Si no, es que no hay seguidores
        }

        if (is_null($favourites->first()) && (!$followers)) {          
            $this->Flash->error(__('No tienes ningún usuario favorito ni nadie te ha incluido en sus favoritos'));
            return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        else if (is_null($favourites->first()) && ($followers)) {
            $this->Flash->success(__('No tienes ningún usuario favorito.'));
        }
        $this->set(compact('favourites', 'followers'));
    }

    public function delete($favourite_id) {

        $this->autoRender = false;

        $favouritesTable = TableRegistry::get('Favourites');
        $favourite = $favouritesTable->get($favourite_id);
        if (($favourite->user1_id) == $this->request->session()->read('Auth.User.id')) {
            if ($favouritesTable->delete($favourite)) {
                $this->Flash->success(__('El usuario se ha eliminado como favorito'));
                return $this->redirect(array('controller' => 'Favourites', 'action' => 'review'));
            } else {
                $this->Flash->error(__('La eliminación no se ha podido realizar, por favor, inténtelo de nuevo.'));
            }
        }
    }

    public function check() {

        $favouritesTable = TableRegistry::get('Favourites');
        $this->paginate = ['finder'=>['Followers'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 5];
        $favourites = $this->paginate($favouritesTable);
        foreach ($favourites as $favourite){}       // Verifico primero si hay información que poder modificar
        if (is_null($favourite)) {          
                $this->Flash->error(__('Ningún usuario te ha marcado como favorito'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        $this->set(compact('favourites'));
    }

    public function ignore($favourite_id)  {

        $this->autoRender = false;

        $favouritesTable = TableRegistry::get('Favourites');
        $favourite = $favouritesTable->get($favourite_id);
        $favourite['ischecked'] = true;
        if ($favouritesTable->save($favourite)) {
            $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('La acción no se ha podido realizar, por favor, inténtelo de nuevo.'));
        }

    }
}