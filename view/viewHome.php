<?php

require('logic/User.php');
require('api/Database.php');
require('logic/Message.php');

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