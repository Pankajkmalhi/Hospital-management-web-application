<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mydatabase';
// Start the session
session_start();

// Check if the user is logged in as a doctor
if (!isset($_SESSION["doctor_id"])) {
header("Location: login.php");
exit();
}

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Get the doctor's details from the database
$doctor_id = $_SESSION["doctor_id"];
$sql = "SELECT * FROM doctors WHERE id='$doctor_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
$row = mysqli_fetch_assoc($result);
$doctor_name = $row["name"];
$doctor_specialist = $row["specialist"];
$doctor_city = $row["city"];
$doctor_availability = $row["availability"];
} else {
die("Error: Doctor not found.");
}

// Check if the form was submitted to update the doctor's details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_details"])) {
// Get the updated details from the form
$doctor_name = $_POST["doctor_name"];
$doctor_specialist = $_POST["doctor_specialist"];
$doctor_city = $_POST["doctor_city"];

// Update the doctor's details in the database
$sql = "UPDATE doctors SET name='$doctor_name', specialist='$doctor_specialist', city='$doctor_city' WHERE id='$doctor_id'";

if (mysqli_query($conn, $sql)) {
echo "<script>alert('Doctor details updated successfully.');</script>";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

// Check if the form was submitted to update the doctor's availability
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_availability"])) {
// Get the updated availability from the form
$doctor_availability = $_POST["doctor_availability"];

// Update the doctor's availability in the database
$sql = "UPDATE doctors SET availability='$doctor_availability' WHERE id='$doctor_id'";

if (mysqli_query($conn, $sql)) {
echo "<script>alert('Doctor availability updated successfully.');</script>";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

// Get the doctor's appointments from the database
$sql = "SELECT * FROM appointments WHERE doctor_id='$doctor_id'";
$result = mysqli_query($conn, $sql);
$appointments = array();

if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
$appointment_date = $row["date"];
$appointment_time = $row["time"];
$appointment_patient = $row["patient_name"];
$appointment_city = $row["city"];
$appointment_details = array($appointment_date, $appointment_time, $appointment_patient, $appointment_city);
array_push($appointments, $appointment_details);
}
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<title>Doctor Dashboard</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
<h1>Welcome, <?php echo $doctor_name; ?>!</h1>
<nav>
<ul>
<li><a href="logout.php">Logout</a></li>
<li><a href="index.html">Home</a></li>
</ul>
</nav>
</header>
<main>
<section>
<h2>Profile Details</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="doctor_name">Name:</label>
<input type="text" id="doctor_name" name="doctor_name" value="<?php echo $doctor_name; ?>" required>
<label for="doctor_specialist">Specialist:</label>
<input type="text" id="doctor_specialist" name="doctor_specialist" value="<?php echo $doctor_specialist; ?>" required>
<label for="doctor_city">City:</label>
<select id="doctor_city" name="doctor_city" required>
<option value="">Select a city</option>
<option value="New York" <?php if ($doctor_city == "New York") echo "selected"; ?>>New York</option>
<option value="Los Angeles" <?php if ($doctor_city == "Los Angeles") echo "selected"; ?>>Los Angeles</option>
<option value="Chicago" <?php if ($doctor_city == "Chicago") echo "selected"; ?>>Chicago</option>
</select>
<button type="submit" name="update_details">Update Details</button>
</form>
</section>
<section>
<h2>Availability</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="doctor_availability">Availability:</label>
<select id="doctor_availability" name="doctor_availability" required>
<option value="">Select availability</option>
<option value="day" <?php if ($doctor_availability == "day") echo "selected"; ?>>Day</option>
<option value="week" <?php if ($doctor_availability == "week") echo "selected"; ?>>Week</option>
<option value="month" <?php if ($doctor_availability == "month") echo "selected"; ?>>Month</option>
</select>
<button type="submit" name="update_availability">Update Availability</button>
</form>
</section>
<section>
<h2>Appointments</h2>
<?php if (count($appointments) > 0): ?>
<table>
<thead>
<tr>
<th>Date</th>
<th>Time</th>
<th>Patient Name</th>
<th>City</th>
</tr>
</thead>
<tbody>
<?php foreach ($appointments as $appointment): ?>
<tr>
<td><?php echo $appointment[0]; ?></td>
<td><?php echo $appointment[1]; ?></td>
<td><?php echo $appointment[2]; ?></td>
<td><?php echo $appointment[3]; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p>No appointments found.</p>
<?php endif; ?>
</section>
</main>
<footer>
<p>&copy; . All rights reserved.</p>
</footer>
</body>
</html>
