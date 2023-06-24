<?php
// Check if the form was submitted
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the city name from the form
$city_name = $_POST["city_name"];

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);
// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Insert the city into the database
$sql = "INSERT INTO cities (name) VALUES ('$city_name')";

if (mysqli_query($conn, $sql)) {
echo "City added successfully.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
}
?>
