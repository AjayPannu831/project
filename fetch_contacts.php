<?php
session_start(); // Start the session
require './conponent/_connect.php'; // Include your database connection script

$contacts = [];

if (isset($_SESSION['logged_in_id'])) {
    $id = $_SESSION['logged_in_id'];
    $sql = "SELECT * FROM `contact` WHERE `user_id` = '$id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $contacts[] = $row;
    }
}

// Output data or error message for debugging
if (!empty($contacts)) {
    echo json_encode($contacts);
} else {
    echo json_encode(["message" => "No contacts found."]);
}
?>
