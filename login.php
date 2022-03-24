<?php
// Connecting to the Database
$host = "host=127.0.0.1";
$port = "port=5432";
$dbname = "dbname=projecttest";
$cred = "user=postgres password=postgres";

// Create a connection
$conn = pg_connect( "$host $port $dbname $cred" );

// Die if connection was not successful
if ( !$conn ) {
    die( "<br><mark>Sorry we failed to connect: Database Connection Error</mark>" );
}

// Store Post Variables
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];

// Compare SQL Query
$sql = "SELECT * FROM emplogin WHERE email LIKE '$email'";
$result = pg_query($conn, $sql);
if ($row = pg_fetch_assoc($result)){
if($email == $row['email'] && $password == $row['password']){
    session_start();
    $_SESSION['dept'] = $row['dept'];
    // Redirect
    header("Location: ./main.php");
    exit;
}
else{
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Wrong Password
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}


}


else{
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Wrong Email
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    
}
    
}

?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
        <style>
        body {
            background-image: url("employee-bg.jpg");
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
        }

    </style>

    <title>Government Complaint Portal</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img src="./images/top_logo.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
            </a>
            <a class="navbar-brand" href="./index.php">Government Complaint Portal</a>
            <button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./check_status.php">Check Complaint Status</a>
                    </li>
                </ul>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle border border-dark" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        Login
                    </button>
                    <ul class="dropdown-menu dropdown-menu-lg-end">
                        <li><a class="dropdown-item" href="#">Employee Login</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="./adminlogin.php">Admin Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


<br>
    <div class="container my-5 col-lg-6 bg-info text-dark"><b>
        <h1><br>
            <center><u>Employee Login</u></center>
        </h1><br>
        <form method="POST" action="./login.php">
            <div class="mb-4">
                <h3><label for="exampleInputEmail" class="form-label">Email address</label></h3>
                <input type="email" class="form-control" id="Email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-4">
                <h3><label for="exampleInputPassword1" class="form-label">Password</label></h3>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div><br>
            <center><button type="submit" class="btn btn-primary">Submit</button></center>
        </form>
        <br><br></b>

    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>
