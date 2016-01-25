<?php

require('logic/User.php');
require('api/Database.php');

class viewLogin{

	private $username;
	private $password;

	public function checkLogin($username, $password){
		$user = User::CheckLogin($username, $password);
		if($user != false){
			$_SESSION["loggedIn"] = serialize($user);
			header('Location: index.php');
			return true;
		}else {
			return false;
		}
	}
}

?>