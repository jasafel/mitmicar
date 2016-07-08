<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Users;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use App\Form\FeedbackForm;

class VotesController extends AppController {

	public function review() {

        $votesTable = TableRegistry::get('Votes');
        $this->paginate = ['finder'=>['Pending'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 5];
        $votes = $this->paginate($votesTable);  // Obtengo un listado (paginado en 5) de los votos pendientes

        if (is_null($votes->first())) {   // Verifico primero si hay información que poder modificar       
                $this->Flash->success(__('No tienes ningún voto pendiente'));
                return $this->redirect(array('controller' => 'Pages', 'action' => 'home'));
        }
        $this->set(compact('votes'));
	}

    public function feedback($vote_id) {

        $votesTable = TableRegistry::get('Votes');
        $vote = $votesTable->findById($vote_id)->contain(['Reservations.Offers.Vehicles'])->first();
        $answersTable = TableRegistry::get('Answers');
        $answers = $answersTable->findByVoteId($vote_id)->contain(['Questions'])->toArray();
        $posiblevalues = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];
        $usersTable = TableRegistry::get('Users');      // Para actualizar los créditos del usuario al que estoy votando
        if ($vote->isowner) { // El usuario al que le tengo que sumar créditos es el que hizo la reserva
            $user = $usersTable->findById($vote->reservation->user_id)->first();    
        }
        else {  // El usuario al que le tengo que sumar créditos es el propietario del vehículo
            $user = $usersTable->findById($vote->reservation->offer->vehicle->user_id)->first();    
        }

        // Consulta el premio en créditos por un voto positivo, el umbral a partir del que sumaré créditos adicionales y la ponderación por cada valor adicional a partir de ahí
        $parametersTable = TableRegistry::get('Parameters');        
        $positivevalue = $parametersTable->findByCode('POSITIVE')->first()->value;
        $thresholdvalue = $parametersTable->findByCode('THRESHOLD')->first()->value;  
        $weightvalue = $parametersTable->findByCode('WEIGHT')->first()->value;  

        $feedback = new FeedbackForm();
        if ($this->request->is('post')) {
            if ($feedback->execute($this->request->data)) {
                $i = 0;
                $credits = 0;   // Aquí iré sumando créditos según lo positivo que sean los votos
                foreach ($answers as $answer) {  
                    $answer->value = $this->request->data['values'][$i];
                    $credits += max(0, ($answer->value - $thresholdvalue)) * $weightvalue; // Aumento créditos por respuestas altas
                    $answersTable->save($answer);
                    $i++;
                }
                $vote->ispositive = $this->request->data['ispositive'];
                $vote->description = $this->request->data['description'];
                if ($vote->ispositive) {
                    $credits += $positivevalue;     // Aumento créditos por voto positivo
                }
                $user->credits += $credits;   // Aumento todos los créditos sumados
                $usersTable->save($user);
                if ($votesTable->save($vote)) {
                    $this->Flash->success(__('El voto ha sido guardado'));
                    return $this->redirect(array('controller' => 'Votes', 'action' => 'review'));
                } else {
                    $this->Flash->error(__('El voto no se ha podido guardar, por favor, inténtelo de nuevo.'));
                }
            }
        }
        $this->set(compact('feedback', 'answers', 'posiblevalues'));
    }

    public function history($user_id) {

        $votesTable = TableRegistry::get('Votes');
        $this->paginate = ['finder'=>['Evaluation'=>['user_id' => $this->request->session()->read('Auth.User.id')]], 'limit' => 5];
        $votes = $this->paginate($votesTable);  // Obtengo un listado (paginado en 5) de los votos hechos sobre el usuario
        $totalvotes = $votes->count();
        $positivevotes = $votesTable->find('Positives', ['user_id' => $this->request->session()->read('Auth.User.id')])->count();
        $positivepercent = number_format((($positivevotes / $totalvotes) * 100), 2, '.', ''); // Calculo el porcentaje formateado a 2 decimales
       
        foreach ($votes as $vote){}       // Verifico primero si hay información que poder modificar
        if (is_null($vote)) {          
                $this->Flash->success(__('El usuario no tiene ninguna valoración'));
                $this->redirect($this->referer());
        }
        $this->set(compact('votes','totalvotes','positivevotes', 'positivepercent'));
    }

    public function view ($vote_id) {

        $answersTable = TableRegistry::get('Answers');
        $answers = $answersTable->findByVoteId($vote_id)->contain(['Questions']);
        $this->set(compact('answers'));
    }
}