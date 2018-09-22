<?php
session_start();
require_once('connection.php');
$items = scandir('images/items');
unset($items[0]);
unset($items[1]);
if (mysqli_fetch_row($conn->query("SELECT spinsLeft FROM users WHERE username = '{$_SESSION['username']}';"))[0] > 0){
	for ($i=0;$i<4;$i++){
		echo mt_rand(0,sizeOf($items)-2) . ',';
	}
	echo mt_rand(0,sizeOf($items)-2);
} else {
	$_SESSION['alert'] = 'No spins left!';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "play.php";</script>';
}
?>