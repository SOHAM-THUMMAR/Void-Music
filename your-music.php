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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Music</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1C1C1C, #2C2C2C);
            color: #fff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Add this to handle sidebar */
        .main-content {
            margin-left: 15%; /* Adjust this value to match your sidebar width */
            width: calc(100% - 250px);
            transition: margin-left .3s ease;
            color:#F5F5F5;
        }

        /* Add media query for mobile responsiveness */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 6%;
                width: 100%;
            }
        }

        .container.mt-4 {
            padding: 32px;
            padding-bottom: 120px;
        }

        /* Override Bootstrap's default card styles */
        .card {
            background: #1C1C1C !important; /* Added !important */
            border-radius: 8px;
            margin-bottom: 16px;
            padding: 16px;
            border: none !important; /* Added to remove default border */
        }

        .card img {
            width: 100%;
            border-radius: 8px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #DC143C;
        }

        .card-text {
            font-size: 14px;
            color: #F5F5F5;
        }

        .statistics-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .statistics-card .card-header {
            position: relative;
            padding: 20px;
            border-bottom: none;
            background: #2C2C2C !important; /* Added !important */
        }

        .toggle-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .chart-container {
            padding: 20px;
            height: 0;
            overflow: hidden;
            transition: height 0.3s ease;
        }

        .statistics-card.expanded .chart-container {
            height: 150px;
            display: block;
        }

        .statistics-card.expanded .toggle-icon {
            transform: translateY(-50%) rotate(180deg);
        }
        #greeting{
            font-weight: bold;
            font-size: xx-large;
        }

        @media (max-width: 768px) {
            .container.mt-4 {
                padding: 16px;
            }
            body{
                padding-left: 22%;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar2.php'; ?>
    <div class="main-content"> <!-- Added wrapper div -->
        <div class="container mt-4">
            <span id="greeting"></span><span id="greeting"><?php echo $name; ?></span>

            <div class="card statistics-card">
                <div class="card-header" id="statsHeader">
                    <h5 class="card-title">Total Time Listened</h5>
                    <p class="card-text">You have listened to a total of 5 hours and 30 minutes of music.</p>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="chart-container" style="display: none;">
                    <p>Additional content can go here (e.g., statistics in text or images).</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" alt="Card Image 1">
                        <div class="card-body">
                            <h5 class="card-title">Song Title 1</h5>
                            <p class="card-text">Artist Name 1</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" alt="Card Image 2">
                        <div class="card-body">
                            <h5 class="card-title">Song Title 2</h5>
                            <p class="card-text">Artist Name 2</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set Greeting
        const greetingElement = document.getElementById('greeting');
        const currentHour = new Date().getHours();

        if (currentHour < 12) {
            greetingElement.innerHTML = `Good Morning,`;
        } else if (currentHour < 18) {
            greetingElement.innerHTML = `Good Afternoon, `;
        } else {
            greetingElement.innerHTML = `Good Evening, `;
        }

        // Toggle statistics card
        const statsCard = document.querySelector('.statistics-card');
        const toggleIcon = document.querySelector('.toggle-icon');
        const chartContainer = document.querySelector('.chart-container');

        statsCard.addEventListener('click', () => {
            statsCard.classList.toggle('expanded');
            chartContainer.style.display = statsCard.classList.contains('expanded') ? 'block' : 'none';
        });
    </script>
    <?php include 'includes/music-player2.php'; ?>
</body>
</html>