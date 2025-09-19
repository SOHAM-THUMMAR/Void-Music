<!-- upload_form.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Upload Song</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    body {
      background: #0a0a0a;
      color: white;
      font-family: 'Arial', sans-serif;
    }
    .container {
      max-width: 600px;
      margin-top: 50px;
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }
    .form-control {
      background: #2C2C2C;
      color: white;
      border: none;
    }
    .form-control:focus {
      background: #3d3a4e;
      color: white;
      box-shadow: none;
    }
    .button {
      width: 100%;
      padding: 10px;
      background: linear-gradient(45deg, #DC143C, #800020);
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s;
    }
    .button:hover {
      transform: scale(1.05);
      box-shadow: 0 0 10px rgba(255, 77, 77, 0.5);
    }
  </style>
</head>
<body>
<?php include 'includes/sidebar2.php'; ?>

  <div class="container">
    <h2 class="text-center">Upload Your Song</h2>
    
    <?php if (isset($_SESSION['upload_error'])): ?>
      <div class="alert alert-danger"><?php echo $_SESSION['upload_error']; unset($_SESSION['upload_error']); ?></div>
    <?php endif; ?>
    
    <form action="uploading.php" enctype="multipart/form-data" method="POST">
      <div class="mb-3">
        <label class="form-label">Song Title</label>
        <input type="text" class="form-control" name="songTitle" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Artist Name</label>
        <input type="text" class="form-control" name="artistName" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Genre</label>
        <input type="text" class="form-control" name="genre" required>
      </div>
      <!-- <div class="mb-3">
        <label class="form-label">Playlist</label>
        <select class="form-control" name="playlist" id="playlist" required>
          <option value="">Select Playlist</option>
          <option value="new">Create New Playlist</option>
        </select>
        <input type="text" class="form-control mt-2" id="newPlaylist" name="newPlaylist" placeholder="Enter new playlist name" style="display: none;">
      </div> -->
      <div class="mb-3">
        <label class="form-label">Upload File</label>
        <input type="file" class="form-control" name="songFile" accept="audio/*" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Upload Cover Image</label>
        <input type="file" class="form-control" name="coverImage" accept="image/*" required>
      </div>
      <button type="submit" class="button" name="upload">Upload</button>
    </form>
  </div>

  <script>
    document.getElementById('playlist').addEventListener('change', function () {
      const newPlaylistInput = document.getElementById('newPlaylist');
      if (this.value === 'new') {
        newPlaylistInput.style.display = 'block';
        newPlaylistInput.required = true;
      } else {
        newPlaylistInput.style.display = 'none';
        newPlaylistInput.required = false;
      }
    });
  </script>
</body>
</html>
