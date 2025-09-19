<?php
session_start();
require "includes/config.php";

header('Content-Type: application/json'); // Ensure JSON response

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$song_id = isset($_POST['song_id']) ? (int)$_POST['song_id'] : 0;
if ($song_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid song ID']);
    exit;
}

$user_email = $_SESSION['email'];

// Get user ID
$userQuery = $con->prepare("SELECT id FROM users WHERE email = ?");
$userQuery->bind_param('s', $user_email);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();
$user_id = $userData['id'];

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

// Check if song is already liked
$checkQuery = $con->prepare("SELECT * FROM likes WHERE user_id = ? AND song_id = ?");
$checkQuery->bind_param('ii', $user_id, $song_id);
$checkQuery->execute();
$checkResult = $checkQuery->get_result();

if ($checkResult->num_rows > 0) {
    // Unlike the song
    $deleteQuery = $con->prepare("DELETE FROM likes WHERE user_id = ? AND song_id = ?");
    $deleteQuery->bind_param('ii', $user_id, $song_id);
    $deleteQuery->execute();
    echo json_encode(['status' => 'unliked']);
} else {
    // Like the song
    $insertQuery = $con->prepare("INSERT INTO likes (user_id, song_id, song_type) VALUES (?, ?, 'song')");
    $insertQuery->bind_param('ii', $user_id, $song_id);
    $insertQuery->execute();
    echo json_encode(['status' => 'liked']);
}

$checkQuery->close();
$userQuery->close();
$con->close();
?>
