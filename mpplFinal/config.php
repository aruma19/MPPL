<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "edutrack";

    $connection = new mysqli($hostname, $username, $password, $database);

    if($connection -> connect_error) {
        die('Connection error'. $connect -> connect_error);
    }
    
?>