<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Start the session
session_start();

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted to register a new patient
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
// Get the patient details from the form
$patient_name = $_POST["patient_name"];
$patient_email = $_POST["patient_email"];
$patient_password = $_POST["patient_password"];

// Hash the password
$hashed_password = password_hash($patient_password, PASSWORD_DEFAULT);

// Insert the patient into the database
$sql = "INSERT INTO patients (name, email, password) VALUES ('$patient_name', '$patient_email', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
echo "<script>alert('Patient registered successfully.');</script>";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

// Check if the form was submitted to login as a patient
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
// Get the login details from the form
$patient_email = $_POST["patient_email"];
$patient_password = $_POST["patient_password"];

// Check if the patient exists in the database
$sql = "SELECT * FROM patients WHERE email='$patient_email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
$row = mysqli_fetch_assoc($result);
$hashed_password = $row["password"];

// Verify the password
if (password_verify($patient_password, $hashed_password)) {
// Set the session variables
$_SESSION["patient_id"] = $row["id"];
$_SESSION["patient_name"] = $row["name"];

// Redirect to the search page
header("Location: search.php");
exit();
} else {
echo "<script>alert('Invalid email or password.');</script>";
}
} else {
echo "<script>alert('Invalid email or password.');</script>";
}
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<title>Medical Services</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
<h1>Medical Services</h1>
<nav>
<ul>
<li><a href="register.php">Register</a></li>
<li><a href="login.php">Login</a></li>
<li><a href="index.html">Home</a></li>
</ul>
</nav>
</header>
<main>
<section id="register">
<h2>Register</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="patient_name">Name:</label>
<input type="text" id="patient_name" name="patient_name" required>
<label for="patient_email">Email:</label>
<input type="email" id="patient_email" name="patient_email" required>
<label for="patient_password">Password:</label>
<input type="password" id="patient_password" name="patient_password" required>
<button type="submit" name="register">Register</button>
</form>
</section>
<section id="login">
<h2>Login</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="patient_email">Email:</label>
<input type="email" id="patient_email" name="patient_email" required>
<label for="patient_password">Password:</label>
<input type="password" id="patient_password" name="patient_password" required>
<button type="submit" name="login">Login</button>
</form>
</section>
</main>
<footer>
<p>&copy;  All rights reserved.</p>
</footer>
</body>
</html>
