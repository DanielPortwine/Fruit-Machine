<?php
require_once('connection.php');
session_start();
// fetch number of spins left
$data = mysqli_fetch_row($conn->query("SELECT spinsLeft,beers,beerSpinsLeft FROM users WHERE username = '{$_SESSION['username']}'"));
$spinsLeft = $data[0];
$beers = $data[1];
$beerSpinsLeft = $data[2];
if ($_POST['type'] == 'spin') {
    echo $spinsLeft . ',' . $beerSpinsLeft;
} else if ($_POST['type'] == 'beer') {
    echo $beers;
}
?>