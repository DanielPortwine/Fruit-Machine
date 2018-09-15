<?php
require_once('header.php');
unset($_SESSION['username']);
$_SESSION['alert'] = 'Logged out';
$_SESSION['alert-type'] = 'success';
echo '<script>window.location = "index.php";</script>';
?>