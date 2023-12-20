
<!-- delete.php -->

<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
  }
    require './conponent/_connect.php';


// Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the record from the database
    $sql = "DELETE FROM `contact` WHERE `id`='$id'";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the record page after successful deletion

        echo '<script>confirm("delete_record");</script>';
        echo '<script>window.location.href="contactlist.php";</script>';
        
    } else {
        // Handle errors if the deletion fails
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // Handle if the ID is not provided in the URL
    echo "Invalid request.";
}
?>


