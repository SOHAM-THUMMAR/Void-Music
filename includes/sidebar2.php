<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            color: #fff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background-color: rgba(18, 18, 18, 0.95);
            color: #fff;
            height: 100vh;
            padding: 24px;
            position: fixed;
            width: 15%;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar h2 {
            color: #DC143C;
            text-align: left;
            margin-bottom: 16px;
            font-weight: 700;
            font-size: 50px;
        }

        /* Scrollable Menu Area */
        .menu-container {
            flex-grow: 1;
            overflow-y: auto;
            max-height: 80vh; /* Adjust max height to fit screen */
            padding-right: 5px; /* Prevents content from touching scrollbar */
        }

        /* Optional: Custom scrollbar */
        .menu-container::-webkit-scrollbar {
            width: 6px;
        }

        .menu-container::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar .nav {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0;
            gap: 8px;
        }

        .sidebar .nav-link {
            color: #b3b3b3;
            margin-bottom: 8px;
            transition: all 0.2s ease;
            text-align: left;
            padding: 10px 16px;
            border-radius: 8px;
            width: 100%;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 12%;
                padding: 16px 8px;
                overflow: hidden;
            }

            .sidebar h2, .sidebar .nav-link p {
                display: none;
            }

            .container.mt-4 {
                margin-left: 10%;
            }
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <h2><center>void</center></h2>
        <div class="menu-container">  <!-- Scrollable Area -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="main.php"><i class="fas fa-home"></i><p class="me">Home</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="playlist.php"><i class="fas fa-music"></i><p class="me">Sound-Capsule</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favorites.php"><i class="fas fa-heart"></i><p class="me">Favorites</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about-us.php"><i class="fas fa-info-circle"></i><p class="me">About Us</p></a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="valid_login.php"><i class="fas fa-sign-in-alt"></i><p class="me">Login</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i><p class="me">Register</p></a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i><p class="me">Contact Us</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload_song.php"><i class="fas fa-upload"></i><p class="me">Upload Song</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php"><i class="fas fa-user"></i><p class="me">Admin</p></a>
                </li>
            </ul>
        </div>
    </nav>

</body>
</html>
