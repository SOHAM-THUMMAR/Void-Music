<?php include_once 'includes/config.php';
$id = $_GET['id'];

$sqldelete = "DELETE FROM contact_us WHERE id='$id'";

if ($con->query($sqldelete) === TRUE) {
    header("Location: contacted.php");
} else {
    echo "Error deleting record: " . $con->error;
}
?>