<?php
$host = "host=127.0.0.1";
$port = "port=5432";
$dbname = "dbname=projecttest";
$cred = "user=postgres password=postgres";
$display = false;

// Create a connection
$conn = pg_connect( "$host $port $dbname $cred" );

// Die if connection was not successful
if ( !$conn ) {
    die( "<br><mark>Sorry we failed to connect: Database Connection Error</mark>" );
}

// Store Post Variables
if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
    $cno = $_POST["complaintno"];
    // Compare SQL Query
    $sql = "select * from complaint where complaintno='$cno'";
    $result = pg_query( $conn, $sql );
    $row = pg_fetch_assoc( $result );
    $name = $row['name'];
    $addr = $row['addr'];
    $dept = $row['dept'];
    $desc = $row['description'];
    $status = $row['status'];
    $dateofcomp = $row['dateofcomp'];
    $dateofapp = $row['dateofapp'];
    $dateofclose = $row['dateofclose'];
    $display = true;
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
            <a class="navbar-brand" href="./index.php">
                <img src="./images/top_logo.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
            </a>
            <a class="navbar-brand" href="./index.php">Government Complaint Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Check Complaint Status</a>
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


    <center>
        <div class="container mt-5">
            <div class="col-lg-5">
                <form method="POST" action="./check_status.php">
                    <div class="input-group mb-3">
                        <h2><u>Check Your Complaint Status</u></h2><br><br><br>
                        <span class="input-group-text" id="basic-addon1">Complaint Number</span>
                        <input type="number" class="form-control" placeholder="Enter Complaint Number" aria-label="ComplaintNumber" name="complaintno" aria-describedby="basic-addon1" min="1" max="10000">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </center>

    <?php
if ( $display ) {
    echo "<center><div class='container mt-5'>
            <div class='col-lg-5'><b><h3>
            Hello $name<br>
            Following Are your Complaint Details!<br><br>
            Name : $name<br>
            Address : $addr<br>
            Department of Complaint : $dept department<br>
            Description : $desc<br>
            Status : $status<br>
            Date of Complaint : $dateofcomp<br>
            Date of Approval : $dateofapp<br>
            Date of Completion : $dateofclose<br>
            </h3></b></div>
        </div>
        </center>
  ";
  }
    ?>

    <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>
