<?php
require_once('connection.php');
session_start();
$lastTime = strtotime(mysqli_fetch_row($conn->query("SELECT dailySpinTime FROM users WHERE username = '{$_SESSION['username']}';"))[0]) * 1000;
echo $lastTime;
?>