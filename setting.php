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
$email = $row['email'];
?>
<html>
<head>
    <title>Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #1C1C1C;
            color: #F5F5F5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #sidebar {
            position: fixed;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #2C2C2C;
            z-index: 1000;
        }
        .main-content {
            margin-left: 250px;
            padding: 0;
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }
        .settings-header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background-color: #1c1c1c;
        }
        .settings-header h1 {
            font-size: 24px;
            margin: 0;
            color: #F5F5F5;
            font-weight: bold;
        }
        .settings-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #333;
            transition: background-color 0.3s ease;
        }
        .settings-item:hover {
            background-color: #2C2C2C;
            cursor: pointer;
        }
        .settings-item i {
            font-size: 24px;
            margin-right: 15px;
            color: #DC143C;
            min-width: 24px;
        }
        .settings-item h2 {
            font-size: 16px;
            margin: 0;
            color: #F5F5F5;
            font-weight: 500;
        }
        .settings-item p {
            margin: 5px 0 0 0;
            color: #F5F5F5;
            font-size: 14px;
        }
        .logout-button {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .logout-button button {
            background-color: #DC143C;
            color: #F5F5F5;
            border: none;
            padding: 10px 30px;
            border-radius: 20px;
            font-weight: bold;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        .logout-button button:hover {
            background-color: #800020;
            transform: scale(1.05);
            cursor: pointer;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                margin-left: 0;
            }
            #sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .settings-item {
                padding: 12px;
            }
            .settings-item i {
                font-size: 20px;
                margin-right: 12px;
            }
            .settings-item h2 {
                font-size: 14px;
            }
            .settings-item p {
                font-size: 12px;
            }
            .settings-header h1 {
                font-size: 20px;
            }
        }

        /* Small mobile devices */
        @media (max-width: 480px) {
            .settings-item p {
                max-width: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }

        /* Handle text overflow for all screen sizes */
        .settings-item div {
            flex: 1;
            min-width: 0; /* Allows flex items to shrink below content size */
        }
        .settings-item p {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar2.php'; ?>
    <div class="main-content">
        <div class="settings-header">
            <h1>Settings</h1>
        </div>
        <div class="settings-item">
            <i class="fas fa-user"></i>
            <div>
                <h2>Account</h2>
                <p><?php echo "$name • $email";?></p>
            </div>
        </div>
        <div class="settings-item">
            <i class="fas fa-lock"></i>
            <div>
                <h2>Privacy and social</h2>
                <p>Recently played artists • Followers and following</p>
            </div>
        </div>
        <!-- <div class="settings-item">
            <i class="fas fa-bell"></i>
            <div>
                <h2>Notifications</h2>
                <p>Push • Email</p>
            </div>
        </div> -->
        <div class="settings-item">
            <i class="fas fa-signal"></i>
            <div>
                <h2>Media quality</h2>
                <p>Wi-Fi streaming quality • Cellular streaming quality</p>
            </div>
        </div>
        <div class="settings-item">
            <i class="fas fa-info-circle"></i>
            <div>
                <h2>About</h2>
                <p>Version • Privacy Policy</p>
            </div>
        </div>
        <div class="logout-button">
            <a href="logout.php"><button>Log out</button></a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>