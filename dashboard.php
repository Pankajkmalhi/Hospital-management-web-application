<?php
// Start the session
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
header("Location: login.php");
exit();
}

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

// Get the user's name from the session variable
$user_name = $_SESSION["user_name"];

// Get the user's information from the database
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$user_email = $row["email"];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
<h1>Welcome, <?php echo $user_name; ?>!</h1>
<nav>
<ul>
<li><a href="#">Home</a></li>
<li><a href="#">Profile</a></li>
<li><a href="#">Settings</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</nav>
</header>
<main>
<section>
<h2>Dashboard</h2>
<p>Your email address is <?php echo $user_email; ?>.</p>
</section>
</main>
<footer>
<p>&copy; . All rights reserved.</p>
</footer>
</body>
</html>
