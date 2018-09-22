<?php
$conn = new mysqli('localhost:3307','root','','fruitmachine');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>