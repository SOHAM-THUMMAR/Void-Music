<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.3s ease;
            padding: 10px;
        }
        .like-btn .fa-heart {
            color: #aaa;
            transition: color 0.3s ease;
        }
        .like-btn.liked .fa-heart {
            color: #DC143C;
        }
    </style>
</head>
<body>
    <button class="like-btn" onclick="likeSong(1, event)">
        <i class="fas fa-heart"></i>
    </button>
    <script>
        function likeSong(songId, event) {
            event.stopPropagation();
            const btn = event.currentTarget;
            const heartIcon = btn.querySelector('.fa-heart');
            btn.classList.toggle('liked');
            heartIcon.style.color = btn.classList.contains('liked') ? '#DC143C' : '#aaa';
            btn.offsetHeight; // Force repaint
        }
    </script>
</body>
</html>