<?php 

/**
 * class: 				viewEvents
 * description:			The view controller responsible for the events page. Checks if the user is logged in before loading the page.
 * -methods-
 * getMeetings:			Returns an array of all the Meeting Objects in the Database. For more info on the Meeting Object, go to /../logic/Meeting.php
 * getEvents:			Returns an array of all the Event Objects in the Database. For more info on the Event Object, go to /../logic/Event.php
 * getNumberOfFiles:	Returns the number of files linked to a given Meeting or Event.
 * getNumberOfItems:	Returns the number of MeetingItems linked to a given Meeting.
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