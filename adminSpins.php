<?php
require_once('connection.php');
session_start();

$spins = mysqli_fetch_row($conn->query("SELECT spinsLeft FROM users WHERE username = '{$_SESSION['username']}'"))[0];
$spins += 20;
$conn->query("UPDATE users SET spinsLeft={$spins} WHERE username = '{$_SESSION['username']}'");