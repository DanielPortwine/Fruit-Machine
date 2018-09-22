<?php
require_once('connection.php');
session_start();
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
$dailySpinTime = date($userData[8]);
$spinsLeft = $userData[7];#
$currentTime = date('Y-m-d H:i:s');
if ($dailySpinTime < $currentTime){
	$spinsLeft += 50;
	$dailySpinTime = date('Y-m-d H:i:s',strtotime($currentTime . '+1 day'));
	echo $dailySpinTime;
	$conn->query("UPDATE users SET spinsLeft={$spinsLeft},dailySpinTime='{$dailySpinTime}' WHERE username = '{$_SESSION['username']}';");
	echo mysqli_error($conn);
	$_SESSION['alert'] = 'Daily spins added!';
	$_SESSION['alert-type'] = 'success';
	echo '<script>window.location = "play.php";</script>';
} else {
	$_SESSION['alert'] = 'Daily spins not available!';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "play.php";</script>';
}
?>