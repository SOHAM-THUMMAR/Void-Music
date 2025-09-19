<?php
session_start();
require 'includes/config.php'; // Include DB connection

$error = ""; // Default error message

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);

    if (!empty($email) && !empty($password)) {
        if (isset($con)) {
            $stmt = $con->prepare("SELECT id, password FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['email'] = $email;
                    header("Location: main.php"); // Redirect to main dashboard
                    exit();
                } else {
                    $error = "Incorrect password!";
                }
            } else {
                $error = "Email not found!";
            }
            $stmt->close();
        }
    } else {
        $error = "All fields are required!";
    }
}

$_SESSION['signin_error'] = $error;
header("Location: login.php"); // Redirect back to login
exit();
?>
