<?php 
session_start();
require "includes/config.php";

// Check if the session email is set
if (!isset($_SESSION['email'])) {
    die("User not logged in");
}

$email = $_SESSION['email'];
// Fetch liked song IDs for this user
$likedSongs = [];
$getUserId = $con->prepare("SELECT id FROM users WHERE email = ?");
$getUserId->bind_param('s', $email);
$getUserId->execute();
$userResult = $getUserId->get_result();
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $userId = $userData['id'];

    $likedQuery = $con->prepare("SELECT song_id FROM likes WHERE user_id = ?");
    $likedQuery->bind_param('i', $userId);
    $likedQuery->execute();
    $likedResult = $likedQuery->get_result();
    while ($likeRow = $likedResult->fetch_assoc()) {
        $likedSongs[] = (int)$likeRow['song_id'];
    }
}


// Fetch user info
$query = $con->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param('s', $email);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();
$name = $row['name'];
$pro_pic = $row['profile_pic'];


// Fetch songs uploaded by user
$song_query = $con->prepare("SELECT * FROM songs WHERE uploaded_by = ?  and status = 'approved' ORDER BY id DESC LIMIT 5");
$song_query->bind_param('s', $email);
$song_query->execute();
$song_result = $song_query->get_result();

// Fetch playlists uploaded by user
$playlist_query = $con->prepare("SELECT * FROM playlists WHERE user_id = ? ORDER BY id DESC");
$playlist_query->bind_param('i', $userId);
$playlist_query->execute();
$playlist_result = $playlist_query->get_result();
?>
<html>
<head>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Your existing CSS */
        .song-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #aaa;
            font-size: 20px;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 50%;
            outline: none;
            z-index: 100;
            position: relative;
        }

        .like-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .like-btn:active {
            transform: scale(0.95);
        }

        .like-btn .fa-heart {
            color: #aaa;
            transition: color 0.3s ease;
        }

        .like-btn.liked .fa-heart {
            color: #DC143C;
            animation: pop 0.3s ease;
        }

        @keyframes pop {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }

        /* Sidebar styles */
        .sidebar {
            background-color: #1a1a1a;
            width: 250px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            overflow-y: auto;
        }

        /* Main content wrapper */
        .main-content {
            margin-left: 250px; /* Match sidebar width */
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        /* Mobile adjustments */
        @media (max-width: 767px) {
            .sidebar {
                width: 80px;
            }
            
            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
            }
        }

        .profile-header {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to bottom, #3a3a3a, #000);
        }

        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header h1 {
            margin-top: 10px;
            font-size: 24px;
        }

        .profile-header .btn {
            background-color: #3a3a3a;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
            border-bottom: 1px solid #3a3a3a;
        }

        .stats div {
            text-align: center;
        }

        .stats div span {
            display: block;
            font-size: 18px;
            font-weight: bold;
        }

        .playlist-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #3a3a3a;
            cursor: pointer;
        }

        .playlist-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #888;
            color: #fff;
            font-size: 24px;
        }

        .playlist-item .playlist-info {
            flex-grow: 1;
        }

        .playlist-item .playlist-info h5 {
            margin: 0;
            font-size: 16px;
        }

        .playlist-item .playlist-info span {
            font-size: 14px;
            color: #aaa;
        }

        .see-all {
            text-align: center;
            padding: 20px 0;
        }

        .see-all a {
            color: #fff;
            text-decoration: none;
        }

        .recent-creations, .upload-more {
            padding: 20px 0;
        }

        .recent-creations h4, .upload-more h4 {
            margin-bottom: 20px;
        }

        .song-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #3a3a3a;
        }

        .song-item img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            margin-right: 10px;
            object-fit: cover;
        }

        .song-item .song-info {
            flex-grow: 1;
        }

        .song-item .song-info h5 {
            margin: 0;
            font-size: 16px;
        }

        .song-item .song-info span {
            font-size: 14px;
            color: #aaa;
        }

        .upload-more .btn {
            background-color: #3a3a3a;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
        }

        /* Container adjustments */
        .container {
            padding-left: 15px;
            padding-right: 15px;
            max-width: 100%;
        }
        .song-wrapper {
            width: 100%;
        }

        .song-item_play-song {
            display: flex;         /* So content like image + text sits side-by-side */
            align-items: center;
            width: 100%;           /* Full line */
            padding: 10px;
            box-sizing: border-box;
            border-bottom: 1px solid #ccc; /* optional separator */
        }

        /* Responsive text adjustments for mobile */
        @media (max-width: 767px) {
            .profile-header h1 {
                font-size: 20px;
            }

            .stats div span {
                font-size: 16px;
            }

            .playlist-item .playlist-info h5 {
                font-size: 14px;
            }

            .song-item .song-info h5 {
                font-size: 14px;
            }
        }
        .play-song {
            cursor: pointer;
        }
        .play-song:hover {
            background-color: #2c2c2c;
        }
        .playlist_initial{
            margin: 5px;
            background: white;
            padding: 15px;
            border-radius: 7px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            font-weight: bolder;
            font-size: x-large;
            color: #800020;
            background-color: #202020;
        }
        .playlist_initial{
            margin: 7px;

        }
    </style>

