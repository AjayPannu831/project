<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
require './conponent/_connect.php';





?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Include jQuery and Bootstrap scripts before your custom script -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  

  <title>profile</title>
</head>

<body>
  <?php require './conponent/_nav.php'; ?>

  <div class="container mt-5">
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

  <div class="container mt-3">
    <h2>Update Password</h2><br>

    <!-- Password Update Section -->
    <form id="password-form" method="post" enctype="multipart/form-data">
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
      <div id="loader" style="display: none;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <!-- Add a div for displaying the confirmation message -->
      <div id="confirmation-message" style="display: none;" class="alert alert-success">
        Password updated successfully.
      </div>

      <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
  </div><br>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
  const passwordForm = document.getElementById("password-form"); // Assuming you have an ID on your form
  const loader = document.getElementById("loader");
  const confirmationMessage = document.getElementById("confirmation-message");

  passwordForm.addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Show the loader
    loader.style.display = "block";

    const formData = new FormData(passwordForm);

    fetch("update_password.php", {
      method: "POST",
      body: formData,
    })
      .then(response => response.text())
      .then(data => {
        // Handle the response from the server
        console.log(data); // For debugging, you can remove this in production

        // Hide the loader
        loader.style.display = "none";

        if (data === "Password updated successfully.") {
          // Show the confirmation message
          confirmationMessage.style.display = "block";
        }
        else { // Add this condition
          // Show the error message for password mismatch
          errorMessage.style.display = "block";
          confirmationMessage.style.display = "none"; // Hide confirmation message
        }
      })
      .catch(error => {
        console.error("An error occurred: " + error);
        // Hide the loader in case of an error
        loader.style.display = "none";
      });
  });
});

  </script>
</body>
</html>