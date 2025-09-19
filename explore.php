<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fierce Femmes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body { 
            background-color: #1C1C1C; 
            color:#F5F5F5; 
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Main Content Wrapper */
        .main-content {
            margin-left: 0%; /* Further reduced margin */
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            padding-left: 0;
            margin-right: 0;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            margin-left: -15px; /* Negative margin to pull content closer */
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #800020, #2C2C2C);
            padding: 60px 15px;
            text-align: center;
            margin-left: 0;
            width: 100%;
        }
        .hero h1 { 
            color:#F5F5F5; 
            font-w  eight: bold;
            margin-bottom: 15px;
        }
        .hero p { 
            max-width: 600px; 
            margin: 10px auto; 
            font-size: 18px;
            color: #F5F5F5;
        }

        /* About Section */
        .about-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 40px 15px;
            margin-left: 0;
            width: 100%;
        }
        .about-text { 
            margin-left: 5%;
            max-width: 50%;
            padding-right: 30px;
            color:#F5F5F5;
        }
        .about-img {
            max-width: 45%;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(44, 44, 44, 0.8);
        }

        /* Features Section */
        .features {
            background-color: #DC143C;
            padding: 40px 15px;
            text-align: center;
            margin-left: 0;
            width: 100%;
        }
        .feature-box {
            padding: 20px;
            border-radius: 10px;
            background:#800020;
            color:#F5F5F5;
            margin: 15px 0;
            transition: transform 0.3s;
            height: 100%;
        }
        .feature-box:hover { 
            transform: translateY(-5px); 
            border: 1px solid #2C2C2C;
        }
        .cta{
            padding-left: 6%;
        }

        /* Footer */
        footer {
            background-color: #DC143C;
            color:#F5F5F5;
            text-align: center;
            padding: 15px;
            bottom: 0;
            right: 0;
            margin-left: 0;
        }

        /* Music Player Adjustments */
        #music-player {
            margin-left: 200px;
            width: calc(100% - 200px);
        }

        /* Container adjustments */
        .container {
            padding-left: 5px;
            padding-right: 15px;
            max-width: none;
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        /* Row adjustments */
        .row {
            margin-left: 0;
            margin-right: 0;
        }

        /* Column adjustments */
        [class*="col-"] {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                left: 15%;
            }
            
            .content-area {
                margin-left: 0;
            }

            footer {
                width: 100%;
                margin-left: 0;
            }

            #music-player {
                margin-left: 0;
                width: 100%;
            }

            .about-section {
                flex-direction: column;
                text-align: center;
            }

            .about-text, .about-img {
                max-width: 100%;
                margin: 20px 0;
                padding-right: 0;
            }

            
           
        }
    </style>

</head>
<body>
    
    <div class="main-content">
        <div class="content-area">
            <!-- Hero Section -->
            <div class="hero">
                <h1>Welcome to void</h1>
                <p>Where music knows no boundaries! We bring together artists from all backgrounds, genres, and cultures to create a truly diverse and inspiring music experience. Whether you're here to discover fresh talent or relive classic hits, we’ve got something for everyone. 🎶</p>
            </div>

            <!-- About Section -->
            <div class="container about-section">
                <div class="about-text">
                    <h2>Our Story</h2>
                    <p>Music has the power to connect, inspire, and transform lives. That’s why we created void—a space where artists can share their creativity and listeners can discover amazing music without limits.</p>

                    <p>Our journey started with one goal: to make music accessible and enjoyable for all. We believe that every artist deserves a stage, and every listener deserves an unforgettable experience. Join us as we continue to amplify voices, celebrate diversity, and redefine music streaming.</p>
                </div>
                <img src="your-image.jpg" alt="Music Studio" class="about-img">
            </div>

            <!-- Features Section -->
            <div class="features">
                <h2 class="text-light">What Makes Us Unique?</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="feature-box">
                                <h3>🎵 High-Quality Streaming</h3>
                                <p>Experience crystal-clear sound that brings every note to life—whether you’re at home or on the go.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-box">
                                <h3>🔥 Curated Playlists</h3>
                                <p>Handpicked collections crafted by music lovers, for music lovers. Discover songs that match your vibe.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-box">
                                <h3>🚀 Ad-Free Experience</h3>
                                <p>Enjoy your favorite tracks without interruptions. Immerse yourself in the music—no ads, no distractions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta" style="">
                <h2>Meet the Founders</h2>
                    <p>   Behind void is a team of <strong>three passionate music lovers</strong> who came together with a shared vision: <em>to build a platform where music is limitless, diverse, and accessible to everyone.</em></p>
                    
                    <h3> Tannu Waghmare – The Visionary</h3>
                    <p>A lifelong music enthusiast and creative force, Tannu Waghmare dreamed of building a platform that puts both mainstream and emerging artists in the spotlight. Her passion for sound, storytelling, and innovation is at the heart of everything we do.</p>
                    
                    <h3> Soham Thummar – The Tech Architect</h3>
                    <p>With a background in technology and a love for smooth user experiences, Soham Thummar brought the platform to life. He ensures that the streaming is seamless, the interface is intuitive, and the magic of music is just a tap away.</p>
                    
                    <h3> Dushyant Dangar – The Music Curator</h3>
                    <p>A true audiophile, Dushyant Dangar is always on the hunt for fresh talent and unique sounds. He leads our curation team, crafting playlists and recommendations that <strong>match every vibe, mood, and moment.</strong></p>
                    
                    <h4>🎯 Our Mission:</h4>
                    <p>To create a space where <strong>music discovery is exciting, artists are supported, and listeners always find their next favorite song.</strong></p>
                    
                    <h4>🌍 Our Vision:</h4>
                    <p>A world where music brings people together, no matter their background, genre preference, or location.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2025 void. All Rights Reserved.</p>
        </footer>
        <br>
        <br>
        <br>
    </div>
</body>
</html>
