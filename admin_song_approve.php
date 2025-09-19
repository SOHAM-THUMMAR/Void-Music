<?php
require_once 'includes/config.php';

// Update status if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_status'])) {
    $song_id = intval($_POST['song_id']);
    $new_status = $_POST['new_status'];

    // First, update the songs table
    $stmt = $con->prepare("UPDATE songs SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $song_id);
    $stmt->execute();
    $stmt->close();

    // Then, fetch the file_path from songs table (to find the corresponding artist_song)
    $stmt = $con->prepare("SELECT file_path FROM songs WHERE id = ?");
    $stmt->bind_param("i", $song_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    // Now update the artist_song table based on the file_path
    if (!empty($file_path)) {
        $stmt = $con->prepare("UPDATE artist_songs SET status = ? WHERE file_path = ?");
        $stmt->bind_param("ss", $new_status, $file_path);
        $stmt->execute();
        $stmt->close();
    }
}



// Filter by status

$status_filter = isset($_GET['status']) ? $_GET['status'] : 'pending';
$stmt = $con->prepare("SELECT * FROM songs WHERE status = ?");
$stmt->bind_param("s", $status_filter);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Song Approval</title>
    <style>
        body {
            margin-left: 15%;
            background: linear-gradient(135deg, #1C1C1C, #2C2C2C);
            color: #fff;
            font-family: 'Inter', sans-serif;
        }
        .container {
            padding: 40px;
            margin-left: 200px;
        }
        h2 {
            color: #F5F5F5;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        .section {
            margin-bottom: 60px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 12px;
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
            font-size: 14px;
        }
        th {
            color: #DC143C;
            font-weight: 600;
        }
        td {
            color: #F5F5F5;
        }
        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: 0.3s ease;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-edit {
            background-color: #DC143C;
            color: white;
        }
        .btn-edit:hover {
            background-color: #800020;
        }
        .btn-delete {
            background-color: transparent;
            border: 1px solid #DC143C;
            color: #DC143C;
        }
        .btn-delete:hover {
            background-color: #DC143C;
            color: white;
        }
        .status-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .status-form select {
            padding: 6px;
            border-radius: 6px;
            border: none;
        }
    </style>

</head>
<body>
  <?php include 'includes/admin_sidebar.php'; ?>
    <div class="container">
        <h2>Admin Song Approval</h2>
        <div class="section_">
            <form method="get">
                <label for="status">Filter by Status:</label>
                <select name="status" onchange="this.form.submit()">
                    <option value="pending" <?= $status_filter === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $status_filter === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= $status_filter === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Song</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Playlist</th>
                        <th>Uploaded By</th>
                        <th>Uploaded At</th>
                        <!-- <th>Status</th> -->
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td>
                                <audio controls>
                                    <source src="<?php echo $row['file_path']?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                </audio>
                            </td>
                            <td><?= htmlspecialchars($row['artist']) ?></td>
                            <td><?= htmlspecialchars($row['genre']) ?></td>
                            <td><?= htmlspecialchars($row['playlist_name']) ?></td>
                            <td><?= htmlspecialchars($row['uploaded_by']) ?></td>
                            <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
                            <td>
                                <form method="post" class="status-form">
                                    <input type="hidden" name="song_id" value="<?= $row['id'] ?>">
                                    <select name="new_status" required>
                                        <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="approved" <?= $row['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="rejected" <?= $row['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-edit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
