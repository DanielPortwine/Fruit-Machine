<?php
session_start();
require_once('connection.php');
// scan items directory of item images
$items = scandir('images/items');
// remove '.' and '..' elements from array
unset($items[0]);
unset($items[1]);
// if user has spins generate 5 random numbers corresponding to items in the items directory
if (mysqli_fetch_row($conn->query("SELECT spinsLeft FROM users WHERE username = '{$_SESSION['username']}';"))[0] > 0){
	for ($i=0;$i<4;$i++){
		echo mt_rand(0,sizeOf($items)-1) . ',';
	}
	echo mt_rand(0,sizeOf($items)-1);
} else {
	$_SESSION['alert'] = 'No spins left!';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "play.php";</script>';
}
?>