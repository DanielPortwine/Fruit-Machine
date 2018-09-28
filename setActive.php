<?php
require_once('connection.php'):
session_start();
$currentTime = date('Y-m-d H:i:s');
$time = date('Y-m-d H:i:s',strtotime($currentTime . '+1 minute'));
$conn->query("UPDATE users SET active={$time}");
?>