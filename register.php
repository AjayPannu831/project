<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <form method="post">
            <center>
                <h1>Register</h1>
            </center>
            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" name='name'>
            </div>
            <div class="mb-3">
                <label  class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name='email' aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>Make two view file first user.php and second admin.php to redirect after login if user role is admin alse use.
In php with MySQL code with login using email and password with users table also implemented session.
