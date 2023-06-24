<?php
// Start the session
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
session_start();

// Check if the user is already logged in
if (isset($_SESSION["user_id"])) {
header("Location: dashboard.php");
exit();
}

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted to register
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
// Get the user details from the form
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];

// Hash the password
$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

// Insert the user into the database
$sql = "INSERT INTO users (name, email, password) VALUES ('$user_name', '$user_email', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
echo "<script>alert('User registered successfully.');</script>";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
<h1>Register</h1>
</header>
<main>
<section>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="user_name">Name:</label>
<input type="text" id="user_name" name="user_name" required>
<label for="user_email">Email:</label>
<input type="email" id="user_email" name="user_email" required>
<label for="user_password">Password:</label>
<input type="password" id="user_password" name="user_password" required>
<button type="submit" name="register">Register</button>
</form>
</section>
<section>
<p>Already have an account? <a href="login.php">Login here</a>.</p>
<li><a href="index.html">Home</a></li>
</section>
</main>
<footer>
<p>&copy;  All rights reserved.</p>
</footer>
</body>
</html>
