<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);
// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
?>
