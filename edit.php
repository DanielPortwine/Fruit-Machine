<?php
require_once('header.php');
$_SESSION['page'] = 'edit';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
?>