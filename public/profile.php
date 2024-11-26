<?php

require_once "common/util.php";


session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}


function getAddressFromDb()
{
    $user = $_SESSION["username"];
    $homeAddress = "";

    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT home_address FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($homeAddress);
    $stmt->fetch();
    $stmt->close();

    return $homeAddress;
    
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $homeAddress = trim(filter_input(INPUT_POST, 'home_address', FILTER_UNSAFE_RAW));
    $user = $_SESSION["username"];

    $conn = getDbConnection();
    $stmt = $conn->prepare("UPDATE users SET home_address = ? WHERE username = ?");
    $stmt->bind_param("ss", $homeAddress, $user);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: profile.php');
    exit();
}



?>

<?php include "common/htmlDocHeader.php"; ?>

<body>

    <?php include('topBar.php'); ?>

    <h1>Hello <?php echo $_SESSION["username"] ?>!</h1>

    <h2>Currently this is your saved address: <?php echo getAddressFromDb() ?></h2>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label>New address:</label>
            <input type="text" name="home_address" placeholder="<?php echo getAddressFromDb() ?>" required>
        </div>

        <button type="submit">Submit</button>

    </form>
    
</body>
</html>


