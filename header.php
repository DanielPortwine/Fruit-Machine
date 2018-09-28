<?php
session_start();
require_once('connection.php');
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
<!--<div class="alert alert-danger alert-dismissable fade show">
	Site is currently being actively developed please come back later
</div>-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a href="index.php" class="navbar-brand">Fruit Machine</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarContent">
		<ul class="navbar-nav mr-auto">
			<li><a class="nav-item nav-link" id="playNav" href="play.php">Play</a></li>
			<li><a class="nav-item nav-link" id="statsNav" href="stats.php">Stats</a></li>
			<li><a class="nav-item nav-link" id="leaderboardNav" href="leaderboard.php">Leaderboard</a></li>
			<?php
			// show admin nav item if user is Dan
			if (isset($_SESSION['username'])){
				if ($_SESSION['username'] == 'Dan'){
					echo '<li><a class="nav-item nav-link" id="adminNav" href="admin.php">Admin</a></li>';
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
<?php
if (isset($_SESSION['username']) && isset($_SESSION['page'])){
	if ($_SESSION['username'] == 'Dan' && $_SESSION['page'] == 'play'){
		echo '
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom">
			<span class="navbar-brand">Admin controls</span>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent1" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarContent1">
				<ul class="navbar-nav mr-auto">
					<!-- play -->
					<li><button class="nav-item btn btn-success m-1" id="adminSpins">+20 Spins</button></li>
					<li><button class="nav-item btn btn-success m-1" id="adminBeers">+10 Beers</button></li>
					<li>
						<form class=" m-1">
							<input class="itemEntry" id="rItem1" type="number" min="0" max="13">
							<input class="itemEntry" id="rItem2" type="number" min="0" max="13">
							<input class="itemEntry" id="rItem3" type="number" min="0" max="13">
							<input class="itemEntry" id="rItem4" type="number" min="0" max="13">
							<input class="itemEntry" id="rItem5" type="number" min="0" max="13">
							<input class="btn btn-success" type="button" id="spinButtonRigged" value="SPIN">
						</form>
					</li>
				</ul>
			</div>
		</nav>';
	}
}
?>