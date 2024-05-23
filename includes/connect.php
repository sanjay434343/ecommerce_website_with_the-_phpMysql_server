<?php
$con = mysqli_connect('localhost', 'root', '', 'mystore');

// Check if the connection was successful
if (!$con) {
    die(mysqli_connect_error());
}

// Rest of your code...
?>
