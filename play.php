<?php
require_once('header.php');
$_SESSION['page'] = 'play';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
?>