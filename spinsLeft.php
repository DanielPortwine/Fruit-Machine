<?php
require_once('connection.php');
session_start();
echo mysqli_fetch_row($conn->query("SELECT spinsLeft FROM users WHERE username = '{$_SESSION['username']}'"))[0] - 1;
?>