<?php
// establish connection to database
$conn = new mysqli('localhost:3307','root','','fruitmachine');
// output error if not connected
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>