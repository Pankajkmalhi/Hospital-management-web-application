<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the doctor details from the form
$doctor_name = $_POST["doctor_name"];
$doctor_specialist = $_POST["doctor_specialist"];
$doctor_city = $_POST["doctor_city"];

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Insert the doctor into the database
$sql = "INSERT INTO doctors (name, specialist, city) VALUES ('$doctor_name', '$doctor_specialist', '$doctor_city')";

if (mysqli_query($conn, $sql)) {
echo "Doctor added successfully.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
}
?>
