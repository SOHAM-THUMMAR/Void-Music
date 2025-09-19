<?php include_once 'includes/config.php';
$id = $_GET['id'];

$sqldelete = "DELETE FROM users WHERE id='$id'";

if ($con->query($sqldelete) === TRUE) {
    header("Location: admin.php");
} else {
    echo "Error deleting record: " . $con->error;
}
?>