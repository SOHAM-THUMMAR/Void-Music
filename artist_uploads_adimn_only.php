<?php
include 'includes/config.php';

$message = '';
$artists = [];

// Fetch the list of artists from the database for the dropdown
$query = "SELECT id, artist_name FROM artist_songs GROUP BY artist_name";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $artists[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist_id = $_POST['artist_id']; // Selected artist
    $song_name = $_POST['song_name'];

    // If a new artist is added
    if ($artist_id == 'new') {
        $artist_name = $_POST['artist_name'];

        // Upload files to artist_uploads folder
        $audio_path = 'artist_uploads/audio/' . basename($_FILES['file_path']['name']);
        $profile_path = 'artist_uploads/profiles/' . basename($_FILES['artist_profile']['name']);
        $cover_path = 'artist_uploads/covers/' . basename($_FILES['song_cover']['name']);

        // Ensure folders exist
        if (!is_dir('artist_uploads/audio')) mkdir('artist_uploads/audio', 0777, true);
        if (!is_dir('artist_uploads/profiles')) mkdir('artist_uploads/profiles', 0777, true);
        if (!is_dir('artist_uploads/covers')) mkdir('artist_uploads/covers', 0777, true);

        $upload_audio = move_uploaded_file($_FILES['file_path']['tmp_name'], $audio_path);
        $upload_profile = move_uploaded_file($_FILES['artist_profile']['tmp_name'], $profile_path);
        $upload_cover = move_uploaded_file($_FILES['song_cover']['tmp_name'], $cover_path);

        if ($upload_audio && $upload_profile && $upload_cover) {
            $stmt = mysqli_prepare($con, "INSERT INTO artist_songs (artist_name, song_name, file_path, artist_profile, song_cover) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $artist_name, $song_name, $audio_path, $profile_path, $cover_path);
            mysqli_stmt_execute($stmt);

            $message = "Song uploaded successfully and pending approval!";
        } else {
            $message = "Failed to upload one or more files.";
        }
    } else {
        // If an existing artist is selected
        $query = "SELECT artist_profile FROM artist_songs WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $artist_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $artist = mysqli_fetch_assoc($result);

        // Upload song related files
        $audio_path = 'artist_uploads/audio/' . basename($_FILES['file_path']['name']);
        $cover_path = 'artist_uploads/covers/' . basename($_FILES['song_cover']['name']);

        // Ensure the folder exists
        if (!is_dir('artist_uploads/audio')) mkdir('artist_uploads/audio', 0777, true);
        if (!is_dir('artist_uploads/covers')) mkdir('artist_uploads/covers', 0777, true);

        $upload_audio = move_uploaded_file($_FILES['file_path']['tmp_name'], $audio_path);
        $upload_cover = move_uploaded_file($_FILES['song_cover']['tmp_name'], $cover_path);

        if ($upload_audio && $upload_cover) {
            $stmt = mysqli_prepare($con, "INSERT INTO artist_songs (artist_name, song_name, file_path, artist_profile, song_cover) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $artist['artist_name'], $song_name, $audio_path, $artist['artist_profile'], $cover_path);
            mysqli_stmt_execute($stmt);

            $message = "Song uploaded successfully and pending approval!";
        } else {
            $message = "Failed to upload one or more files.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Artist Song</title>
    <style>
        body {
    background: #0a0a0a;
    color: white;
    font-family: 'Arial', sans-serif;
}

.upload-form {
    background: rgba(255, 255, 255, 0.1) !important;
    padding: 30px;
    border-radius: 12px;
    max-width: 500px;
    margin: auto;
    box-shadow: 0 0 15px #2C2C2C;
    color: white;
}

.upload-form input[type="text"],
.upload-form input[type="file"],
.upload-form select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    background: #2C2C2C;
    color: white;
    border: none;
    border-radius: 8px;
}

.upload-form input[type="submit"] {
    background: linear-gradient(45deg, #DC143C, #800020);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s;
    width: 100%;
}

.upload-form input[type="submit"]:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(255, 77, 77, 0.5);
    color: white;
}

.upload-form label {
    display: block;
    margin: 10px 0;
}

#new-artist {
    display: none;
    margin-top: 20px;
}

.message {
    margin-top: 15px;
    color: #90EE90;
}

select {
    background: #2C2C2C;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px;
    width: 100%;
}

button {
    position: relative;
    overflow: hidden;
    height: 3rem;
    padding: 0 2rem;
    border-radius: 1.5rem;
    background: #3d3a4e;
    background-size: 400%;
    color: #fff;
    border: none;
    cursor: pointer;
}

button:hover::before {
    transform: scaleX(1);
}

button::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    transform: scaleX(0);
    transform-origin: 0 50%;
    width: 100%;
    height: inherit;
    border-radius: inherit;
    background: linear-gradient(
        82.3deg,
        rgba(150, 93, 233, 1) 10.8%,
        rgba(99, 88, 238, 1) 94.3%
    );
    transition: all 0.475s;
}

    </style>
</head>
<body>

    <h2>Upload Artist Song</h2>
    <form class="upload-form" action="" method="POST" enctype="multipart/form-data">
        <label>Choose Artist:</label>
        <select name="artist_id" id="artist_id" required>
            <option value="new">-- Select Artist --</option>
            <?php foreach ($artists as $artist): ?>
                <option value="<?php echo $artist['id']; ?>"><?php echo $artist['artist_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <div id="new-artist" style="display: none;">
            <label>New Artist Name:</label>
            <input type="text" name="artist_name">

            <label>Artist Profile Image:</label>
            <input type="file" name="artist_profile" accept="image/*" required>
        </div>

        <label>Song Name:</label>
        <input type="text" name="song_name" required>

        <label>Audio File:</label>
        <input type="file" name="file_path" accept="audio/*" required>

        <label>Song Cover Image:</label>
        <input type="file" name="song_cover" accept="image/*" required>

        <input type="submit" value="Upload Song">
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </form>

    <script>
        document.getElementById('artist_id').addEventListener('change', function() {
            if (this.value === 'new') {
                document.getElementById('new-artist').style.display = 'block';
            } else {
                document.getElementById('new-artist').style.display = 'none';
            }
        });
    </script>

</body>
</html>
