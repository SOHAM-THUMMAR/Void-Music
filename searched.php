<?php
require 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Songs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    body {
        background-color: #1C1C1C;
        color: #F5F5F5;
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        
    }

    .sidebar {
        width: 250px;
        background-color: #111;
        padding: 20px;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
    }

    .main-content {
        margin-left: 270px;
        padding: 30px;
        flex-grow: 1;
        margin-bottom: 90px;
    }

    h1, h2 {
        color: #DC143C;
    }

    .search-box {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
    }

    input[type="text"] {
        padding: 10px 15px;
        border: 1px solid #2C2C2C;
        border-radius: 5px;
        background-color: #2C2C2C;
        color: #F5F5F5;
        width: 300px;
        font-size: 16px;
    }

    button {
        padding: 10px 20px;
        background-color: #DC143C;
        color: #F5F5F5;
        border: none;
        border-radius: 5px;
        margin-left: 10px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    button:hover {
        background-color: #a10d2d;
    }

    .song-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #3a3a3a;
    }

    .song-item {
        display: flex;
        align-items: center;
        cursor: pointer;
        flex-grow: 1;
    }

    .song-item img {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        margin-right: 10px;
        object-fit: cover;
    }

    .song-item .song-info h5 {
        margin: 0;
        font-size: 16px;
    }

    .song-item .song-info span {
        font-size: 14px;
        color: #aaa;
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
    }

    .like-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: scale(1.1);
    }

    .like-btn .fa-heart {
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

    .play-song:hover {
        background-color: #2c2c2c;
    }

    @media screen and (max-width: 768px) {
        .sidebar {
            width: 200px;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        input[type="text"] {
            width: 200px;
        }
    }

    @media screen and (max-width: 480px) {
        body {
            flex-direction: column;
        }
        .sidebar {
            width: 100%;
            position: relative;
        }
        .main-content {
            margin-left: 0;
        }
    }
    </style>
</head>
<body>

<div class="sidebar">
    <?php include 'includes/sidebar2.php'; ?>
</div>

<div class="main-content">
    <div class="search-box">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Search for songs..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        $search = '';
    }

    if (!empty($search)) {
        $query = $con->prepare("SELECT * FROM songs WHERE (LOWER(title) LIKE LOWER(?) OR LOWER(artist) LIKE LOWER(?)) AND status = 'approved'");
        $searchTerm = "%" . $search . "%";
        $query->bind_param('ss', $searchTerm, $searchTerm);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0): ?>
            <div class="container recent-creations" id="searchResultsSection" style="display:block;">
                <h1 id="searchResultsTitle">Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>
                <div id="searchResultsList">
                    <?php while ($song = $result->fetch_assoc()): ?>
                        <div class="song-wrapper">
                            <div class="song-item play-song"
                                 data-title="<?php echo htmlspecialchars($song['title']); ?>"
                                 data-artist="<?php echo htmlspecialchars($song['artist']); ?>"
                                 data-cover="<?php echo htmlspecialchars($song['cover_image']); ?>" 

                                 data-src="<?php echo htmlspecialchars($song['file_path']); ?>"
                                 data-img="<?php echo isset($song['cover_image']) ? htmlspecialchars($song['cover_image']) : 'default-image.jpg'; ?>">

                                <img src="<?php echo isset($song['cover_image']) ? htmlspecialchars($song['cover_image']) : 'default-image.jpg'; ?>"
                                     alt="Cover Art">

                                <div class="song-info">
                                    <h5><?php echo htmlspecialchars($song['title']); ?></h5>
                                    <span><?php echo htmlspecialchars($song['artist']); ?></span>
                                </div>
                            </div>

                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <p>No results found for "<strong><?php echo htmlspecialchars($search); ?></strong>".</p>
        <?php endif;
    } else {
        echo "<p>Please enter a search term.</p>";
    }
    ?>

    <?php include 'includes/music-player2.php'; ?>
</div>
</body>
</html>
