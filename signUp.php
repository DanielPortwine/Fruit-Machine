<?php
require_once('header.php');
$taken = false;
$rows = $conn->query("SELECT userID FROM users;")->num_rows;
if ($rows > 0) {
	foreach ($conn->query("SELECT username FROM users;") as $user) {
		if ($_POST['username'] == $user['username']) {
			$taken = true;
			break;
		}
	}
}
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
	$conn->query("INSERT INTO users (username,email,news,pass,salt) VALUES ('{$_POST['username']}','{$_POST['email']}',{$consent},'{$password}','{$salt}');");
	$_SESSION['alert'] = 'Account created';
	$_SESSION['alert-type'] = 'success';
	$_SESSION['username'] = $_POST['username'];
	echo '<script>window.location = "play.php";</script>';
}
else {
	$_SESSION['alert'] = 'Username taken';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "index.php";</script>';
}
?>