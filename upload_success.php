<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Success</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color:#0a0a0a; color:white; text-align:center; padding:50px;">
  <h1><?php echo $_SESSION['upload_success'] ?? 'Song uploaded successfully!'; ?></h1>
  <a href="upload_song.php" class="btn btn-light mt-3">Upload Another Song</a>
</body>
</html>
<?php unset($_SESSION['upload_success']); 
header("Location: main.php");?>
