<?php
session_start();
require "includes/config.php"; // make sure this contains $con = new mysqli(...)
$query = $con->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param('s', $_SESSION['email']);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();
$name = $row['name'];
$pro_pic = $row['profile_pic'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $title = trim($_POST['songTitle']);
    $artist = trim($_POST['artistName']);
    $genre = trim($_POST['genre']);
    $uploaded_by = $_SESSION['email']; // Replace with session email or user ID

    $playlist = ($_POST['playlist'] === 'new') ? trim($_POST['newPlaylist']) : $_POST['playlist'];

    // Directories for song and cover image
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle the song file upload
    if (isset($_FILES['songFile']) && is_uploaded_file($_FILES['songFile']['tmp_name'])) {
        $songFileName = basename($_FILES["songFile"]["name"]);
        $songFilePath = $uploadDir . uniqid() . "_" . $songFileName;

        if (move_uploaded_file($_FILES["songFile"]["tmp_name"], $songFilePath)) {
            // Handle the cover image upload
            $coverImagePath = null;
            if (isset($_FILES['coverImage']) && is_uploaded_file($_FILES['coverImage']['tmp_name'])) {
                $coverImageFileName = basename($_FILES["coverImage"]["name"]);
                $coverImagePath = $uploadDir . uniqid() . "_" . $coverImageFileName;

                if (!move_uploaded_file($_FILES["coverImage"]["tmp_name"], $coverImagePath)) {
                    $_SESSION['upload_error'] = "Failed to upload cover image.";
                    header("Location: upload_form.php");
                    exit();
                }
            }

            // Insert the song data along with cover image path (if available)
            $stmt = $con->prepare("INSERT INTO songs (title, artist, genre, playlist_name, file_path, cover_image, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $title, $artist, $genre, $playlist, $songFilePath, $coverImagePath, $uploaded_by);

            if ($stmt->execute()) {
                // Now insert into artist_uploads table
                $artistName = $artist;
                $songName = $title;
                $artistFilePath = $songFilePath;
                $artistProfilePath = "uploads/$pro_pic"; // Same cover image
                $songCoverPath = $coverImagePath;
                $status = 'pending'; 
                $createdAt = date('Y-m-d H:i:s'); 
            
                $artistStmt = $con->prepare("INSERT INTO artist_songs (artist_name, song_name, file_path, artist_profile, song_cover, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $artistStmt->bind_param("sssssss", $artistName, $songName, $artistFilePath, $artistProfilePath, $songCoverPath, $status, $createdAt);
            
                if ($artistStmt->execute()) {
                    $_SESSION['upload_success'] = "Song uploaded successfully and artist page updated!";
                    header("Location: upload_success.php");
                    exit();
                } else {
                    $_SESSION['upload_error'] = "Song uploaded but artist page update failed: " . $artistStmt->error;
                    header("Location: upload_form.php");
                    exit();
                }
            }
            
        } else {
            $_SESSION['upload_error'] = "Failed to move uploaded song file.";
            header("Location: upload_form.php");
            exit();
        }
    } else {
        $_SESSION['upload_error'] = "No song file uploaded.";
        header("Location: upload_form.php");
        exit();
    }
} else {
    $_SESSION['upload_error'] = "Invalid request.";
    header("Location: upload_form.php");
    exit();
}
?>
