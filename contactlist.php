<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


    <title>Contact list</title>
</head>

<body>
    <?php
    session_start();
    require './conponent/_nav.php';
    require './conponent/_connect.php';
    ?>

    <!-- <center><button id="button" class="btn btn-primary">contactlist</button></center> -->
    <div class="container">
        <h1 id="" class="text-center">Contact List</h1>
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
            <tbody id="contactListBody">
                <?php
                require './conponent/_connect.php';
                $id =  $_SESSION['logged_in_id'];

                $sql = "SELECT * FROM `contact` WHERE `user_id` = '$id'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ) {
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                        <tr>
                            <th scope="row">
                                <?php echo $row['id'] ?>
                            </th>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php echo $row['Email'] ?></td>
                            <td><?php echo $row['Phone'] ?></td>
                            <td><?php echo $row['Address'] ?></td>
                            <td>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">update</a>&nbsp;
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">delete</a>
                            </td>

                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- <script>
                    $(document).ready(function() {
                        $('#contactListLink').click(function(e) {
                            e.preventDefault(); // Prevent the link from navigating

                            // Use jQuery to make an AJAX request to fetch contact data from the server.
                            $.ajax({
                                url: 'fetch_contacts.php',
                                type: 'POST', // Change to GET to match your fetch_contacts.php
                                dataType: 'json',
                                success: function(data) {
                                    if (data.length > 0) {
                                        var contactListHTML = '';
                                        for (var i = 0; i < data.length; i++) {
                                            contactListHTML += '<tr>';
                                            contactListHTML += '<th scope="row">' + data[i].id + '</th>';
                                            contactListHTML += '<td>' + data[i].Name + '</td>';
                                            contactListHTML += '<td>' + data[i].Email + '</td>';
                                            contactListHTML += '<td>' + data[i].Phone + '</td>';
                                            contactListHTML += '<td>' + data[i].Address + '</td>';
                                            contactListHTML += '<td><a href="./update.php?id=' + data[i].id + '" class="btn btn-warning">Update</a>';
                                            contactListHTML += '<a href="./delete.php?id=' + data[i].id + '" class="btn btn-danger">Delete</a></td>';
                                            contactListHTML += '</tr>';
                                        }
                                        $('#contactListBody').html(contactListHTML);
                                    } else {
                                        $('#contactListBody').html('<tr><td colspan="6">No contacts found.</td></tr>');
                                    }
                                },
                                error: function() {
                                    $('#contactListBody').html('<tr><td colspan="6">An error occurred while fetching data.</td></tr>');
                                }
                            })
                        })
                    })
                </script> -->

    </tbody>
    </table>
    </div>


</body>

</html>