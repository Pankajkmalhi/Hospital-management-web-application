<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the doctor ID from the form
$doctor_id = $_POST["doctor_id"];

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Delete the doctor from the database
$sql = "DELETE FROM doctors WHERE id='$doctor_id'";

if (mysqli_query($conn, $sql)) {
echo "Doctor deleted successfully.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
}
?>
