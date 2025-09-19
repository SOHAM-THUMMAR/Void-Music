<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
   body {
    background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
    color: #fff;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    overflow-x: hidden;
}

.sidebar {
    background-color: rgba(18, 18, 18, 0.95);
    color: #fff;
    height: 100vh;
    padding: 24px;
    position: fixed;
    width: 200px; /* Reduced width of sidebar */
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
    color: #1ed760;
    text-align: left;
    margin-bottom: 32px;
    font-weight: 700;
    font-size: 24px;
}

.sidebar .nav {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    flex-grow: 1;
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
}

.sidebar .nav-item {
    width: 100%;
}

.sidebar .nav-link:hover {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar .nav-link.active {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar .nav-link i {
    margin-right: 12px;
    width: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .sidebar {
        width: 80px;
        padding: 16px 8px;
    }

    .sidebar h2, .sidebar .nav-link span {
        display: none;
    }

    .container.mt-4 {
        margin-left: 80px;
        padding: 16px;
    }

    
}
</style>

</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h2>Music App</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="main.php"><i class="fas fa-home"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="your-music.php"><i class="fas fa-music"></i>Sound-Capsule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favorites.php"><i class="fas fa-heart"></i>Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about-us.php"><i class="fas fa-info-circle"></i>About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i>Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i>Register</a>
                </li>
            </ul>
        </nav>
    <script>
        // Add active class to current nav item
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
    </body>
</html>