<?php
require_once('header.php');

// find how many records there are
$rows = $conn->query("SELECT userID FROM users;")->num_rows;
// if there are records select each username and compare with user's selected username
if ($rows > 0) {
	foreach ($conn->query("SELECT userID, username FROM users") as $user) {
		if ($_POST['username'] == $user['username']) {
			$userID = $user['userID'];
			break;
		}
	}
}

// if the username is in the database and if the passwords match log in, otherwise alert that either username or password is wrong
if (isset($userID)) {
	$query = $conn->query("SELECT * FROM users WHERE userID = '{$userID}'");
    $user = $query->fetch_array(MYSQLI_ASSOC);
	if ($user['verified'] != 1) {
	    $_SESSION['alert'] = 'Account has not been verified!';
	    $_SESSION['alert-type'] = 'danger';
	    echo '<script>window.location = "index.php"</script>';
    } else {
        if (hash('sha512', $user['salt'] . $_POST['password']) === $user['pass'] && $user['verified'] == 1) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['verified'] = true;
            $_SESSION['alert'] = 'Logged in';
            $_SESSION['alert-type'] = 'success';
            echo '<script>window.location = "play.php"</script>';
        } else {
            $_SESSION['alert'] = 'Incorrect username or password';
            $_SESSION['alert-type'] = 'danger';
            echo '<script>window.location = "index.php"</script>';
        }
    }
} else {
	$_SESSION['alert'] = 'Incorrect username or password';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "index.php"</script>';
}