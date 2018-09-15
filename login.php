<?php
require_once('header.php');
$rows = $conn->query("SELECT userID FROM users;")->num_rows;
if ($rows > 0) {
	foreach ($conn->query("SELECT username FROM users;") as $user) {
		if ($_POST['username'] == $user['username']) {
			$exists = true;
			break;
		}
	}
}
if ($exists) {
	$user = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_POST['username']}';"));
	if (hash('sha512',$user[5] . $_POST['password']) === $user[4]) {
		$_SESSION['username'] = $user[1];
		$_SESSION['alert'] = 'Logged in';
		$_SESSION['alert-type'] = 'success';
		echo '<script>window.location = "play.php";</script>';
	}
	else {
		$_SESSION['alert'] = 'Incorrect username or password';
		$_SESSION['alert-type'] = 'danger';
		echo '<script>window.location = "index.php";</script>';
	}
}
else {
	$_SESSION['alert'] = 'Incorrect username or password';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "index.php";</script>';
}
?>