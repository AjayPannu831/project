<?php
$login = false;
$showError = false;
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
require './conponent/_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require './conponent/_connect.php';
    $userid = $_SESSION['logged_in_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    //query
    $sql = "INSERT INTO `contact`(`user_id`,`Name`, `Email`, `Phone`, `Address`) VALUES ('$userid','$username','$email','$phone','$address')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // echo '<script>alert("Contact Added")</script>';
        // header('location: contactlist.php');

        // echo "<script>confirm('Contact added successfully.');</script>";
        $login = true;
        // echo "<script>window.location.href='contactlist.php';</script>";
    } else {
        $showError = true;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Add Contact</title>
</head>

<body>
    <?php require './conponent/_nav.php';

    // if ($login) {
    //     echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
    //     <strong>Successfull!</strong> Contact added successfull!...
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //   </div>';
    // }
    if ($showError) {
        echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container" id="addContactContent">
        <h1 class="text-center">Add Contact</h1>
        <form action="" method="post">
            <!-- <div class="mb-3">
                <input type="hidden" class="form-control" id="username" name="userid" value="" Required>
            </div> -->
            <div class="mb-3">
                <label for="username" class="form-label ">Name</label>
                <input type="text" class="form-control" id="username" name="username" Required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label ">Email</label>
                <input type="email" class="form-control" id="email" name="email" Required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label ">Mobile No.</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label ">Address</label>
                <textarea type="text" class="form-control" name="address" Required></textarea>
            </div>
            <?php
            if ($login) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfull!</strong> Contact added successfull!...
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            } ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>