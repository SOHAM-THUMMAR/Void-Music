<?php
session_start();
require "includes/config.php";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO admins (name, email, password, created_at) 
                VALUES (?, ?, ?, NOW())";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Admin registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$con->close();
?>

<!-- Simple Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>

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

        .register-container {
            background-color: #2c2c2c; /* Deep Maroon */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px black; /* Gunmetal Gray */
            width: 300px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 20px;
        }

        .register-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 92.5%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #2C2C2C;
            border-radius: 5px;
            background-color: #1C1C1C;
            color: #F5F5F5;
        }

        .register-container button {
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

        .register-container button:hover {
            background-color: #a50f2a; /* Darker Crimson */
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register Admin</h2>
        <form method="POST" action="">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
