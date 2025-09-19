<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>void</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #0a0a0a;
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(10px);
            padding: 15px 0;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #DC143C !important;
        }
        .nav-buttons {
            display: flex;
            gap: 20px;
        }
        .nav-button {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 25px !important;
            padding: 8px 20px !important;
            border: none !important;
            color: white !important;
            font-weight: bold !important;
            transition: all 0.3s !important;
            text-decoration: none !important;
            display: inline-block !important;
        }
        .nav-button:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: scale(1.05) !important;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('https://images.unsplash.com/photo-1551103782-8ab07afd45c1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }
        .hero-content {
            max-width: 800px;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: linear-gradient(80deg, #DC143C, #F5F5F5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(255, 77, 77, 0.3);
        }
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #cccccc;
        }
        .temp-btn {
            background: linear-gradient(45deg, #DC143C, #800020);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            margin: 10px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: inline-block;
            text-decoration: none;
        }
        .temp-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 77, 77, 0.5);
            color: white;
            text-decoration: none;
        }
        .temp-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.5s;
        }
        .temp-btn:hover::before {
            left: 100%;
        }
        .artist-card {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 15px !important;
            margin: 15px;
            padding: 15px;
            transition: transform 0.3s;
            min-height: 250px;
        }
        .artist-card:hover {
            transform: translateY(-5px);
        }
        .artist-image {
            width: 100%;
            height: 180px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .artist-info {
            text-align: center;
        }
        .artist-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .artist-description {
            font-size: 0.9rem;
            color: #cccccc;
        }

        /* new btn */
        .button {
  position: relative;
  overflow: hidden;
  height: 3rem;
  padding: 0 2rem;
  border-radius: 1.5rem;
  background: #3d3a4e;
  background-size: 400%;
  color: #fff;
  border: none;
  cursor: pointer;
}

.button:hover::before {
  transform: scaleX(1);
}

.button-content {
  position: relative;
  z-index: 1;
}

.button::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  transform: scaleX(0);
  transform-origin: 0 50%;
  width: 100%;
  height: inherit;
  border-radius: inherit;
  background: linear-gradient(
    82.3deg,
    rgba(150, 93, 233, 1) 10.8%,
    rgba(99, 88, 238, 1) 94.3%
  );
  transition: all 0.475s;
}

</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-music"></i> void</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto nav-buttons">
                    <li class="nav-item">
                        <a href="login.php" class="nav-link nav-button">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="nav-link nav-button">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Discover Your Music</h1>
            <p>Your ultimate destination for unlimited music streaming. Listen to millions of songs, create playlists, and share with friends.</p>
            <div class="container">
                <div class="row justify-content-center">
                    <!-- Artist 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="artist-card">
                            <img src="https://musicxclusives.com/wp-content/uploads/2025/02/230515101146-the-weeknd-121222.jpg.webp" 
                                 alt="The Weeknd" 
                                 class="artist-image rounded">
                            <div class="artist-info">
                                <div class="artist-name">The Weeknd</div>
                                <div class="artist-description">Urban & Pop Sensation</div>
                            </div>
                        </div>
                    </div>

                    <!-- Artist 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="artist-card">
                            <img src="https://www.nme.com/wp-content/uploads/2023/05/taylor-swift-deluxe-midnights.jpg" 
                                 alt="Taylor Swift" 
                                 class="artist-image rounded">
                            <div class="artist-info">
                                <div class="artist-name">Taylor Swift</div>
                                <div class="artist-description">Global Pop Icon</div>
                            </div>
                        </div>
                    </div>

                    <!-- Artist 3 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="artist-card">
                            <img src="https://www.nme.com/wp-content/uploads/2025/02/kendrick-lamar-2025-super-bowl-halftime@2000x1270.jpg" 
                                 alt="Kendrick Lamar" 
                                 class="artist-image rounded">
                            <div class="artist-info">
                                <div class="artist-name">Kendrick Lamar</div>
                                <div class="artist-description">Hip-Hop Legend</div>
                            </div>
                        </div>
                    </div>

                    <!-- Artist 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="artist-card">
                            <img src="https://rollingstoneindia.com/wp-content/uploads/2020/08/Shreya-Ghoshal-scaled-e1598187019916.jpg" 
                                 alt="Shreya Ghoshal" 
                                 class="artist-image rounded">
                            <div class="artist-info">
                                <div class="artist-name">Shreya Ghoshal</div>
                                <div class="artist-description">Bollywood Nightingale</div>
                            </div>
                        </div>
                    </div>

                    <!-- Artist 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="artist-card">
                            <img src="https://urbanasian.com/wp-content/uploads/2017/04/sonu-16.jpg?w=714" 
                                 alt="Sonu Nigam" 
                                 class="artist-image rounded">
                            <div class="artist-info">
                                <div class="artist-name">Sonu Nigam</div>
                                <div class="artist-description">Legendary Playback Singer</div>
                            </div>
                        </div>
                    </div>

                    <!-- Artist 6 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="artist-card">
                            <img src="https://thesecondangle.com/wp-content/uploads/2020/09/lata-ji-1024x1024.jpg" 
                                 alt="Lata Mangeshkar" 
                                 class="artist-image rounded">
                            <div class="artist-info">
                                <div class="artist-name">Lata Mangeshkar</div>
                                <div class="artist-description">Queen of Bollywood Music</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="explore.php" class="temp-btn">Explore Now</a>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Add animation to hero section on load
            $('.hero-content').fadeIn(1000);

            // Add hover effect to artist cards
            $('.artist-card').hover(function() {
                $(this).css('transform', 'translateY(-5px)');
            }, function() {
                $(this).css('transform', 'translateY(0)');
            });
        });
    </script>
</body>
</html>