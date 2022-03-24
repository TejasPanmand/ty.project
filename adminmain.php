<?php

$approve = false;
$delete = false;

// Connecting to the Database
$host = "host=127.0.0.1";
$port = "port=5432";
$dbname = "dbname=projecttest";
$cred = "user=postgres password=postgres";

// Create a connection
$conn = pg_connect( "$host $port $dbname $cred" );

// Die if connection was not successful
if ( !$conn) {
    die( "<br><mark>Sorry we failed to connect: Database Connection Error</mark>" );
}
session_start();

if ($_SESSION['admin'] == NULL){
    die( "<br><mark>Sorry we failed to connect: Login Error</mark><br><a href='./index.php'>Main Page</a>" );
}
    
if(isset($_GET['delete'])){
  $complaintno = $_GET['delete'];
  $delete = true;
  $sql = "update complaint set status = 'discard' , dateofapp = CURRENT_DATE where complaintno = '$complaintno'";
  $result = pg_query($conn, $sql);
}

if(isset($_GET['approve'])){
  $complaintno = $_GET['approve'];
  $approve = true;
  $sql = "update complaint set status = 'approved' , dateofapp = CURRENT_DATE where complaintno = '$complaintno'";
  $result = pg_query($conn, $sql);
}

?>



<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

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
                <a class="btn btn-primary border border-dark" href="./index.php" role="button">Logout</a>
            </div>
        </div>
    </nav>


    <?php
  if($approve){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Complaint has been Approved successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

    <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Complaint has been Deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>



    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Complaint Number</th>
                    <th scope="col">Address</th>
                    <th scope="col">Department</th>
                    <th scope="col">Description</th>
                    <th scope="col">Photos</th>
                    <th scope="col">Date Of Complaint</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>



          <?php 
          $sql = "SELECT * FROM complaint where status like 'unassigned'";
          $result = pg_query($conn, $sql);
          while($row = pg_fetch_assoc($result)){
            echo "<tr>
            <th scope='row'>". $row['complaintno'] . "</th>
            <td>". $row['addr'] . "</td>
            <td>". $row['dept'] . "</td>
            <td>". $row['description'] . "</td>
            <td>". pg_unescape_bytea($row['photos'])  . "</td>
            <td>". $row['dateofcomp'] . "</td>
            <td> <button class='approve btn btn-sm btn-primary' id=d".$row['complaintno'].">Approve</button> 
            <button class='delete btn btn-sm btn-primary' id=d".$row['complaintno'].">Delete</button>  </td>
          </tr>";
        } 
          ?>


            </tbody>
        </table>
    </div>
    <hr>
    
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>



    <script>
        approves = document.getElementsByClassName('approve');
        Array.from(approves).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                complaintno = e.target.id.substr(1);

                if (confirm("Are you sure you want to Approve this Complaint!")) {
                    console.log("yes");
                    window.location = `/ty.project/adminmain.php?approve=${complaintno}`;
                    // TODO: Create a form and use get request to submit a form
                } else {
                    console.log("no");
                }
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                complaintno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this Complaint!")) {
                    console.log("yes");
                    window.location = `/ty.project/adminmain.php?delete=${complaintno}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })

    </script>

</body>

</html>
