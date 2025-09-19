<?php
session_start();
require 'includes/config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || strlen($name) < 3) {
        $_SESSION['contact_error'] = "Name must be at least 3 characters long.";
        header("Location: contact.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_error'] = "Invalid email address.";
        header("Location: contact.php");
        exit();
    }
    if (empty($message) || strlen($message) < 10) {
        $_SESSION['contact_error'] = "Message must be at least 10 characters long.";
        header("Location: contact.php");
        exit();
    }

    // Insert into database
    if (isset($con)) {
        $stmt = $con->prepare("INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $_SESSION['contact_success'] = "Message sent successfully!";
        } else {
            $_SESSION['contact_error'] = "Failed to send message. Please try again.";
        }
        $stmt->close();
    }
    
    $con->close();
    header("Location: contact.php");
    exit();
} else {
    $_SESSION['contact_error'] = "Invalid request.";
    header("Location: contact.php");
    exit();
}