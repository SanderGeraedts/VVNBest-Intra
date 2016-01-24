<?php

/**
* 
*/
class Task
{
	private $id;
	private $name;
	private $description;
	private $deadline;
	private $assigned_to;

	private $fillable = array('name', 'description', 'deadline', 'assigned_to');
	private $accessible = array('id', 'name', 'description', 'deadline', 'assigned_to');
	private $required = array('id', 'name');
}

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
				throw new \InvalidArgumentException('Invalid use of constructor:\n' . $key . ' can\'t be empty');
			}
		}
	}
}

?>