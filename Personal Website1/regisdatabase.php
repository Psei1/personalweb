<?php
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "personalwebsite";
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if (!$conn) {
        die("Something went wrong!");
    
    
    echo '<script>alert("Data inserted successfully!"); window.location.href = "regisdatabase.php";</script>';
    }
?>