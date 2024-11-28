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

    // check the CSRF token and remove it afterwards if valid (one time token)
    // reload the page to regenerate one
    if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token_profile_change"], $_POST["csrf_token"])) {

        // remove the token
        unset($_SESSION["csrf_token_profile_change"]);

        header('Location: profile.php');

        exit();
    }

    $homeAddress = trim(filter_input(INPUT_POST, 'home_address', FILTER_UNSAFE_RAW));

    // sanitize the input
    $homeAddress = htmlspecialchars($homeAddress);

    $user = $_SESSION["username"];

    $conn = getDbConnection();
    $stmt = $conn->prepare("UPDATE users SET home_address = ? WHERE username = ?");
    $stmt->bind_param("ss", $homeAddress, $user);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: profile.php');
    exit();
}else{
    // regenerate the CSRF token
    $bytes = random_bytes(16);
    $_SESSION["csrf_token_profile_change"] = bin2hex($bytes);
}



?>

<?php include "common/htmlDocHeader.php"; ?>

<body>

    <?php include('topBar.php'); ?>

    <h1>Hello <?php echo $_SESSION["username"] ?>!</h1>

    <h2>Currently this is your saved address: <?php echo getAddressFromDb() ?></h2>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token_profile_change"] ?>">

        <div class="form-group">
            <label>New address:</label>
            <input type="text" name="home_address" placeholder="<?php echo getAddressFromDb() ?>" required>
        </div>

        <button type="submit">Submit</button>

    </form>

    
<p class="footer">
    This site was used in an XSS+CSRF attack! <br/>
    1. Fixed by attaching a CSRF token (random 16byte hex string) to the form and checking it on the server side. <br/>
    2. XSS was fixed by sanitizing the input for the address field. <br/>
</p>

</body>


</html>


