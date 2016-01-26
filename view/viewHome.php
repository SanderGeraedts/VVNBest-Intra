<?php

/**
 * class: 		viewHome
 * description:	The view controller responsible for the homepage. Checks if the user is logged in before loading the page.
 * methods:
 * getMessages:	Returns an array of Message Objects for the logged in user. For more info on the Message Object, go to /../logic/Message.php
 * getTasks:	Returns an array of Task Objects for the logged in user. For more info on the Task Object, go to /../logic/Task.php
 * getAgenda: 	Returns the Agenda Object for the logged in user. For more info on the Agenda Object, go to /../logic/Agenda.php 
 */

require('logic/User.php');
require('api/Database.php');
require('logic/Message.php');
require('logic/Task.php');
require('logic/Agenda.php');
require('logic/Event.php');

class viewHome{
	private $loggedIn;

	public function __construct(){
		if($_SESSION['loggedIn'] != null){
			$this->loggedIn = unserialize($_SESSION['loggedIn']);
		}else {
			header('Location: login.php');
			$_SESSION['last_page'] = __FILE__;
			die();
		}
	}

	public function getMessages(){
		$database = new Database();
		$messages = $database->getMessagesForUser($this->loggedIn->id);
		return $messages;
	}

	public function getTasks(){
		$database = new Database();
		$tasks = $database->getTasksForUser($this->loggedIn->id);
		return $tasks;
	}

	public function getAgenda(){
		$database = new Database();
		$agenda = $database->getAgendaForUser($this->loggedIn->id);
		return $agenda;
	}
}

?>