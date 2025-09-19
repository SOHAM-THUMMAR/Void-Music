<?php
session_start();
require "includes/config.php";

if (!isset($_SESSION['email'])) {
    die("User not logged in");
}

$email = $_SESSION['email'];

// Get user ID
$query = $con->prepare("SELECT id FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Fetch user's playlists
$playlists = [];
$playlist_query = $con->prepare("SELECT id, name FROM playlists WHERE user_id = ?");
$playlist_query->bind_param("i", $user_id);
$playlist_query->execute();
$playlist_result = $playlist_query->get_result();

while ($row = $playlist_result->fetch_assoc()) {
    $playlists[] = $row;
}

// Fetch approved songs from both tables
$songs = [];

// From `songs` table
$song_query = $con->query("SELECT id, title, artist, cover_image, file_path FROM songs WHERE status = 'approved'");
while ($row = $song_query->fetch_assoc()) {
    $songs[] = [
        'id' => $row,
        'source' => 'songs'
    ];
}

// From `artist_songs` table
// $artist_query = $con->query("SELECT id, song_name AS title, artist_name AS artist, song_cover AS cover_image, file_path FROM artist_songs WHERE status = 'approved'");
//   while ($row = $artist_query->fetch_assoc()) {
//     $songs[] = [
//         'id' => $row,
//         'source' => 'artist_songs'
//     ];
// }
// ?>

<html>
<head>
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    /* same styles as in your example */
    body {
      background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
      color: #fff;
      font-family: 'Inter', sans-serif;
    }
    .song-item {
  display: flex;
  align-items: center;
  padding: 10px 0;
  border-bottom: 1px solid #444;
  position: relative;
  gap: 10px;
}

.playlist-btn-wrapper {
  margin-left: auto;
}

    .song-item {
      display: flex;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid #444;
    }
    .song-item img {
      width: 40px;
      height: 40px;
      border-radius: 5px;
      margin-right: 10px;
    }
    .song-info h5 {
      margin: 0;
      font-size: 16px;
      color: #fff;
    }
    .song-info span {
      font-size: 12px;
      color: gray;
    }
    .container{
      margin-bottom: 100px;
    }
  </style>
</head>
<body style="margin-left: 15%;">
  <?php include 'includes/sidebar2.php'; ?>
  <div class="container mt-5">
    <h3>All Approved Songs</h3>
   <?php if (!empty($songs)): ?>
  <?php foreach ($songs as $song): ?>
    <div class="song-item play-song"
         data-title="<?php echo htmlspecialchars($song['id']['title']); ?>"
         data-artist="<?php echo htmlspecialchars($song['id']['artist']); ?>"
         data-cover="<?php echo htmlspecialchars($song['id']['cover_image']); ?>"
         data-src="<?php echo htmlspecialchars($song['id']['file_path']); ?>">

        <img src="<?php echo htmlspecialchars($song['id']['cover_image']); ?>" alt="Cover">

        <div class="song-info">
            <h5><?php echo htmlspecialchars($song['id']['title']); ?></h5>
            <span><?php echo htmlspecialchars($song['id']['artist']); ?> (<?php echo $song['source']; ?>)</span>
        </div>

        <!-- Plus button wrapper -->
        <div class="playlist-btn-wrapper" onclick="event.stopPropagation();">
            <button class="btn btn-outline-light btn-sm ms-auto add-to-playlist-btn"
        data-song-id="<?php echo $song['id']['id']; ?>"
        data-song-type="<?php echo $song['source']; ?>">
  <i class="fas fa-plus"></i>
</button>

        </div>

    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No approved songs found.</p>
<?php endif; ?>

  
  <!-- Modal to create a playlist or add to an existing one -->
<div class="modal fade" id="playlistModal" tabindex="-1" aria-labelledby="playlistModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="playlistModalLabel">Add to Playlist</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="modal-song-id">
        <input type="hidden" id="modal-song-table">

        <div class="mb-3">
          <label for="existingPlaylists" class="form-label">Select Playlist</label>
          <select id="existingPlaylists" class="form-select">
  <option value="">-- Select a playlist --</option>
  <?php foreach ($playlists as $playlist): ?>
    <option value="<?php echo $playlist['id']; ?>">
      <?php echo htmlspecialchars($playlist['name']); ?>
    </option>
  <?php endforeach; ?>
</select>

        </div>
        <div class="mb-3">
          <label for="newPlaylistName" class="form-label">Or Create New Playlist</label>
          <input type="text" class="form-control" id="newPlaylistName" placeholder="New playlist name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="savePlaylistButton">Save</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const addToPlaylistButtons = document.querySelectorAll(".add-to-playlist-btn");

  const modalSongIdInput = document.getElementById("modal-song-id");
  const modalSongTableInput = document.getElementById("modal-song-table");
  const playlistModal = new bootstrap.Modal(document.getElementById("playlistModal"));
  const existingPlaylistsSelect = document.getElementById("existingPlaylists");
  const newPlaylistNameInput = document.getElementById("newPlaylistName");

  addToPlaylistButtons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.stopPropagation(); // Prevent parent song click event
      const songId = this.getAttribute("data-song-id");
      const songTable = this.getAttribute("data-song-type");

      modalSongIdInput.value = songId;
      modalSongTableInput.value = songTable;

      // Clear previous selection and input when the modal is opened
      existingPlaylistsSelect.selectedIndex = -1; // Reset dropdown
      newPlaylistNameInput.value = ''; // Clear the new playlist input

      playlistModal.show();
    }, { once: false }); // Don't set this to true unless you only want one-time click
  });

  document.getElementById("savePlaylistButton").addEventListener("click", function () {
    const songId = modalSongIdInput.value;
    const songTable = modalSongTableInput.value;
    const playlistId = document.getElementById("existingPlaylists").value;
    const newPlaylistName = document.getElementById("newPlaylistName").value;

    const formData = new FormData();
    formData.append("song_id", songId);
    formData.append("song_table", songTable);
    if (newPlaylistName) {
      formData.append("new_playlist_name", newPlaylistName);
    } else {
      formData.append("playlist_id", playlistId);
    }

    fetch("add_to_playlist.php", {
      method: "POST",
      body: formData
    })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        alert("✅ " + data.message);

        // If a new playlist is created, add it to the dropdown dynamically
        if (data.new_playlist) {
          const newOption = document.createElement("option");
          newOption.value = data.new_playlist.id;
          newOption.textContent = data.new_playlist.name;
          existingPlaylistsSelect.appendChild(newOption);

          // Optionally, select the newly added playlist
          existingPlaylistsSelect.value = data.new_playlist.id;
        }
      } else {
        alert("❌ " + data.message);
      }
      playlistModal.hide();
    })
    .catch((err) => {
      alert("❌ Already added to this playlist.");
      playlistModal.hide();
    });
  });
});

</script>

  <?php include 'includes/music-player2.php'; ?>
</body>

</html>
