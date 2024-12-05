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

// return the KEY inside the token
function createCsrfToken()
{
    $bytes = random_bytes(16);
    $name = basename($_SERVER['PHP_SELF'], ".php") . "_csrf_token";

    $_SESSION[$name] = bin2hex($bytes);

    return $name;
}

function checkCsrfToken()
{
    $name = basename($_SERVER['PHP_SELF'], ".php") . "_csrf_token";
    
    if (!isset($_POST[$name]) || !hash_equals($_SESSION[$name], $_POST[$name])) {
        return false;
    }

    return true;
}

function createCsrfTokenFormField(){
    $name = createCsrfToken();
    return "<input type='hidden' name='$name' value='" . $_SESSION[$name] . "'>";
}

?>