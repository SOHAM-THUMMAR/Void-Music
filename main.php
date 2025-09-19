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
$row = $result->fetch_assoc();
$name = $row['name'];
$pro_pic = $row['profile_pic'];


$sql = "SELECT DISTINCT artist_name, artist_profile FROM artist_songs WHERE status = 'approved'";
$result = mysqli_query($con, $sql);

$user_email = $_SESSION['email'];
// Get user ID
$userQuery = $con->prepare("SELECT id FROM users WHERE email = ?");
$userQuery->bind_param('s', $user_email);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();
$user_id = $userData['id'];

// Get all liked songs for this user
$likedSongsQuery = $con->prepare("SELECT song_id, song_type FROM likes WHERE user_id = ?");
$likedSongsQuery->bind_param('i', $user_id);
$likedSongsQuery->execute();
$likedSongsResult = $likedSongsQuery->get_result();

// Create an array of liked song IDs
$likedSongs = [];
while ($like = $likedSongsResult->fetch_assoc()) {
    $likedSongs[] = (int)$like['song_id'];
}

// Close these queries
$userQuery->close();
$likedSongsQuery->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
   body {
    margin-left: 4%; /* Adjusted for sidebar width */
    background: linear-gradient(135deg, #1C1C1C, #2C2C2C);
    color: #fff;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    overflow-x: hidden;
}
<?php // test?>
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
    color: #aaa; /* Default gray color */
    transition: color 0.3s ease;
}

.like-btn.liked .fa-heart {
    color: #DC143C; /* Red color for liked state */
    animation: pop 0.3s ease;
}

@keyframes pop {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.song-wrapper {
    display: flex;
    align-items: center;
    /* justify-content: space-between; */
    padding: 10px;
}

.song-item {
    flex-grow: 1;
    display: flex;
    align-items: center;
    cursor: pointer;
}
<?php // test?>
/* Artist Songs Section Styles */
#artistSongsSection {
    padding: 20px;
    border-top: 1px solid #2c2c2c;
    margin-top: 20px;
}

#artistSongsTitle {
    font-size: 20px;
    margin-bottom: 15px;
}

/* Song Item */
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
    color: #fff;
}

.song-item .song-info span {
    font-size: 14px;
    color: #aaa;
}

.play-song {
    cursor: pointer;
}

.play-song:hover {
    background-color: #2c2c2c;
}

/* .sidebar {
    background-color: rgba(18, 18, 18, 0.95);
    color: #fff;
    height: 100vh;
    padding: 24px;
    position: fixed;
    width: 200px;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 100;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
}

.sidebar h2 {
    color: #1ed760;
    text-align: left;
    margin-bottom: 32px;
    font-weight: 700;
    font-size: 24px;
}

.sidebar .nav {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    flex-grow: 1;
    padding: 0;
    gap: 8px;
}

.sidebar .nav-link {
    color: #b3b3b3;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    text-align: left;
    padding: 10px 16px;
    border-radius: 8px;
    width: 100%;
    font-weight: 500;
}

.sidebar .nav-item {
    width: 100%;
}

.sidebar .nav-link:hover {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar .nav-link.active {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar .nav-link i {
    margin-right: 12px;
    width: 20px;
    text-align: center;
} */

.greeting {
    font-size: 20px;
    font-weight: 70px;
    margin-bottom: 32px;
    color: #F5F5F5;
    margin-left: 10px; /* Keeps the greeting message in place */
    padding-bottom: 10px;
}

.playlist-grid, .continue-listening {
    margin-bottom: 40px;
}

.playlist-card {
    display: flex;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 16px;
    text-align: left;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.playlist-card:hover {
    transform: translateY(-4px);
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.1);
}

.playlist-img {
    width: 64px;
    height: 64px;
    margin-right: 16px;
    flex-shrink: 0;
}

.playlist-img img {
    width: 100%;
    height: 100%;
    border-radius: 8px;
    object-fit: cover;
}

.playlist-info p {
    margin: 0;
    font-size: 14px;
    color: #F5F5F5;
    font-weight: 500;
}

.see-all {
    color: #DC143C;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.2s ease;
}

.see-all:hover {
    background-color: rgba(30, 215, 96, 0.1);
    color: #800020;
}

.continue-listening .playlist-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

.continue-listening .playlist-card {
    flex-direction: column;
    align-items: flex-start;
    height: auto;
    padding: 16px;
}

.continue-listening .playlist-card img {
    width: 100%;
    height: 150px;
    margin-bottom: 12px;
    border-radius: 8px;
}

.continue-listening .playlist-card p {
    font-size: 14px;
    font-weight: 500;
    margin: 8px 0;
}

.profile-dropdown {
    position: relative;
}

