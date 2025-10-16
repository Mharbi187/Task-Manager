<?php 
    $servername = "localhost";
    $username = "root";
    $password = ""; // ← empty string for no password
    $db_name = "taskmanager";

    $conn = new mysqli($servername, $username, $password, $db_name);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    echo "";
?>
    