<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;

class ReservationsController extends AppController {

    public function add($offer_id) {
        
        $this->autoRender = false;

        /* Creo el nuevo registro en la tabla */
   		$reservationsTable = TableRegistry::get('Reservations');
		$reservation = $reservationsTable->newEntity();
        $reservation['offer_id'] = $offer_id;
        $reservation['user_id'] = $this->request->session()->read('Auth.User.id');
        $reservation['reserved'] = Time::now();;
        $reservation['reqstate_id'] = 0;

        $usersTable = TableRegistry::get('Users');      // Para actualizar los créditos
        $user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();

        $offersTable = TableRegistry::get('Offers');    // Para actualizar las plazas disponibles
        $offer = $offersTable->findById($reservation->offer_id)->first();

        $parametersTable = TableRegistry::get('Parameters');        // Consulta el coste de la reserva
        $reservationcost = $parametersTable->findByCode('USECOST')->first()->value;

        if (($user->credits) >= $reservationcost) {   // Si tengo suficientes créditos
            if ($reservationsTable->save($reservation)) {
                $user->credits -= $reservationcost;     // Dismunuyo el número de créditos
                $usersTable->save($user);
                $offer->seats -= 1;                  // Disminuyo las plazas disponibles
                $offersTable->save($offer);
                $this->Flash->success(__('Reserva realizada con éxito'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
            } else {
                $this->Flash->error(__('La reserva no se ha podido realizar, por favor, inténtelo de nuevo.'));
                $this->redirect($this->referer());
            }    
        }
        else {          // Si no tengo suficientes créditos
            $this->Flash->error(__('No dispones de créditos suficientes (el coste de la reserva es de ' . $reservationcost . ' créditos)'));
            $this->redirect($this->referer());
        }
    }

    public function cancel($reservation_id) {

        $this->autoRender = false;

        $reservationsTable = TableRegistry::get('Reservations');
        $reservation = $reservationsTable->get($reservation_id);

        $usersTable = TableRegistry::get('Users');      // Para actualizar los créditos 
        $user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();

        $offersTable = TableRegistry::get('Offers');    // Para actualizar las plazas disponibles
        $offer = $offersTable->findById($reservation->offer_id)->first();

        $parametersTable = TableRegistry::get('Parameters');        
        $reservationcost = $parametersTable->findByCode('USECOST')->first()->value;  // Consulta el coste de la reserva
        $cancelcost = $parametersTable->findByCode('CANCELCOST')->first()->value; // y el de cancelación

        if (($reservation->user_id) == $this->request->session()->read('Auth.User.id')) {
            if ($reservationsTable->delete($reservation)) {
                $user->credits += ($reservationcost - $cancelcost);   // Aumento el número de créditos
                $usersTable->save($user);
                $offer->seats += 1;                  // Aumento las plazas disponibles
                $offersTable->save($offer);
                $this->Flash->success(__('La reserva ha sido cancelada'));
                return $this->redirect(array('controller' => 'Reservations', 'action' => 'modify'));
            } else {
                $this->Flash->error(__('La reserva no se ha podido cancelar, por favor, inténtelo de nuevo.'));
            }
        }
    }

    public function modify() {

        $reservationsTable = TableRegistry::get('Reservations');
        $this->paginate = ['finder'=>['ReservedBy'=>['user_id' => $this->request->session()->read('Auth.User.id')]],
            'limit' => 5];
        $reservations = $this->paginate($reservationsTable);    // Obtengo un listado (paginado en 5) de las reservas

        if (is_null($reservations->first())) {          // Verifico primero si hay información que poder modificar
                $this->Flash->error(__('No has realizado ninguna reserva'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        $this->set(compact('reservations'));
    }

    public function review() {

        $reservationsTable = TableRegistry::get('Reservations');
        $this->paginate = ['finder'=>['Requested'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 5];
        $reservations = $this->paginate($reservationsTable);  // Obtengo un listado (paginado en 5) de las solicitudes recibidas

        if (is_null($reservations->first())) {          // Verifico primero si hay información que poder modificar
                $this->Flash->error(__('No has recibido ninguna solicitud'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        $this->set(compact('reservations'));
    }

    public function approve($reservation_id) {

        $this->autoRender = false;

        $reservationsTable = TableRegistry::get('Reservations');
        $reservation = $reservationsTable->find()->where(['Reservations.id' => $reservation_id])->contain(['Offers.Vehicles.Users'])->first();

        $usersTable = TableRegistry::get('Users');      // Para actualizar los créditos al usuario que aprueba
        $user = $usersTable->findById($this->request->session()->read('Auth.User.id'))->first();

        $parametersTable = TableRegistry::get('Parameters');        
        $reservationvalue = $parametersTable->findByCode('USEVALUE')->first()->value;  // Consulta el coste de la reserva

        if ($reservation->offer->vehicle->user->id === $this->request->session()->read('Auth.User.id')) { 
            // Si la reserva es mía
            $reservation->reqstate_id = 1;      // Código en la tabla de estados para solicitud aprobada
            if ($reservationsTable->save($reservation)) {
                
                $user->credits += $reservationvalue;   // Aumento el número de créditos
                $usersTable->save($user);
                
                // Creo los nuevos nuevo registro en la tabla de votos
                $votesTable = TableRegistry::get('Votes');
                
                // Creo el voto para el pasajero (el usuario que hizo la reserva)
                $vote1 = $votesTable->newEntity();
                $vote1['reservation_id'] = $reservation->id;
                $vote1['user_id'] = $reservation->user_id;
                $vote1['isowner'] = false;
                $votesTable->save($vote1);  

                // Creo el voto para el conductor
                $vote2 = $votesTable->newEntity();
                $vote2['reservation_id'] = $reservation->id;
                $vote2['user_id'] = $reservation->offer->vehicle->user_id;
                $vote2['isowner'] = true;        
                $votesTable->save($vote2);

                $questionsTable = TableRegistry::get('Questions');
                $answersTable = TableRegistry::get('Answers');

                $questionsquery = $questionsTable->findByQuestiontypeId(1); // Creo las preguntas sobre el conductor
                foreach ($questionsquery as $question) {
                    $answer = $answersTable->newEntity();
                    $answer['vote_id'] = $vote1->id;
                    $answer['question_id'] = $question->id;
                    $answersTable->save($answer);
                }

                $questionsquery = $questionsTable->findByQuestiontypeId(2);  // Creo las preguntas sobre el pasajero
                foreach ($questionsquery as $question) {
                    $answer = $answersTable->newEntity();
                    $answer['vote_id'] = $vote2->id;
                    $answer['question_id'] = $question->id;
                    $answersTable->save($answer);
                }

                $this->Flash->success(__('La solicitud ha sido aprobada'));
                return $this->redirect(array('controller' => 'Reservations', 'action' => 'review'));
            } else {
                $this->Flash->error(__('La solicitud no se ha podido aprobar, por favor, inténtelo de nuevo.'));
            }
        } else {
                $this->Flash->error(__('Esta solicitud no se ha enviado a tu usuario.'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
    }

    public function deny($reservation_id) {

        $this->autoRender = false;

        $reservationsTable = TableRegistry::get('Reservations');
        $reservation = $reservationsTable->find()->where(['Reservations.id' => $reservation_id])->contain(['Offers.Vehicles.Users'])->first();

        $usersTable = TableRegistry::get('Users');      // Para actualizar los créditos del usuario que reservó
        $user = $usersTable->findById($reservation->user_id)->first();

        $offersTable = TableRegistry::get('Offers');    // Para actualizar las plazas disponibles
        $offer = $offersTable->findById($reservation->offer_id)->first();

        $parametersTable = TableRegistry::get('Parameters');        
        $reservationcost = $parametersTable->findByCode('USECOST')->first()->value;  // Consulta el coste de la reserva
        
        if ($reservation->offer->vehicle->user->id === $this->request->session()->read('Auth.User.id')) {
            // Si la reserva es mía
            $reservation->reqstate_id = 2;      // Código en la tabla de estados para solicitud denegada
            if ($reservationsTable->save($reservation)) {
                $user->credits += $reservationcost;   // Aumento el número de créditos
                $usersTable->save($user);
                $offer->seats += 1;                  // Aumento las plazas disponibles
                $offersTable->save($offer);
                $this->Flash->success(__('La solicitud ha sido denegada'));
                return $this->redirect(array('controller' => 'Reservations', 'action' => 'review'));
            } else {
                $this->Flash->error(__('La solicitud no se ha podido denegar, por favor, inténtelo de nuevo.'));
            }
        } else {
            $this->Flash->error(__('Esta solicitud no se ha enviado a tu usuario.'));
            return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
    }
}