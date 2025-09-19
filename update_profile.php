<?php
require_once 'includes/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($email)) {
        die("Name and Email are required.");
    }

    $profilePicName = null;

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExt, $allowedExts)) {
            die("Invalid image format. Allowed: jpg, jpeg, png, gif.");
        }

        $profilePicName = 'user' . $id . '_avatar.' . $fileExt;
        $destPath = 'uploads/' . $profilePicName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            die("Failed to upload image.");
        }
    }

    if ($profilePicName) {
        $stmt = $con->prepare("UPDATE users SET name = ?, email = ?, profile_pic = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $profilePicName, $id);
    } else {
        $stmt = $con->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully.";
        header("Location: main.php");
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
