<?php 

/**
 * class: 		viewEvents
 * description:	The view controller responsible for the events page. Checks if the user is logged in before loading the page.
 * methods:
 * getMessages:	Returns an array of Message Objects for the logged in user. For more info on the Message Object, go to /../logic/Message.php
 * getTasks:	Returns an array of Task Objects for the logged in user. For more info on the Task Object, go to /../logic/Task.php
 * getAgenda: 	Returns the Agenda Object for the logged in user. For more info on the Agenda Object, go to /../logic/Agenda.php 
 */

require('logic/User.php');
require('api/Database.php');
require('logic/Event.php');
require('logic/Meeting.php');
require('logic/MeetingItem.php');

class viewEvents{
	private $loggedIn;

	public function __construct() {
		if($_SESSION['loggedIn'] != null){
			$this->loggedIn = unserialize($_SESSION['loggedIn']);
		}else {
			header('Location: login.php');
			$_SESSION['last_page'] = __FILE__;
			die();
		}
	}

	public function getMeetings() {
		$database = new Database();
		$meetings = $database->getMeetings();
		return $meetings;
	}

	public function getEvents() {
		$database = new Database();
		$events = $database->getEvents();
		return $events;
	}

	public function getNumberOfFiles($id) {
		$database = new Database();
		$number = $database->getNumberOfFiles($id);
		return $number;
	}

	public function getNumberOfItems($id) {
		$database = new Database();
		$number = $database->getNumberOfItems($id);
		return $number;
	}
}

?>