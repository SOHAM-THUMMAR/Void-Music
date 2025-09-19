<?php
session_start();
require "includes/config.php";

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$email = $_SESSION['email'];

// Get user ID
$query = $con->prepare("SELECT id FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$userResult = $query->get_result();
$user = $userResult->fetch_assoc();
$user_id = $user['id'];

// Validate input
$song_id = $_POST['song_id'] ?? null;
$song_table = $_POST['song_table'] ?? null;
$playlist_id = $_POST['playlist_id'] ?? null;
$new_playlist_name = $_POST['new_playlist_name'] ?? null;

if (!$song_id || !$song_table) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid song data']);
    exit;
}

// Create playlist if new
if ($new_playlist_name) {
    $stmt = $con->prepare("INSERT INTO playlists (user_id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $new_playlist_name);
    if ($stmt->execute()) {
        $playlist_id = $stmt->insert_id;

        // Return the new playlist's ID and name to update the dropdown
        echo json_encode([
            'status' => 'success',
            'message' => 'Playlist created and song added',
            'new_playlist' => [
                'id' => $playlist_id,
                'name' => $new_playlist_name
            ]
        ]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create playlist']);
        exit;
    }
}

// Final validation
if (!$playlist_id) {
    echo json_encode(['status' => 'error', 'message' => 'Playlist ID not found']);
    exit;
}

// Add song to playlist
$stmt = $con->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)");
$stmt->bind_param("ii", $playlist_id, $song_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Song added to playlist']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add song to playlist']);
}
?>
