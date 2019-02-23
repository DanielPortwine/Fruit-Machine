<?php
require_once('header.php');

// log user out
unset($_SESSION['username']);
unset($_SESSION['userID']);

// alert that it was successful
$_SESSION['alert'] = 'Logged out';
$_SESSION['alert-type'] = 'success';

// redirect to login page
header('Location: index');