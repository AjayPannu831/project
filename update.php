<!-- update.php -->

<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
  }


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require './conponent/_connect.php';

    $userid = $_SESSION['logged_in_id'];
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
 

    // Update the record in the database
    $sql = "UPDATE `contact` SET `Name`='$username', `Email`='$email', `Phone`='$phone', `Address`='$address' WHERE `id`='$id'";
    $result = mysqli_query($conn,$sql);

    if ($result) {
        
        
         // Redirect back to the table view after successful update -->
        
         echo "<script>confirm('Data updated successfully.');</script>";
         echo "<script>window.location.href='contactlist.php';</script>";
    
    } 
    
    else {
        // Handle errors if the update fails
    
        echo "Error updating record: " . mysqli_error($conn);
    }

    
}

// If the form is not submitted or there's an error in the update, fetch the data and display the form
if (isset($_GET['id'])) {
    require './conponent/_connect.php';


    $id = $_GET['id'];

    // Fetch the existing data for the given ID
    $sql = "SELECT * FROM `contact` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['Name'];
        $email = $row['Email'];
        $phone = $row['Phone'];
        $address = $row['Address'];
    } else {
        // Handle if the record is not found
        echo "Record not found.";
        
    }

    
} else {
    // Handle if the ID is not provided in the URL
    echo "Invalid request.";
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">

    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
        </div>
        <button type="submit" class="btn btn-primary" >Update</button>
    </form>
</div>
</body>
</html>
