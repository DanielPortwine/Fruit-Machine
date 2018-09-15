<?php
session_start();
$conn = new mysqli('localhost:3307','root','','fruitmachine');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['alert'])) {
	echo '<div class="alert alert-' . $_SESSION['alert-type'] . ' alert-dismissable fade show">
			' . $_SESSION['alert'] . '
			<button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>';
	unset($_SESSION['alert']);
	unset($_SESSION['alert-type']);
}
?>
<html>
<head>
	<title>Fruit machine</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="script.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a href="index.php" class="navbar-brand">Fruit Machine</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarContent">
		<ul class="navbar-nav mr-auto">
			<li><a class="nav-item nav-link" id="playNav" href="play.php">Play</a></li>
			<li><a class="nav-item nav-link" id="leaderboardNav" href="leaderboard.php">Leaderboard</a></li>
			<li><a class="nav-item nav-link" id="statsNav" href="stats.php">Stats</a></li>
			<li><a class="nav-item nav-link" id="editNav" href="edit.php">Edit</a></li>
		</ul>
		<?php
		if (isset($_SESSION['username'])) {
			echo '<span class="navbar-text mr-5">' . $_SESSION['username'] . '</span>';
		}
		?>
	</div>
</nav>