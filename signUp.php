<?php
require_once('header.php');
$taken = false;
$rows = $conn->query("SELECT userID FROM users;")->num_rows;
// if there are users check if the username is taken
if ($rows > 0) {
	foreach ($conn->query("SELECT username FROM users;") as $user) {
		if ($_POST['username'] == $user['username']) {
			$taken = true;
			break;
		}
	}
}
// if the username is not taken generate password hash using salt
if (!$taken) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$salt = '';
	for ($i=0; $i<128; $i++) {
		$salt .= $characters[rand(0,35)];
	}
	$password = hash('sha512',$salt . $_POST['password']);
	if (isset($_POST['newsContent'])) {
		$consent = 1;
	}
	else {
		$consent = 0;
	}
	// create user's record in database
	$conn->query("INSERT INTO users (username,email,news,pass,salt) VALUES ('{$_POST['username']}','{$_POST['email']}',{$consent},'{$password}','{$salt}');");
	// alert user that their account has been created
	$_SESSION['alert'] = 'Account created';
	$_SESSION['alert-type'] = 'success';
	// log the user in
	$_SESSION['username'] = $_POST['username'];
	// redirect to play.php
	echo '<script>window.location = "play.php";</script>';
}
// if username is taken alert user that the username is taken and redirect to login
else {
	$_SESSION['alert'] = 'Username taken';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "index.php";</script>';
}
?>