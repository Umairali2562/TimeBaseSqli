<?php
$con=mysqli_connect("localhost","root","","test");

if(isset($_GET['id'])) {
    $id = $_GET['id']; //getting the input
    $i=0;
    $query = "SELECT * FROM ad where id=$id"; //here's the query ...
    $results=mysqli_query($con,$query); //executing the query
    while($row=mysqli_fetch_assoc($results)){  //fetching all results
        echo $row["umair"]; //echoing all results in a loop of infinite ..
    }
}

