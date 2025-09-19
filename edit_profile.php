<?php
require_once 'includes/config.php';
session_start();

// Assuming user ID is stored in session
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    die("User not logged in.");
}

$stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        body {
            background: #0a0a0a;
            color: #F5F5F5;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.05);
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(255, 20, 60, 0.2);
        }

        h2 {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 35px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.97rem;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 13px 16px;
            font-size: 1rem;
            color: #F5F5F5;
            background: #2C2C2C;
            border: none;
            border-radius: 10px;
            transition: background 0.2s ease;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            background: #3a3a3a;
        }

        input[readonly] {
            background: #1C1C1C;
            color: #999;
        }

        .button {
            width: 100%;
            margin-top: 15px;
            padding: 14px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(45deg, #DC143C, #800020);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .button:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 18px rgba(255, 20, 60, 0.35);
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 35px;
            border: 3px solid #3a3a3a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .success {
            text-align: center;
            color: #32CD32;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <img src="uploads/<?php echo $user['profile_pic'] ?? 'default.jpg'; ?>" class="avatar-preview" alt="Profile Picture">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="profile_pic">Change Profile Picture:</label>
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
            </div>

            <div class="form-group">
                <label for="created_at">Account Created:</label>
                <input type="text" id="created_at" name="created_at" value="<?php echo $user['created_at']; ?>" readonly>
            </div>

            <button type="submit" class="button">Save Changes</button>
        </form>
    </div>
</body>
</html>
