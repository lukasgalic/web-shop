<?php

// a simple search page (that is insecure and vulnerable to SQL injection)



// get the search parameter from the URL
$search = $_GET['search'] ?? '';

// if the search parameter is not empty, search for the user

$badStmQuery = "";


function searchUser($search)
{
    global $badStmQuery;

    // Database configuration
    $dbHost = "db";     // MySQL host
    $dbUsername = "lamp_user";
    $dbPassword = "lamp_password";
    $dbName = "lamp_db";

    // Create database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user

    $badStmQuery = "SELECT * FROM users WHERE username = '$search'";


    $stmt = $conn->prepare( $badStmQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_all();
    $stmt->close();

    return $row;
}


?>




<?php include "common/htmlDocHeader.php"; ?>

<body>
    <?php include('topBar.php'); ?>

    <h2>Username address lookup</h2>
    <p>Check if a single user is registered on this site and show their address.</p>

    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="search">Username:</label>
            <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" required>
        </div>

        <button type="submit">Search</button>

    </form>

    <?php 
    if (!empty($search) ){
        $users = searchUser($search);
        // Hurr Durr
        // I am a dev that first tried to implement "all searches" then wanted to limit it to only one user
        // but the code works just as well if the SQL returns only one result so i am leaving it like this.
        if ($users) {
            for($i = 0; $i < count($users); $i++){
                $user = $users[$i];
                echo "<h3>Address for user: {$user[1]}</h3>";
                echo "<p>{$user[4]}</p>";
            }
            
        } else {
            echo "<h3>No user found with username: {$search}</h3>";
        }
    }
    ?>




<p class="footer">
    How to SQL attack this:
    <br>
    The code for the search string is not sanitized, but directly inserted into the SQL request. Meaning a classic escape trick works well.
    <br>

    <?php
        if(!empty($badStmQuery)){
            echo "The query that was searched for: <code> $badStmQuery </code> <br>";
        }     
    ?>
</p>
</body>