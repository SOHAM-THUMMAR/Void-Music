<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

    input[type="submit"] {
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

    input[type="submit"]:hover {
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

    form {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>
<body>

    <div class="form-container">
        <h2>Reset Password</h2>
        <form method="POST" action="reseting_password.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <input type="submit" value="Reset Password">
        </form>

        <div class="form-footer">
            <p>Remembered your password? <a href="login.php" class="back-link">Login here</a></p>
        </div>
    </div>

</body>
</html>