</head>
<body style="margin-bottom: 90px;">
    <!-- Sidebar -->
    <nav class="sidebar">
        <?php include 'includes/sidebar2.php'; ?>
    </nav>

    <!-- Main content -->
    <main class="main-content">
        <div class="profile-header">
            <img alt="Profile picture of Kai" src="uploads/<?php echo $pro_pic;?>"/>
            <h1><?php echo $name; ?></h1>
            <a href="edit_profile.php" class="btn">EDIT PROFILE</a>
        </div>

        <!-- <div class="stats">
            <div>
                <span>10</span>
                PLAYLISTS
            </div>
            <div>
                <span>2</span>
                FOLLOWERS
            </div>
            <div>
                <span>34</span>
                FOLLOWING
            </div>
        </div> -->

        <div class="container">
            <h4 class="mt-4">Public playlists</h4>
            <?php if ($playlist_result->num_rows > 0): ?>
                <?php while ($playlist = $playlist_result->fetch_assoc()): ?>
                    <div class="playlist-item" onclick="showPlaylistSongs(<?php echo $playlist['id']; ?>, this)">
    <div class="playlist-cover">
        <span class="playlist_initial"><?php echo strtoupper(substr($playlist['name'], 0, 1)); ?></span>
    </div>
    <div class="playlist-info">
        <h5><?php echo htmlspecialchars($playlist['name']); ?></h5>
        <!-- <span>0 likes</span> -->
    </div>
    <i class="fas fa-chevron-right"></i>
</div>

<!-- Placeholder for songs (hidden initially) -->
<div class="playlist-songs-container" id="playlist-songs-container-<?php echo $playlist['id']; ?>" style="display: none;"></div>

                <?php endwhile; ?>
            <?php else: ?>
                <p>No playlists available.</p>
            <?php endif; ?>
        </div>

        <div class="container recent-creations">
            <h4>Recent Creations</h4>
            <?php if ($song_result->num_rows > 0): ?>
                <?php while ($song = $song_result->fetch_assoc()): ?>
                <div class="song-wrapper">
                    <div class="song-item play-song" 
                         data-title="<?php echo htmlspecialchars($song['title']); ?>" 
                         data-artist="<?php echo htmlspecialchars($song['artist']); ?>" 
                         data-cover="<?php echo htmlspecialchars($song['cover_image']); ?>" 
                         data-src="<?php echo htmlspecialchars($song['file_path']); ?>">
                        <img src="<?php echo htmlspecialchars($song['cover_image']); ?>" alt="Song cover">
                        <div class="song-info">
                            <h5><?php echo htmlspecialchars($song['title']); ?></h5>
                            <span><?php echo htmlspecialchars($song['artist']); ?></span>
                        </div>
                    </div>

                    <button class="like-btn <?php echo in_array((int)$song['id'], $likedSongs, true) ? 'liked' : ''; ?>"
                            data-song-id="<?php echo $song['id']; ?>" 
                            onclick="likeSong(<?php echo $song['id']; ?>, event)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No recent songs uploaded.</p>
            <?php endif; ?>
        </div>

        <div class="container upload-more">
            <h4>Upload More</h4>
            <a href="upload_song.php" class="btn">Upload</a>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script crossorigin="anonymous" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3i5d5L5hb5g7v4l5Y5b5Y5b5Y5b5" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function likeSong(songId, event) {
    if (event) {
        event.stopPropagation();
    }

    const btn = event.currentTarget;
    const heartIcon = btn.querySelector('.fa-heart');
    const isCurrentlyLiked = btn.classList.contains('liked');

    btn.classList.toggle('liked');
    heartIcon.style.color = btn.classList.contains('liked') ? '#DC143C' : '#aaa';

    fetch('like_song.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'song_id=' + songId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'liked') {
            btn.classList.add('liked');
            heartIcon.style.color = '#DC143C';
        } else if (data.status === 'unliked') {
            btn.classList.remove('liked');
            heartIcon.style.color = '#aaa';
        } else {
            btn.classList.toggle('liked', isCurrentlyLiked);
            heartIcon.style.color = isCurrentlyLiked ? '#DC143C' : '#aaa';
        }
    })
    .catch(err => {
        btn.classList.toggle('liked', isCurrentlyLiked);
        heartIcon.style.color = isCurrentlyLiked ? '#DC143C' : '#aaa';
        console.error('Error:', err);
    });
}

// Show playlist songs when a playlist is clicked
// Show playlist songs when a playlist is clicked
function showPlaylistSongs(playlistId) {
    const playlistSongsContainer = document.getElementById('playlist-songs-container-' + playlistId);

    if (playlistSongsContainer.style.display === 'block') {
        // If playlist songs are currently shown, hide them
        playlistSongsContainer.style.display = 'none';
    } else {
        // If playlist songs are hidden, show them and fetch the songs
        fetch('get_playlist_songs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'playlist_id=' + playlistId
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the response to check if it's coming correctly
            
            if (data.status === 'success') {
                if (data.songs.length === 0) {
                    playlistSongsContainer.innerHTML = '<p>No songs in this playlist.</p>';
                } else {
                    const songsHTML = data.songs.map(song => {
                        return `
                        <div class="song-wrapper">
                            <div class="song-item play-song"
                                 data-title="${escapeHtml(song.title)}"
                                 data-artist="${escapeHtml(song.artist)}"
                                 data-cover="${escapeHtml(song.cover_image || 'default_cover.jpg')}"
                                 data-src="${escapeHtml(song.file_path || '')}">
                                <img src="${song.cover_image ? escapeHtml(song.cover_image) : 'default_cover.jpg'}" alt="Song cover">
                                <div class="song-info">
                                    <h5>${escapeHtml(song.title)}</h5>
                                    <span>${escapeHtml(song.artist)}</span>
                                </div>
                            </div>
                        </div>`;
                    }).join('');
                    
                    playlistSongsContainer.innerHTML = songsHTML;

                    // Show the playlist songs container
                    playlistSongsContainer.style.display = 'block';
                }
            } else {
                console.error('Error fetching playlist songs:', data.message);
            }
        })
        .catch(err => {
            console.error('Error fetching playlist songs:', err);
        });
    }
}

// Function to escape HTML to prevent XSS
function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


</script>

    <?php include 'includes/music-player2.php'?>
</body>
</html>