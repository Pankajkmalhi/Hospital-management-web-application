<?php
// Connect to the database
require_once "dbconnect.php";

// Get the form data
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

// Validate the form data
if (empty($name) || empty($email) || empty($message)) {
echo "Please fill out all fields.";
exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
echo "Invalid email format.";
exit();
}

// Insert the form data into the database
$sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
$result = mysqli_query($conn, $sql);

if ($result) {
echo "Message sent successfully.";
} else {
echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
