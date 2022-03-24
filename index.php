<?php

$insert = false;
session_start();
session_unset();
session_destroy();
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
    if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
    $name = $_POST["name"];
    $mobile = $_POST["mobile"];
    $addr = $_POST["addr"];
    $dept = $_POST["dept"];
    $description = $_POST["description"];
    $photos = $_POST["photos"];
        
    // Compare SQL Query
    $sql = "INSERT INTO complaint ( name, mobile, addr, dept, description, photos, dateofcomp, dateofapp, status ) VALUES ( '$name', '$mobile', '$addr', '$dept', '$description', '$photos', CURRENT_DATE, NULL, 'unassigned' )";
    $result = pg_query( $conn, $sql );
        

    if ( $result ) {

        $insert = true;
    } 
    else {
        echo "The record was not inserted successfully";
    }
    }
if ( $insert ) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Complaint has been Registered successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
    </button>
  </div>";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("homee-bg.jpg");
            background-position: center;
            background-size: cover;
            width: 100%;
            height: 100vh;
        }

    </style>


    <title>Government Complaint Portal</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./images/top_logo.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
            </a>
            <a class="navbar-brand" href="#">Government Complaint Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
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
                        <li><a class="dropdown-item" href="./login.php">Employee Login</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="./adminlogin.php">Admin Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h2><u>Register Your Complaint</u></h2><br>
        <form method="POST" action="./index.php">
            <div class="row mb-3">
                <div class="col">
                    <label for="inputAddress" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Name">
                </div>
                <div class="col">
                    <label for="inputAddress" class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" name="mobile" placeholder="Mobile Number" aria-label="Phone" pattern="[0-9]{10}">
                </div>
            </div>
            <div class="mb-3">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" name="addr" id="inputAddress" placeholder="Apartment, Street, Area">
            </div>
            <div class="mb-4">
                <label for="type" class="form-label">Select Complaint Type</label>
                <select class="form-select" name="dept" aria-label="Default select example">
                    <option selected>--Please Select--</option>
                    <option value="road">Road Complaints</option>
                    <option value="electricity">Electricity Complaints</option>
                    <option value="water">Water Complaints</option>
                </select>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="description" placeholder="Complaint Description" id="desc" style="height: 100px"></textarea>
                <label for="desc">Complaint Description</label>
            </div>
            <div class="mb-4">
                <label for="formFileMultiple" class="form-label">Upload Photos Of Problem</label>
                <input class="form-control" type="file" accept="image/*" name="photos" value="upload" id="formFileMultiple" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>
