<?php
session_start();
require "includes/config.php";

if (!isset($_SESSION['email'])) {
    die("User not logged in");
}

$email = $_SESSION['email'];

// Get the user_id from the email
$query = $con->prepare("SELECT id FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Get all liked song IDs for this user
$query = $con->prepare("
    SELECT song_id FROM likes WHERE user_id = ?
");
$query->bind_param("i", $user_id);
$query->execute();
$liked_songs_result = $query->get_result();

// If there are liked songs, fetch their details from both tables
if ($liked_songs_result->num_rows > 0) {
    $liked_songs = [];
    
    while ($liked_song = $liked_songs_result->fetch_assoc()) {
        $song_id = $liked_song['song_id'];
        
        // Fetch details from the songs table
        $song_query = $con->prepare("SELECT id, title, artist, cover_image, file_path FROM songs WHERE id = ?");
        $song_query->bind_param("i", $song_id);
        $song_query->execute();
        $song_result = $song_query->get_result();

        // If song is found in songs table, add it to the list
        if ($song_result->num_rows > 0) {
            $liked_songs[] = [
                'id' => $song_result->fetch_assoc(),
                'source' => 'songs'
            ];
        }

        // Fetch details from the artist_songs table
        $artist_song_query = $con->prepare("SELECT id, song_name AS title, artist_name AS artist, song_cover AS cover_image, file_path FROM artist_songs WHERE id = ?");
        $artist_song_query->bind_param("i", $song_id);
        $artist_song_query->execute();
        $artist_song_result = $artist_song_query->get_result();

        // If song is found in artist_songs table, add it to the list
        if ($artist_song_result->num_rows > 0) {
            $liked_songs[] = [
                'id' => $artist_song_result->fetch_assoc(),
                'source' => 'artist_songs'
            ];
        }
    }
} else {
    echo "No liked songs yet.";
}
?>

<html>
 <head>
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   body {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            color: #fff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            
        }
        .star-icon {
            width: 100px;
            height: 100px;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
        }
        .star-icon i {
            color: #DC143C;
            font-size: 50px;
        }
        .song-list {
            margin-top: 20px;
        }
        .song-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .song-item img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .song-item .song-title {
            flex-grow: 1;
            color:#fff;
        }
        .song-item .song-artist {
            color: gray;
            margin-right: 20px;
        }
        .song-item .song-duration {
            color: gray;
            margin-right: 10px;
        }
        .song-item .song-options {
            color: gray;
        }
        .btn-play, .btn-shuffle {
            width: 100px;
            margin-right: 10px;
        }
        .btn-play i, .btn-shuffle i {
            margin-right: 5px;
        }
        .song-item .star-icon-small {
            color: #DC143C;
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .star-icon {
                width: 80px;
                height: 80px;
            }
            .star-icon i {
                font-size: 40px;
            }
            .song-item img {
                width: 30px;
                height: 30px;
            }
            body{
                padding-left: 15%;
            }
        }
        .fas fa-star star-icon-small{
            color: #DC143C;
        }
  </style>
 </head>
 <body style="margin-left: 15%;">
        <?php include 'includes/sidebar2.php'; ?>
  <div class="container mt-5">
   <div class="row">
    <div class="col-md-3 text-center">
     <div class="star-icon">
      <i class="fas fa-star">
      </i>
     </div>
    </div>
    <div class="col-md-9" style='color:#fff;'>
     <h3>
      Favourite Songs
     </h3>
    </div>
   </div>
   <?php if (!empty($liked_songs)): ?>
    <?php foreach ($liked_songs as $song): ?>
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
        </div>
    <?php endforeach; ?>
   <?php else: ?>
    <p>No liked songs yet.</p>
   <?php endif; ?>

     <?php include 'includes/music-player2.php'; ?>
</body>
</html>