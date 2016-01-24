<?php 

session_start();
$error = "";

if(isset($_POST['tbUsername']) && $_POST['tbPassword']) {
    require('view/viewLogin.php');

    $username = $_POST['tbUsername'];
    $password = $_POST['tbPassword'];

    $view = new viewLogin();

    if($view->checkLogin($username, $password) == false){
        $error = "Uw gegevens zijn onjuist.";
    }


} else if(isset($_POST['btnLogin'])){
    $error = "Sommige gegevens zijn niet ingevuld.";
}

?>

<!DOCTYPE html>

<html>
	<head>
		<title>VVNBest Intra</title>
		<link href="assets/css/style.css" rel = stylesheet />
		<link href="assets/img/favicon.png" rel="shortcut icon">
		<meta name="description" content="XO backend app">
		<meta name="author" content="Code Panda - www.codepanda.nl">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<script type="text/javascript" src="assets/js/main.js"></script>
	</head>
	<body>
		<header id="head">
			<div class="wrapper">
				<div class="logo">VVNBest <span>Intranet</span></div>
			</div>
		</header>
		<main class="wrapper">
			<form id="login" method="POST" action="login.php">
				<?php if($error != null){ echo '<span id="error_login" class="error">' . $error . '</span>';} ?>
				<label for="tbUsername">Gebruikersnaam:</label><br />
				<input id="tbUsername" type="text" name="tbUsername" placeholder="voorletter.achternaam"><br />
				<label for="tbPassword">Wachtwoord:</label><br />
				<input id="tbPassword" type="password" name="tbPassword" placeholder="Password"><br />
				<input name="btnLogin" type="submit" value="Log in">
			</form>
		</main>
	</body>
</html>