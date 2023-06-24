<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the username and password from the form
$username = $_POST["username"];
$password = $_POST["password"];

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the user into the database
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
echo "User created successfully.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
}
?>
