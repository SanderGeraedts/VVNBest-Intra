<?php

/**
* 
*/

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'vvn-intra');

class Database
{
	private $conn;

	public function __construct(){
		$this->conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
	}

	public function __destruct(){
		mysqli_close($this->conn);
	}

	private function executeSQL($sql){
		if($this->conn->query($sql)){
			return true;
		}else{
			echo $sql;
			return false;
		}
	}

	private function sanitate($array) {
		foreach ($array as $key => $value) {
			if(is_array($value)) {
				$this->sanitate($value);
			}else {
				$array[$key] = mysqli_real_escape_string($this->conn, $value);
			}
			return $array;
		}
	}

	public function CheckLogin($username, $password){
		$username = mysqli_real_escape_string($this->conn, $username);
		$password = mysqli_real_escape_string($this->conn, $password);

		$sql = "SELECT * FROM VVN_USER WHERE Username = UPPER('" . $username . "') AND Password = '" . $password . "';";

		$command = @mysqli_query($this->conn, $sql);

		if($command){
			while($row = mysqli_fetch_array($command)) {
				$user = new User(array('id'=>$row['Id'], 'name'=>$row['Name'], 'username'=>$row['Username'], 'password'=>$row['Password'], 'email'=>$row['Email']));
			}
		}

		if(isset($user)) {
			return $user;
		}else {
			return false;
		}
	}

	private function getSenderForMessage($messages_old){
		$messages = array();

		foreach ($messages_old as $message_old) {
			$sql = "SELECT u.Id, u.Name FROM VVN_USER u, MESSAGE m WHERE u.Id = m.UserId AND m.Id = " . $message_old->id . ";";

			$command = @mysqli_query($this->conn, $sql);

			if($command) {
				while($row = mysqli_fetch_array($command)) {
					$user = new User(array('id'=>$row['Id'], 'name'=>$row['Name']));
					$message = new Message(array('id'=>$message_old->id, 'date'=>$message_old->date, 'title'=>$message_old->title, 'text'=>$message_old->text, 'sender'=>$user));
					array_push($messages, $message);
				}
			}
		}
		return $messages;
	}

	public function getMessages() {
		$sql = "SELECT * FROM MESSAGE;";

		$command = @mysqli_query($this->conn, $sql);

		$messages = array();

		if($command){
			while($row = mysqli_fetch_array($command)) {
				$message = new Message(array('id'=>$row['Id'], 'date'=>$row['DateSent'], 'title'=>$row['Title'], 'text'=>$row['MessageText']));
				array_push($messages, $message);
			}
		}

		$messages = $this->getSenderForMessage($messages);
		return $messages;
	}

	public function getMessagesForUser($id) {
		$id = mysqli_real_escape_string($this->conn, $id);

		$sql = "SELECT * FROM MESSAGE m, MESSAGE_USER u WHERE u.MessageId = m.Id AND u.UserId = " . $id . ";";

		$command = @mysqli_query($this->conn, $sql);

		$messages = array();

		if($command){
			while($row = mysqli_fetch_array($command)) {
				$message = new Message(array('id'=>$row['Id'], 'date'=>$row['DateSent'], 'title'=>$row['Title'], 'text'=>$row['MessageText']));
				array_push($messages, $message);
			}
		}

		$messages = $this->getSenderForMessage($messages);
		return $messages;
	}

	public function getTasks() {
		$sql = "SELECT * FROM TASK;";
		$command = @mysqli_query($this->conn, $sql);

		$tasks = array();

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$task = new Task(array('id'=>$row['Id'], 'name'=>$row['Name'], 'description'=>$row['Description'], 'deadline'=>$row['Deadline']));
				array_push($tasks, $task);
			}
		}

		return $tasks;
	}

	public function getTasksForUser($id) {
		$id = mysqli_real_escape_string($this->conn, $id);

		$sql = "SELECT * FROM TASK WHERE UserId = " . $id . ";";
		$command = @mysqli_query($this->conn, $sql);

		$tasks = array();

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$task = new Task(array('id'=>$row['Id'], 'name'=>$row['Name'], 'description'=>$row['Description'], 'deadline'=>$row['Deadline']));
				array_push($tasks, $task);
			}
		}

		return $tasks;
	}

	public function getAgendaForUser($id) {
		$id = mysqli_real_escape_string($this->conn, $id);

		$sql = "SELECT * FROM VVN_EVENT e, USER_EVENT u WHERE e.Id = u.EventId AND u.UserId = " . $id . ";";
		$command = @mysqli_query($this->conn, $sql);

		$events = array();

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$event = new Event(array('id'=>$row['Id'], 'name'=>$row['Name'], 'date'=>$row['DateEvent'], 'location'=>$row['Location'], 'description'=>$row['Description']));
				array_push($events, $event);
			}
		} 
		$agenda = new Agenda(array('events'=>$events));
		return $agenda;
	}

	public function getMeetings() {
		$sql = "SELECT * FROM VVN_EVENT e, MEETING m WHERE e.Id = m.EventId;";
		$command = @mysqli_query($this->conn, $sql);

		$meetings = array();

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$meeting = new Meeting(array('id'=>$row['Id'], 'name'=>$row['Name'], 'date'=>$row['DateEvent'], 'location'=>$row['Location'], 'description'=>$row['Description']));
				array_push($meetings, $meeting);
			}
		}

		return $meetings;
	}

	public function getEvents() {
		$sql = "SELECT e.* FROM VVN_EVENT e LEFT JOIN MEETING m ON e.Id = m.EventId WHERE m.EventId IS NULL;";
		$command = @mysqli_query($this->conn, $sql);

		$events = array();

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$event = new Event(array('id'=>$row['Id'], 'name'=>$row['Name'], 'date'=>$row['DateEvent'], 'location'=>$row['Location'], 'description'=>$row['Description']));
				array_push($events, $event);
			}
		}

		return $events;
	}

	public function getNumberOfFiles($id){
		$id = mysqli_real_escape_string($this->conn, $id);
		$sql = "SELECT COUNT(*) as Result FROM FILE WHERE EventId = " . $id . ";";

		$command = @mysqli_query($this->conn, $sql);

		$result = 0;

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$result = $row['Result'];
			}
		}

		return $result;
	}

	public function getNumberOfItems($id){
		$id = mysqli_real_escape_string($this->conn, $id);
		$sql = "SELECT COUNT(*) as Result FROM MEETINGITEM WHERE MeetingId = " . $id . ";";

		$command = @mysqli_query($this->conn, $sql);

		$result = 0;

		if($command) {
			while($row = mysqli_fetch_array($command)) {
				$result = $row['Result'];
			}
		}

		return $result;
	}
}

?>