<?php
    $servername ="localhost";
    $username = "root";
    $password = "";
    $db = "test";
    //CONNECT TO MYSQL DATABASE USING MYSQLI
    
    // Create connection
    $conn =  mysqli_connect($servername,$username,$password,$db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
     }
    // echo nl2br("Connected :D \n");
?>