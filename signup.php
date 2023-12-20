<?php 
$showAlert = false;
$showError = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require './conponent/_connect.php';
    // include './validation.php';
   
 $errors = array();

 // Validate the 'name' field
 if (empty($_POST["username"])) {
     $errors["username"] = "Name is required.";
 } elseif (!preg_match("/^[A-Za-z ]+$/", $_POST["username"])) {
     $errors["username"] = "Name should only contain letters or spaces.";
 }

 // Validate the 'email' field
 if (empty($_POST["email"])) {
     $errors["email"] = "Email is required.";
 } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
     $errors["email"] = "Invalid email format.";
 }

 // Validate the 'phone' field
 if (empty($_POST["phone"])) {
     $errors["phone"] = "Phone number is required.";
 } elseif (!preg_match("/^[0-9]{10}$/", $_POST["phone"])) {
     $errors["phone"] = "Phone number should be a 10-digit number.";
 }

 // Validate the 'password' field
 if (empty($_POST["password"])) {
     $errors["password"] = "Password is required.";
 } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,}$/", $_POST["password"])) {
     $errors["password"] = "Password must be at least 6 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
 }

 if (empty($errors)) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if the email already exists
    $existuser = "SELECT * FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $existuser);
    $existnum = mysqli_num_rows($result);

    if($existnum > 0){
        $showError = "User already exists with this email";
    }
    else {
        if($password == $cpassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Image upload handling
            $image = $_FILES['image']['name'];
            $target = "uploads/" . basename($image);

            // Move the uploaded image to the 'uploads' directory
            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $sql = "INSERT INTO `user` (`name`, `email`, `phone`, `password`, `image`) VALUES ('$username', '$email', '$phone', '$hash', '$target')";
            $result = mysqli_query($conn, $sql);

            if($result){
                $showAlert = true;
            }
        }
        else {
            $showError = "Passwords do not match";
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
    <title>Sign Up</title>
  </head>
  <body>
    <?php require './conponent/_nav.php'; ?>
    <?php 
        if($showAlert){
            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Successful!</strong> Sign Up complete, Please Login to continue...
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        if($showError){
            echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    ?>
    <div class="container">
        <h1 class="text-center">Sign Up </h1>
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="mb-3">
                <label for="username" class="form-label">Name</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" >  <?php if (isset($errors["username"])) echo "<p class='text-danger'>" . $errors["username"] . "</p>"; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" >
                <?php if (isset($errors["email"])){ echo "<p class='text-danger'>" . $errors["email"] . "</p>"; }?>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Mobile No.</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                <?php if (isset($errors["phone"])) echo "<p class='text-danger'>" . $errors["phone"] . "</p>"; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <?php if (isset($errors["password"])) echo "<p class='text-danger'>" . $errors["password"] . "</p>"; ?>
               
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword">
                <div id="emailHelp" class="form-text">Both passwords must be the same.</div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>  
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
