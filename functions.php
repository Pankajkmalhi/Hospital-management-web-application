<?php
// Start the session
session_start();

// Connect to the database
require_once "dbconnect.php";

// Function to validate a name
function validate_name($name) {
if (preg_match("/^[a-zA-Z ]*$/", $name)) {
return true;
} else {
return false;
}
}

// Function to validate an address
function validate_address($address) {
if (preg_match("/^[a-zA-Z0-9\s,'-]*$/", $address)) {
return true;
} else {
return false;
}
}

// Function to validate a phone number
function validate_phone($phone) {
if (preg_match("/^[0-9]{10}$/", $phone)) {
return true;
} else {
return false;
}
}

// Function to validate an email-id
function validate_email($email) {
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
return true;
} else {
return false;
}
}

// Function to authenticate a user
// Function to authenticate a user
function authenticate_user($email, $password, $conn) {
    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row["password"];
    
    // Verify the password
    if (password_verify($password, $hashed_password)) {
    // Set the session variables
    $_SESSION["user_id"] = $row["id"];
    $_SESSION["user_name"] = $row["name"];
    
    return true;
    } else {
    return false;
    }
    } else {
    return false;
    }
    }
    

// Function to check if a user is logged in
function is_logged_in() {
if (isset($_SESSION["user_id"])) {
return true;
} else {
return false;
}
}

// Function to logout a user
function logout_user() {
// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
}
?>
