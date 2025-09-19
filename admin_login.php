<?php
session_start();
require "includes/config.php";
// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Basic validation
    if (empty($email) || empty($password)) {
        echo "Both fields are required!";
    } else {
        // Check if email exists
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password'])) {
                // Set session variables
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                // Redirect to admin page
                header("Location: admin.php");
                exit;
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "No admin found with this email!";
        }

        $stmt->close();
    }
}

$con->close();
?>

<!-- Simple Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <!-- CSS Styles -->
    <style>
        body {
            background-color: #1C1C1C; /* Charcoal Black */
            color: #F5F5F5; /* Off-white Text */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #2c2c2c; /* Deep Maroon */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px black; /* Gunmetal Gray */
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 92.5%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #2C2C2C;
            border-radius: 5px;
            background-color: #1C1C1C;
            color: #F5F5F5;
        }

        .login-container button {
            background-color: #DC143C; /* Crimson Red */
            color: #F5F5F5;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .login-container button:hover {
            background-color: #a50f2a; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
