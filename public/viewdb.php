<?php
// Database configuration
$host = "db";     // MySQL host
$username = "lamp_user";
$password = "lamp_password";
$database = "lamp_db";

// Create connection using mysqli
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If you reach here, connection is successful
echo "Connected successfully!";

// Example query
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>