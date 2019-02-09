<?php
require_once('connection.php');
session_start();
$beers = mysqli_fetch_row($conn->query("SELECT beers FROM users WHERE username = '{$_SESSION['username']}'"))[0];
$beers += 10;
$conn->query("UPDATE users SET beers={$beers} WHERE username = '{$_SESSION['username']}'");
?>