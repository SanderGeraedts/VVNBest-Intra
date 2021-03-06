<?php 

session_start();

require('view/viewHome.php');

$view = new viewHome();

$messages = $view->getMessages();
$tasks = $view->getTasks();
$agenda = $view->getAgenda();
?>

<!DOCTYPE html>

<html>
	<head>
		<title>VVNBest Intra</title>
		<link href="assets/css/style.css" rel = stylesheet />
		<link href="assets/img/favicon.png" rel="shortcut icon">
		<meta name="description" content="Intranet oplossing voor VVNBest">
		<meta name="author" content="Code Panda - www.codepanda.nl">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<script type="text/javascript" src="assets/js/main.js"></script>
	</head>
	<body>
		<header id="head">
			<div class="wrapper">
				<div class="logo">VVNBest <span>Intranet</span></div>
				<button id="menuToggle"><img src="assets/img/hamburger.png" alt="Menu knop"></button>
				<nav id="navigation">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="events.php">Vergadering &amp Acties</a></li>
						<li><a href="#">Bestanden</a></li>
						<li><a href="#">Taken</a></li>
						<li><a href="http://www.vvnbest.nl/roundcube">Webmail</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<main class="wrapper">
			<article id="announcements" class="item">
				<h1>Berichten</h1>
				<?php foreach ($messages as $message) { ?>
				<hr>
				<section class="">
					<h1><span><?php echo $message->date; ?>: </span><a href="#"><?php echo $message->title; ?></a> - <a href="users.php?id=<?php echo $message->sender->id;?>"><?php echo $message->sender->name; ?></a></h1>
					<p>
						<?php echo $message->text; ?>
					</p>
				</section>
				<?php } ?>
				<br/>
			</article>
			<article id="pers_tasks" class="item">
				<h1>Persoonlijke taken</h1>
				<?php foreach ($tasks as $task) { ?>
				<hr>
				<section class="task_item">
					<h1><a href="tasks.php?id=<?php echo $task->id ?>"><?php echo $task->name ?></a></h1>
					<p>
						<?php echo $task->description ?>
					</p>
				</section>
				<?php } ?>
			</article>
			<article id="pers_appointments" class="item">
				<h1>Agenda</h1>
				<?php foreach ($agenda->events as $event) { ?>
				<hr>
				<section class="appointment_item">
					<h1><p><?php echo $event->date; ?>: </p><a href="events.php?id=<?php echo $event->id; ?>"><?php echo $event->name; ?></a></h1>
				</section>
				<?php } ?>
			</article>
		</main>
	</body>
</html>