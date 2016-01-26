<?php 

session_start();

require('view/viewEvents.php');

$view = new viewEvents();

$meetings = $view->getMeetings();
$events = $view->getEvents();
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
			<article id="meetings" class="item">
				<h1>Vergaderingen:</h1>
				<?php foreach($meetings as $meeting) { ?>
				<section class="meeting">
					<span class="meeting_link">
						<a href="events.php?id=<?php echo $meeting->id; ?>">Link</a>
					</span>
					<span class="meeting_date">Datum: <?php echo $meeting->date; ?></span>
					<span class="meeting_files">
						<a href="files.php?eventid=<?php echo $meeting->id; ?>">Bestanden:</a>
						 <?php echo $view->getNumberOfFiles($meeting->id); ?>
					</span>
					<span class="meeting_points">
						Bespreekpunten: <?php echo $view->getNumberOfItems($meeting->id); ?>
					</span>
				</section>
				<?php } ?>
			</article>
			<article id="events" class="item">
				<h1>Acties</h1>
				<?php foreach($events as $event) { ?>
				<section class="event">
					<span class="event_link">
						<a href="events.php?id=<?php echo $event->id; ?>">Link</a>
					</span>
					<span class="event_date">Datum: <?php echo $event->date; ?></span>
					<span class="event_title">Naam: <?php echo $event->name; ?></span>
					<span class="event_files">
						<a href="files.php?eventid=<?php echo $event->id; ?>">Bestanden:</a>
						 <?php echo $view->getNumberOfFiles($event->id); ?>
					</span>
				</section>
				<?php } ?>
			</article>
		</main>
	</body>
</html>