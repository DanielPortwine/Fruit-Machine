<?php
if ($_SERVER['HTTP_DPTESTING'] == 'trueg') {
    echo '<script>window.location = "testing/' . $_SERVER['REQUEST_URI'] . '";</script>';
}

require_once('connection.php');
session_start();

// enable debug tools if DanPortwine user
if (isset($_SESSION['username']) && $_SESSION['username'] === 'DanPortwine') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// collect visitor's IP and userID if logged in
$visitorIP = $_SERVER['REMOTE_ADDR'];
$query = mysqli_fetch_row($conn->query("SELECT * FROM visitors WHERE visitorIP = '{$visitorIP}';"));
if (isset($_SESSION['username'])) {
    $userID = mysqli_fetch_row($conn->query("SELECT userID FROM users WHERE username = '{$_SESSION['username']}'"))[0];
}
$visitorDataCollected = false;
if ($query[1] == $visitorIP && empty($query[2])) {
    $sql = "UPDATE visitors SET userID = {$userID} WHERE visitorID = {$query[0]}";
} else if ($query[1] != $visitorIP && isset($_SESSION['username'])) {
    $sql = "INSERT INTO visitors (visitorIP, userID) VALUES ('{$visitorIP}', {$userID})";
} else if ($query[1] != $visitorIP && !isset($_SESSION['username'])) {
    $sql = "INSERT INTO visitors (visitorIP) VALUES ('{$visitorIP}')";
} else {
    $visitorDataCollected = true;
}
if ($visitorDataCollected === false) {
    $conn->query($sql);
}

// display an alert
if (isset($_SESSION['alert'])) {
	echo '<div class="alert alert-' . $_SESSION['alert-type'] . ' alert-dismissable fade show" id="alertBox">
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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="images/items/gulhhess.png">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="script.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a href="index" class="navbar-brand">Fruit Machine</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarContent">
		<ul class="navbar-nav mr-auto">
			<li><a class="nav-item nav-link" id="playNav" href="play">Play</a></li>
			<li><a class="nav-item nav-link" id="statsNav" href="stats">Stats</a></li>
			<li><a class="nav-item nav-link" id="leaderboardNav" href="leaderboard">Leaderboard</a></li>
			<?php
			// show admin nav item if user is DanPortwine
			if (isset($_SESSION['username'])){
				if ($_SESSION['username'] == 'DanPortwine'){
					echo '<li><a class="nav-item nav-link" id="adminNav" href="admin">Admin</a></li>';
				}
			}
			?>
		</ul>
		<?php
		// if user is logged in display their level and username as well as logout button
		if (isset($_SESSION['username'])) {
			echo '<span class="navbar-text mr-3"><span class="px-2 py-1 rounded-left" id="userLevel">' . mysqli_fetch_row($conn->query("SELECT xplevel FROM users WHERE username = '{$_SESSION['username']}';"))[0] . '</span><span class="px-3 py-1 rounded-right" id="userName">' . $_SESSION['username'] . '</span></span>
				<button class="btn btn-danger" id="logoutButton">Logout</button>
				';
		}
		?>
	</div>
</nav>