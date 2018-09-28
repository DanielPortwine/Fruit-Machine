<?php
require_once('connection.php');
session_start();
$userData = mysqli_fetch_row($conn->query("SELECT beers,beerSpinsLeft,beersUsed FROM users WHERE username = '{$_SESSION['username']}'"));
$beers = $userData[0];
$beerSpinsLeft = $userData[1];
$beersUsed = $userData[2];
if ($beers > 0){
	$beers--;
	$beersUsed++;
	$beerSpinsLeft += 2;
	$conn->query("UPDATE users SET beers={$beers},beerSpinsLeft={$beerSpinsLeft},beersUsed={$beersUsed} WHERE username = '{$_SESSION['username']}'");
}
?>