<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust this if your PHPMailer path is different

session_start();
include("includes/config.php");

if (isset($_POST['send'])) {
    $email = trim($_POST['email']);

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format.";
        header("Location: forgot-password.php");
        exit();
    }

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $mail = new PHPMailer(true);

        try {
            // SMTP config
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'skillskull001@gmail.com'; // Your email
            $mail->Password = 'wcpm mmhl emrq qdve'; // Use App Password, not real password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('skillskull001@gmail.com', 'Void'); // Sender
            $mail->addAddress($email); // Recipient
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = '
                <h3>Password Reset</h3>
                <p>Click the link below to reset your password:</p>
                <a href="http://localhost/c2/CIE!%202.25PM/reset_password.php?email=' . urlencode($email) . '">Reset Password</a>
            ';

            $mail->send();

            $_SESSION['signup_success'] = "Reset link sent to your email.";
            header("Location: forgot-password.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['signup_error'] = "Mail sending failed: {$mail->ErrorInfo}";
            header("Location: forgot-password.php");
            exit();
        }
    } else {
        $_SESSION['signup_error'] = "No user found with this email.";
        header("Location: forgot-password.php");
        exit();
    }
}
?>