.profile-image {
    margin-left: 20px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid rgba(255, 255, 255, 0.1);
    transition: all 0.2s ease;
    margin-bottom: 10px;
}

.profile-image:hover {
    border-color: #800020;
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.dropdown-menu {
    position: absolute;
    top: 120%;
    right: 0;
    background-color: #282828;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    min-width: 200px;
    padding: 8px 0;
    display: none;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dropdown-item {
    padding: 12px 20px;
    color: #F5F5F5;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #F5F5F5;
}

.dropdown-item i {
    margin-right: 12px;
    width: 16px;
}

.container.mt-4 {
    margin-left: 200px; /* Adjusted for sidebar width */
    padding: 32px;
    padding-bottom: 120px;
}

@media (max-width: 768px) {
    .sidebar {
        width: 12%;
        padding: 16px 8px;
        overflow: hidden;
    }

    .sidebar h2, .sidebar .nav-link span {
        display: none;


    }
    .me{
        display: none;
    }

    .container.mt-4 {
        margin-left: 10%;
    }

    
}
.search-container {
    width: 100%;
    position: relative;
    margin-bottom: 10px;
    margin-left: 5%; /* Keeps the search bar in place */
}

.search-input {
    background-color: rgba(28, 28, 28, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 12px 20px;
    border-radius: 30px;
    width: 100%;
    transition: all 0.3s ease;
    font-size: 14px;
    padding-right: 45px;
}

.search-input:focus {
    background-color: rgba(40, 40, 40, 0.9);
    border-color: #DC143C;
    color: #fff;
    box-shadow: 0 0 15px rgba(220, 20, 60, 0.15);
    outline: none;
    transform: translateY(-1px);
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
    font-weight: 300;
}

#searchButton {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.5);
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

#searchButton:hover {
    color: #DC143C;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

/* Add hover effect */
.search-container:hover .search-input {
    background-color: rgba(35, 35, 35, 0.9);
    border-color: rgba(255, 255, 255, 0.2);
}
#greeting{
            font-weight: bold;
            font-size: x-large;
        }
.container_recent-creations{
    display:block;
    right: 0px;
    width: 640px;
}
.playlist-card{
    width: 200px;
    display: flex;
    justify-content: space-between;
}

img{
    height: 100px;
    width: 100px;
}
.SH{
    width: 400px;
}

.continue-listening {
    display: flex;
    flex-wrap: wrap; /* Allows items to wrap to next line */
    gap: 20px;        /* Space between cards */
    justify-content: start; /* Align cards to the left */
}
.playlist-card {
    flex: 0 0 200px;       /* Fixed width card */
    background-color: #222; /* Optional background */
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: transform 0.2s;
}

.playlist-card img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

</style>

</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'includes/sidebar2.php'; ?>

        <!-- Main Content -->
        <div class="container mt-4 flex-grow-1" style="left: 12%;">
           <!-- Greeting Section -->
            <div style="z-index: 10;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-4 flex-grow-1">
                    <span id="greeting"></span><span id="greeting"><?php echo $name; ?></span>
                    <div class="SH">
                    <form method="get" action="searched.php">
                        <div class="search-container">
                            <div class="input-group">
                                <input type="text" class="search-input" id="searchInput" name="search" placeholder="Search for songs, artists, or playlists...">
                                <button id="searchButton" type="submit" value="Search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                    </div>
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown">
                    <div class="profile-image" id="profileImage">
                        <img src="uploads/<?php echo $pro_pic;?>" alt="Profile Image">
                    </div>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i> Profile</a>
                        <a class="dropdown-item" href="setting.php"><i class="fas fa-cog"></i> Settings</a>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
            </div>

            <!-- Continue Listening Section -->
            <div class="continue-listening mt-4">
    <!-- <div class="playlist-wrapper"> -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
               <a href="main.php?artist_name=<?php echo urlencode($row['artist_name']); ?>" class="playlist-card" style="text-decoration: none; color: inherit;">

                    <img src="<?php echo $row['artist_profile']; ?>" alt="<?php echo htmlspecialchars($row['artist_name']); ?>">
                    <p><?php echo htmlspecialchars($row['artist_name']); ?></p>
                </a>
                <!-- </div> -->
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#fff;">No artists found.</p>
        <?php endif; ?>
    </div>
    
</div>
<div class="continue-listening mt-4">
    <!-- <div class="playlist-wrapper"> -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
               <span><a href="main.php?artist_name=<?php echo urlencode($row['artist_name']); ?>" class="playlist-card" style="text-decoration: none; color: inherit;">

                    <img src="<?php echo $row['artist_profile']; ?>" alt="<?php echo htmlspecialchars($row['artist_name']); ?>">
                    <p><?php echo htmlspecialchars($row['artist_name']); ?></p>
                </a></span>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#fff;">No artists found.</p>
        <?php endif; ?>
    </div>
    
<!-- </div> -->

<!-- Section to load the artist's songs dynamically -->

<?php
if (isset($_GET['artist_name'])) {
    $selectedArtist = $_GET['artist_name'];
    $stmt = $con->prepare("SELECT * FROM artist_songs WHERE artist_name = ? AND status = 'approved'");
    $stmt->bind_param("s", $selectedArtist);
    $stmt->execute();
    $songsResult = $stmt->get_result();
    ?>

    <div class="container_recent-creations" id="artistSongsSection">
    <h4 id="artistSongsTitle">Songs by <?php echo htmlspecialchars($selectedArtist); ?></h4>
    <div id="artistSongsList">
        <?php if ($songsResult->num_rows > 0): ?>
            <?php while ($song = $songsResult->fetch_assoc()): ?>
                <!-- <div class="song-wrapper"> -->
                    <div class="song-item play-song"
                         data-title="<?php echo htmlspecialchars($song['song_name']); ?>"
                         data-artist="<?php echo htmlspecialchars($song['artist_name']); ?>"
                         data-cover="<?php echo htmlspecialchars($song['song_cover']); ?>" 
                         data-src="<?php echo htmlspecialchars($song['file_path']); ?>"
                         data-img="<?php echo isset($song['song_cover']) ? htmlspecialchars($song['song_cover']) : 'default-image.jpg'; ?>">
                         
                        <img src="<?php echo isset($song['song_cover']) ? htmlspecialchars($song['song_cover']) : 'default-image.jpg'; ?>" alt="Cover Art">
                        
                        <div class="song-info">
                            <h5><?php echo htmlspecialchars($song['song_name']); ?></h5>
                            <span><?php echo htmlspecialchars($song['artist_name']); ?></span>
                        </div>
                    </div>

                    <button class="like-btn <?php echo in_array((int)$song['id'], $likedSongs, true) ? 'liked' : ''; ?>"
                            data-song-id="<?php echo $song['id']; ?>" 
                            onclick="likeSong(<?php echo $song['id']; ?>, event)">
                        <i class="fas fa-heart"></i>
                    </button>
                <!-- </div> -->
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#aaa;">No songs found for this artist.</p>
        <?php endif; ?>
    </div>
</div>

<?php } ?>




    

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced Profile Dropdown
        const profileImage = document.getElementById('profileImage');
        const dropdownMenu = document.querySelector('.dropdown-menu');
        
        profileImage.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.profile-dropdown')) {
                dropdownMenu.style.display = 'none';
            }
        });

        // Add active class to current nav item
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');

        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        function performSearch() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            // Add your search logic here
            console.log('Searching for:', searchTerm);
            
            // Example: You can add AJAX call to your backend here
            // fetch('/search?q=' + encodeURIComponent(searchTerm))
            //     .then(response => response.json())
            //     .then(data => {
            //         // Handle search results
            //     });
        }
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set Greeting
        const greetingElement = document.getElementById('greeting');
        const currentHour = new Date().getHours();

        if (currentHour < 12) {
            greetingElement.innerHTML = `Good Morning,`;
        } else if (currentHour < 18) {
            greetingElement.innerHTML = `Good Afternoon,`;
        } else {
            greetingElement.innerHTML = `Good Evening,`;
        }

        // Toggle statistics card
        const statsCard = document.querySelector('.statistics-card');
        const toggleIcon = document.querySelector('.toggle-icon');
        const chartContainer = document.querySelector('.chart-container');

        statsCard.addEventListener('click', () => {
            statsCard.classList.toggle('expanded');
            chartContainer.style.display = statsCard.classList.contains('expanded') ? 'block' : 'none';
        });
        //testing
 
function likeSong(songId, event) {
    if (event) {
        event.stopPropagation();
    }

    const btn = event.currentTarget;
    const heartIcon = btn.querySelector('.fa-heart');
    const isCurrentlyLiked = btn.classList.contains('liked');

    // Optimistic update
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
            // Revert on unexpected response
            btn.classList.toggle('liked', isCurrentlyLiked);
            heartIcon.style.color = isCurrentlyLiked ? '#DC143C' : '#aaa';
            console.warn('Server response unexpected:', data);
        }
    })
    .catch(err => {
        // Revert on error
        btn.classList.toggle('liked', isCurrentlyLiked);
        heartIcon.style.color = isCurrentlyLiked ? '#DC143C' : '#aaa';
        console.error('Error:', err);
    });
}

        //testing

    </script>

        <?php include 'includes/music-player2.php'; ?>

</body>
</html>
<?php
$query->close();
$con->close();
?>