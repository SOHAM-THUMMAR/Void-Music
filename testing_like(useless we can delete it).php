<?php
session_start();
require "includes/config.php";

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "Not logged in. Please <a href='login.php'>login</a> first.";
    exit;
}

// Get user info
$query = $con->prepare("SELECT id, name FROM users WHERE email = ?");
$query->bind_param('s', $_SESSION['email']);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Like Button Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .test-song {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            color: #aaa;
            transition: all 0.3s ease;
        }
        .like-btn:hover {
            transform: scale(1.1);
        }
        .like-btn.liked {
            color: red;
        }
        .song-info {
            flex-grow: 1;
        }
        .song-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .artist-name {
            color: #666;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Like Button Test</h1>
        <p>Hello, <?php echo htmlspecialchars($user['name']); ?>! This is a test page for the like button functionality.</p>
        
        <div class="test-song">
            <div class="song-info">
                <div class="song-name">Test Song 1</div>
                <div class="artist-name">Test Artist</div>
            </div>
            <button class="like-btn" data-song-id="1" data-song-type="test">
                <i class="fas fa-heart"></i>
            </button>
        </div>
        
        <div class="test-song">
            <div class="song-info">
                <div class="song-name">Test Song 2</div>
                <div class="artist-name">Another Artist</div>
            </div>
            <button class="like-btn" data-song-id="2" data-song-type="test">
                <i class="fas fa-heart"></i>
            </button>
        </div>
        
        <div id="status" class="status"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, setting up test like buttons');
        
        // Get all like buttons
        const likeButtons = document.querySelectorAll('.like-btn');
        
        // Add event listeners
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Test like button clicked!');
                
                const songId = this.getAttribute('data-song-id');
                const songType = this.getAttribute('data-song-type');
                const button = this;
                
                // Show visual feedback
                button.style.opacity = '0.5';
                
                // Status display
                const statusElement = document.getElementById('status');
                statusElement.style.display = 'block';
                statusElement.innerHTML = 'Processing...';
                statusElement.className = 'status';
                
                fetch('like_song.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `song_id=${songId}&song_type=${songType}`
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    button.style.opacity = '1';
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.status === 'liked') {
                        button.classList.add('liked');
                        statusElement.innerHTML = 'Song liked successfully!';
                        statusElement.className = 'status success';
                    } else if (data.status === 'unliked') {
                        button.classList.remove('liked');
                        statusElement.innerHTML = 'Song unliked successfully!';
                        statusElement.className = 'status success';
                    } else if (data.error) {
                        statusElement.innerHTML = 'Error: ' + data.error;
                        statusElement.className = 'status error';
                    }
                })
                .catch(err => {
                    button.style.opacity = '1';
                    statusElement.innerHTML = 'Error: ' + err.message;
                    statusElement.className = 'status error';
                    console.error('Error:', err);
                });
            });
        });
    });
    </script>
</body>
</html>