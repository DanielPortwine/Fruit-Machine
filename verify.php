<?php
require_once('header.php');

$result = $conn->query("SELECT verified, salt FROM users WHERE username = {$_SESSION['username']}")->fetch_array(MYSQLI_ASSOC);
if ($result['salt'] == $_GET['unique'] && $_SESION['user'] == $_GET['user']) {
    $conn->query("UPDATE users SET verified = 1");
    echo 'Verified!';
}