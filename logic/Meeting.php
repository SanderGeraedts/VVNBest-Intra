<?php

/**
* 
*/
class Meeting extends Event
{
	private $previous_meeting;
	private $items;

	private static $fillable = array('previous_meeting', 'items');
	private static $accessible = array('previous_meeting', 'items');

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
		$this->fillable = array_merge(parent::$fillable, this->fillable);
		$this->fillable = array_merge(parent::$accessible, this->accessible);

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