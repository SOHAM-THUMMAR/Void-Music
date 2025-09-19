<?php include_once 'includes/config.php';
$id = $_GET['id'];

$sqldelete = "DELETE FROM artist_songs WHERE id='$id'";

if ($con->query($sqldelete) === TRUE) {
    header("Location: manage_artist(main_page).php");
} else {
    echo "Error deleting record: " . $con->error;
}
?>