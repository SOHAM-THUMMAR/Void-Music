<?php
require 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Music Platform</title>
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
      margin-left: 15px;
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
  </style>
</head>
<body>

<?php include 'includes/admin_sidebar.php'; ?>

<h2>List of Contacted Users</h2>
<div class="container">
<?php
$sqlselect = "SELECT id, name, email, message FROM contact_us";
$result = $con->query($sqlselect);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Reply</th>
                <th>Delete</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["message"]."</td>
                <td><a href='admin_reply.php?id=".$row["id"]."' class='btn btn-edit'>Reply</a></td>
                <td><a href='delete_message.php?id=".$row["id"]."' class='btn btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='text-center text-muted'>No messages found.</p>";
}
?>
</div>

</body>
</html>
