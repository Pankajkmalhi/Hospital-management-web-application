<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the city name from the form
$city_name = $_POST["city_name"];

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Delete the city from the database
$sql = "DELETE FROM cities WHERE name='$city_name'";

if (mysqli_query($conn, $sql)) {
echo "City deleted successfully.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
}
?>
