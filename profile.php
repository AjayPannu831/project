<?php
// $confirmPassword = false;
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: login.php");
  exit;
}
require './conponent/_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_SESSION['useremail'];

  // Handle image upload (as before)
  if (isset($_FILES['image'])) {
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    $allowed = array("image/jpeg", "image/jpg", "image/png");
    if (in_array($file_type, $allowed)) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($file_name);

      if (move_uploaded_file($file_tmp, $target_file)) {
        $sql = "UPDATE `user` SET image = '$target_file' WHERE email = '$email'";
        mysqli_query($conn, $sql);
      }
    }
  }



  // Check if the user wants to update the name
  if (!empty($_POST['name'])) {
    $newName = $_POST['name'];
    $sql = "UPDATE `user` SET name = '$newName' WHERE email = '$email'";
    mysqli_query($conn, $sql);
    $_SESSION['username'] = $newName; // Update the session variable
  }
  // Check if the user wants to update the email
  // Check if the user wants to update the email
  if (!empty($_POST['email'])) {
    $newEmail = $_POST['email'];

    // Ensure the new email is unique
    $sql = "SELECT email FROM `user` WHERE email = '$newEmail'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Email already exists. Please choose a different email.')</script>";
    } else {
      if ($newEmail != $_SESSION['useremail']) {
        // Email is unique, and it's different from the current email
        $sql = "UPDATE `user` SET email = '$newEmail' WHERE email = '$email'";
        mysqli_query($conn, $sql);
        $_SESSION['useremail'] = $newEmail; // Update the session variable
        echo "<script>alert('Email updated successfully.')</script>";
      } else {
        echo "<script>alert('New email is the same as the current email. No changes were made.')</script>";
      }
    }
  }



  // Check if the user wants to update the phone
  if (!empty($_POST['phone'])) {
    $newPhone = $_POST['phone'];
    $sql = "UPDATE `user` SET phone = '$newPhone' WHERE email = '$email'";
    mysqli_query($conn, $sql);
    $_SESSION['phone'] = $newPhone; // Update the session variable
  }

  // Check if the user wants to update the password

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
          mysqli_query($conn, $sql);
          if(mysqli_query($conn, $sql)){
          echo "<script>alert('Password updated successfully.')</script>";
          
        } else {
          echo "<script>alert('New password and confirm password do not match. Password not updated.')</script>";
        }
      } else {
        echo "<script>alert('Old password is incorrect. Password not updated.')</script>";
      }
    }
  }
}
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <title>Profile</title>
  <style>
    #pro {
      display: none;
      /* Initially hide the profile form */
    }

    #prof {
      display: none;
      /* Initially hide the profile form */
    }
  </style>
</head>

<body>
  <?php require './conponent/_nav.php'; ?>
<div class="profile">
  <div class="container mt-5" id="photo">
    <?php
    $email = $_SESSION['useremail'];
    $sql = "SELECT * FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);
    if ($num > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="row">
                <div class="col-md-12 mb-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <img src="' . $row['image'] . '" alt="Profile Image"
                        style="max-width: 150px; max-height: 150px; border: 1px solid #ccc; border-radius: 50%;">
                      <h5 class="card-title">Name: ' . $row['name'] . '</h5>
                      <p class="card-text">Email: ' . $row['email'] . '</p>
                      <p class="card-text">Phone: ' . $row['phone'] . '</p>
                    </div>
                  </div>
                </div>
              </div>';
      }
    }
    ?>
  </div>
  <div class="container">
    <button id="profile" class="btn btn-primary">Update Profile</button>
    <button id="profi" class="btn btn-primary float-end">Update Password</button>
  </div><br>
  <!-- <button  class="btn btn-primary">hide</button> -->

  <div class="container mt-3" id="prof">
    <h2>Update Profile</h2><br>
    <form action="profile.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="image" class="form-label">Profile Image</label>
        <input type="file" class="form-control" id="image" name="image">
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['username']; ?>">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['useremail']; ?>">
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>">
      </div>

      <button type="submit" class="btn btn-primary">Update Profile</button><br><br>
    </form>
  </div>

  <div class="container mt-3" id="pro">
    <h2>Update Password</h2><br>


    <!-- Password Update Section -->


    <form action="profile.php" method="post" enctype="multipart/form-data">

      <div class="mb-3 mt-3">
        <label for="oldPassword" class="form-label">Old Password (required to change password)</label>
        <input type="password" class="form-control" id="oldPassword" name="oldPassword">
      </div>

      <div class="mb-3">
        <label for="newPassword" class="form-label">New Password</label>
        <input type="password" class="form-control" id="newPassword" name="newPassword">
      </div>

      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
      </div>
      <?php
   
      ?>
      <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
  </div><br>
  </div>


  <script>
    $(document).ready(function() {
      $('#profile').click(function() {
        $('#prof').toggle();
      });
      $('#profi').click(function() {
        $('#pro').toggle();
      });
    });
  </script>


</body>

</html>