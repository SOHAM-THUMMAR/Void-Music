<?php
include('includes/config.php');

if (isset($_GET['artist'])) {
    $artist = $_GET['artist'];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT song_name, file_path, song_cover, artist_name FROM artist_songs WHERE artist_name = ? AND status = 'approved'";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $artist);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($song = $result->fetch_assoc()) {
            $title = htmlspecialchars($song['song_name']);
            $cover = htmlspecialchars($song['song_cover']);
            $src = htmlspecialchars($song['file_path']);
            $artistName = htmlspecialchars($song['artist_name']);

            echo '
                <div class="song-item play-song"
                    data-title="' . $title . '"
                    data-artist="' . $artistName . '"
                    data-cover="' . $cover . '"
                    data-src="' . $src . '">
                    <img src="' . $cover . '" alt="Song cover">
                    <div class="song-info">
                        <h5>' . $title . '</h5>
                        <span>' . $artistName . '</span>
                    </div>
                </div>
            ';
        }
    } else {
        echo '<p style="color:#fff;">No songs found for this artist.</p>';
    }
} else {
    echo '<p style="color:#fff;">No artist selected.</p>';
}
?>
