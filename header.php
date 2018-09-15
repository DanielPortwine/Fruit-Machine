<?php
session_start();
$conn = new mysqli('localhost:3307','root','','fruitmachine');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<html>
<head>
	<title>Fruit machine</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="script.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a href="index.php" class="navbar-brand">Fruit Machine</a>
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<div class="navbar-nav">
			<a class="nav-item nav-link" href="game.php">Play</a>
			<a class="nav-item nav-link" href="leaderboard.php">Leaderboard</a>
			<a class="nav-item nav-link" href="stats.php">Stats</a>
			<a class="nav-item nav-link" href="edit.php">Edit</a>
		</div>
	</div>
</nav>