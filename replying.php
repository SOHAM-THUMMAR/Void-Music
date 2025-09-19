




<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $reply = $_POST['reply'];
    $id = $_POST['id'];
    $query = $con->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param('s', $email);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $name = $row['name'];

    // Update reply in database
    $stmt = $con->prepare("UPDATE contact_us SET reply = ?, replied_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $reply, $id);
    $stmt->execute();

    // Send Email
  // Send Email
$mail = new PHPMailer(true);  // Renamed from $email to $mail
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'skillskull001@gmail.com';
    $mail->Password = 'sghv utbc okmz ouhm';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('skillskull001@gmail.com', 'Void');
    $mail->addAddress($_POST['email']);  // Now using the correct recipient

    $mail->isHTML(true);
    $mail->Subject = "Reply to Your Message";
    $mail->Body = "<p>Dear $name,</p><p>$reply</p><p>Best Regards,<br>void</p>";

    $mail->send();
    echo "Reply sent successfully!";
    header("Location: contacted.php");

} catch (Exception $e) {
    echo "Error sending email: " . $mail->ErrorInfo;
}

}
?>
