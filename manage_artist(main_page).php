<?php
require 'includes/config.php';
$result = $con->query("SELECT COALESCE(MAX(id), 0) + 1 as next_id FROM artist_songs");
$row = $result->fetch_assoc();
$next_id = $row['next_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Music Platform</title>
  <style>
    /* --- Existing Styles (based on your shared CSS) --- */
    body {
      margin-left: 18%;
      background: linear-gradient(135deg, #1C1C1C, #2C2C2C);
      color: #fff;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      overflow-x: hidden;
    }
    .container {
      padding: 40px;
      margin-left: 200px;
    }
    h2 {
      color: #F5F5F5;
      font-size: 28px;
      margin-bottom: 20px;
    }
    .section {
      margin-bottom: 60px;
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    table {
      width: 97%;
      border-collapse: collapse;
      margin-top: 20px;
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
  </style>
</head>
<?php include 'includes/admin_sidebar.php'?>
<body style="margin-left: 18%;">
</div>

<!-- Student List -->
<h2 class="mt-4 text-center">List of users</h2>
<?php
$sqlselect = "SELECT * FROM artist_songs";
$result = $con->query($sqlselect);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <tr>
                <th>User_ID</th>
                <th>Artist Name</th>
                <th>Song</th>
                <th>Delete Record</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td align='center'>".$row["id"]."</td>
                <td align='center'>".$row["artist_name"]."</td>
                <td align='center'>".$row["song_name"]."</td>
                <td align='center'><a href='delete_song_from_main.php ? id=".$row["id"]."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='text-center text-muted'>No student records found.</p>";
}
?>
</div>


</body>
</html>
<!-- <td align='center'><a href='update.php ? id=".$row["id"]."' class='btn btn-warning btn-sm'>Update</a></td> -->
