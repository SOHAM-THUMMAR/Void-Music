<?php
session_start();
require_once 'includes/config.php';

if (isset($_POST['playlist_id']) && is_numeric($_POST['playlist_id'])) {
    $playlist_id = $_POST['playlist_id'];

    $sql = "
        SELECT ps.song_id, s.title, s.artist, s.cover_image, s.file_path
        FROM playlist_songs ps
        JOIN songs s ON ps.song_id = s.id
        WHERE ps.playlist_id = ?
    ";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param('i', $playlist_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }

        echo json_encode(['status' => 'success', 'songs' => $songs]);
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL query.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid playlist ID.']);
}
?>
