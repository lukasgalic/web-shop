<?php
   session_start();
   
   if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Redirect to login page
        header('Location: login.php');
        exit();
    }

    $_SESSION['apples'] = 0;
    $_SESSION['bananas'] = 0;
    $_SESSION['grapefruit'] = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['logout'])) {
            // Handle registration
            logout();
        }

        // Get form data and sanitize inputs
        $apples = trim(filter_input(INPUT_POST, 'apples', FILTER_UNSAFE_RAW));
        $bananas = trim(filter_input(INPUT_POST, 'bananas', FILTER_UNSAFE_RAW));
        $grapefruit = trim(filter_input(INPUT_POST, 'grapefruit', FILTER_UNSAFE_RAW));
        $_SESSION['apples'] = $apples;
        $_SESSION['bananas'] = $bananas;
        $_SESSION['grapefruit'] = $grapefruit;
        header('Location: cart.php');
        exit();
    }

    function logout() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION["username"] ?>!</h1>
    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
    <h2>Web shop</h2>
    
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Apples:</label>
            <input type="number" id="apples" name="apples" value="<?php echo $_SESSION["apples"] ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Bananas:</label>
            <input type="number" id="bananas" name="bananas" value="<?php echo $_SESSION["bananas"] ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Grapefruit:</label>
            <input type="number" id="grapefruit" name="grapefruit" value="<?php echo $_SESSION["grapefruit"] ?>" required>
        </div>

        <button type="submit">Add to cart!</button>
    </form>
    
</body>
</html>