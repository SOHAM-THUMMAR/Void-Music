<?php
session_start();
require 'includes/config.php';

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_email = $_SESSION['email'];

// Get user ID
$query = $con->prepare("SELECT id FROM users WHERE email = ?");
$query->bind_param("s", $user_email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Fetch playlists for the logged-in user
$query = $con->prepare("SELECT id, name FROM playlists WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$playlists = [];
while ($row = $result->fetch_assoc()) {
    $playlists[] = $row;
}

echo json_encode(['playlists' => $playlists]);
?>
