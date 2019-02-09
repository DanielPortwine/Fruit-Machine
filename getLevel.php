<?php
require_once('connection.php');
session_start();
// fetch the user's current level
$level = mysqli_fetch_row($conn->query("SELECT xpLevel FROM users WHERE username = '{$_SESSION['username']}';"))[0];
echo $level;
?>