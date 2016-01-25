<?php

/**
* 
*/
class Message
{
	private $id;
	private $date;
	private $title;
	private $text;
	private $sender;
	private $receivers;

	private $fillable = array('title', 'text', 'sender');
	private $accessible = array('id', 'date', 'title', 'text', 'sender', 'receivers');
	private $required = array('id', 'date', 'text');

	public function __set ($name, $value) {
		if (in_array($name, $this->fillable)) {
			if (isset($this->$name)) {
				$this->$name = $value;
			}
		}

		return null;
	}

	public function __get ($name) {
		if (in_array($name, $this->accessible)) {
			if (isset($this->$name)) {
				return $this->$name;
			}
		}
		return null;
	}

	public function __construct(Array $params = array()){
		if(count($params) > 0){
			foreach ($params as $key => $value) {
				$this->$key = $value;
			}

			foreach($this->required as $key){
				if(!isset($this->$key)){
					throw new \InvalidArgumentException("Invalid use of constructor:\n" . $key . " can't be empty");
				}
			}
		}
	}
}

?>