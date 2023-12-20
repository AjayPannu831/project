<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
require './conponent/_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_SESSION['useremail'];

  if (!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the old password matches the one in the database
    $sql = "SELECT password FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($oldPassword, $row['password'])) {
        // Old password matches
        if ($newPassword === $confirmPassword) {
          // New password and confirm password match
          $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
          $sql = "UPDATE `user` SET password = '$newPasswordHash' WHERE email = '$email'";
          $query = mysqli_query($conn, $sql);
          if ($query) {
            echo "Password updated successfully.";
          }
        } else {
            echo "Password not matched.";
          }
      } else {
        echo "Password not matched.";
      }
    }
  }
}
