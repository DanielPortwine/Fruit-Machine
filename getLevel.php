<?php
require_once('connection.php');
session_start();
$level = mysqli_fetch_row($conn->query("SELECT xpLevel FROM users WHERE username = '{$_SESSION['username']}';"))[0];
echo $level;
?>