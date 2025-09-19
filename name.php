<?php 
session_start();
require "includes/config.php";

// Check if the session email is set
if (!isset($_SESSION['email'])) {
    die("User not logged in");
}

$query = $con->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param('s', $_SESSION['email']);
$query->execute();
$result = $query->get_result();

if ($row = $result->fetch_assoc()) {
    // echo $row['name']; // Assuming the column name is 'name'
} else {
    // echo "User not found";
}

// Close the statement and connection (optional but recommended)
$query->close();
$con->close();
?>
