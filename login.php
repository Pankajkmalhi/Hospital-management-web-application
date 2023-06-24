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

// Check if the form was submitted to login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
// Get the login details from the form
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];

// Check if the user exists in the database
$sql = "SELECT * FROM users WHERE email='$user_email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
$row = mysqli_fetch_assoc($result);
$hashed_password = $row["password"];

// Verify the password
if (password_verify($user_password, $hashed_password)) {
// Set the session variables
$_SESSION["user_id"] = $row["id"];
$_SESSION["user_name"] = $row["name"];

// Redirect to the dashboard
header("Location: dashboard.php");
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
<title>Login</title>

<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
<h1>Login</h1>
</header>
<main>
<section>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="user_email">Email:</label>
<input type="email" id="user_email" name="user_email" required>
<label for="user_password">Password:</label>
<input type="password" id="user_password" name="user_password" required>
<button type="submit" name="login">Login</button>

</form>
</section>
<section>
<p>Don't have an account? <a href="register.php">Register here</a>.</p>
<li><a href="index.html">Home</a></li>
</section>
</main>
<footer>
<p>&copy;  All rights reserved.</p>
</footer>
</body>
</html>
