<?php
require_once('connection.php');
session_start();

// fetch the complete record for the logged in user
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
$dailySpinTime = date($userData[8]);
$spinsLeft = $userData[7];
$currentTime = date('Y-m-d H:i:s');

// if the time that the user can collect bonus spins is less than the current time give their bonus spins and set next time to current + 6 hours
if ($dailySpinTime < $currentTime){
	$spinsLeft += 20;
	$dailySpinTime = date('Y-m-d H:i:s',strtotime($currentTime . '+6 hours'));
	$conn->query("UPDATE users SET spinsLeft={$spinsLeft},dailySpinTime='{$dailySpinTime}' WHERE username = '{$_SESSION['username']}';");
	echo 'Spins added!';
} else {
	echo 'Bonus spins not available!';
}