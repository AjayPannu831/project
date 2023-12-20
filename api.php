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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <title>Contact list</title>
</head>

<body>
    <?php require './conponent/_nav.php'; ?>
    <div id="contactList"></div>


    <div class="container">
        <h1 class="text-center">Contact List</h1>
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $id = $_SESSION['logged_in_id'];
                $sql = "SELECT * FROM `contact` WHERE `user_id` = '$id'";
                $result = mysqli_query($conn, $sql);

                $num = mysqli_num_rows($result);
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <th scope='row'><?php echo $row['id']; ?></th>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['Phone']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><a href='./update.php?id=<?php echo $row['id']; ?>' class="btn btn-warning">Update</a>&nbsp;
                                <a href="./delete.php?id=<?php echo $row['id']; ?>" class='btn btn-danger'>Delete</a>
                            </td>
                            </td>


                        </tr>
                <?php }
                }

                ?>

            </tbody>
        </table>
    </div>

</body>

</html>