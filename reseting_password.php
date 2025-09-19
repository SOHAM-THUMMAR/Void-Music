<?php
require "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    $message = '';
    $message_class = '';

    if ($password !== $confirm) {
        $message = "Passwords do not match!";
        $message_class = "error-message";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
        $message_class = "error-message";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $update = $con->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hashed, $email);

        if ($update->execute()) {
            $message = "Password updated successfully!";
            $message_class = "success-message";
        } else {
            $message = "Failed to update password!";
            $message_class = "error-message";
        }
        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #1C1C1C, #2C2C2C);
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #F5F5F5;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.05);
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            border: 1px solid #2C2C2C;
            display: flex;
            flex-direction: column;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
        }

        label {
            font-size: 14px;
            margin-bottom: 6px;
            color: #ddd;
        }

        input[type="email"],
        input[type="password"] {
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            background-color: #2C2C2C;
            color: #fff;
            font-size: 14px;
            margin-bottom: 20px;
            width: 100%;
            transition: 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            background-color: #333;
            border: 1px solid #DC143C;
            box-shadow: 0 0 8px rgba(220, 20, 60, 0.4);
        }

        input[type="submit"],
        .login-btn {
            padding: 12px;
            border: none;
            border-radius: 10px;
            background-color: #DC143C;
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        input[type="submit"]:hover,
        .login-btn:hover {
            background-color: #a80f30;
        }

        .back-link {
            margin-top: 15px;
            text-align: center;
            color: #DC143C;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Reset Password</h2>
        <?php if (!empty($message)): ?>
            <div class="<?= $message_class ?>"><?= $message ?></div>
        <?php endif; ?>
        
        
        <?php if (!empty($message) && strpos($message, 'success') !== false): ?>
            <div class="form-footer">
                <a href="login.php" class="login-btn">Login here</a>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>
