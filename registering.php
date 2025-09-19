<?php
session_start();
require "includes/config.php";
$error = $success = '';
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signup']))
{
    $username = trim($_POST['name']);
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['c_pass'];
    if($password !== $confirm_password){
        $error = "password does not match";
    }
    else{
        $query = $con->prepare("SELECT id FROM users WHERE email=?");
        $query->bind_param('s',$email);
        $query->execute();
        $query->store_result();
        if ($query->num_rows > 0){
            $error = "account on this email already exist";
            header('location: register.php');
        }
        else{
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $insert = $con->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $insert -> bind_param('sss',$username,$email,$hashed_password);
            if($insert->execute()){
                $success = "sign up successful! you can now <a href=login.php>sign in </a>";
                header('location: login.php');
            }
            else{
                $error = 'an error occured, please try again.';
                header('location: register.php');

            }
            $insert->close();
        }
        $query->close();
    }
    $con->close();

    $_SESSION['signup_error'] = $error;
    $_SESSION['signup_success'] = $success;

    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>registered</title>
</head>
<body>
  <h1>regidtration is done</h1>
</body>
</html>