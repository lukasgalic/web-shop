<?php


function getDbConnection()
{
    $dbHost = "db";
    $dbUsername = "lamp_user";
    $dbPassword = "lamp_password";
    $dbName = "lamp_db";

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>