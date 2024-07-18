<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'newsportal';

// Create connection
$con = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
?>
