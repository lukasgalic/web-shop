<?php
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

// Initialize variables for error/success messages
$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_UNSAFE_RAW));
    $password = $_POST['password'];

    // Validate inputs
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 1) {
        $errors[] = "Username must be at least 3 characters long";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 1) {
        $errors[] = "Password must be at least 6 characters long";
    }

    // Retrieve password
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $hashedPasswordFromDB = $row['password'];
    $stmt->close();

    if ($row['failed_attempts'] >= 4) {
        $errors[] = "Too many attempts";
    } elseif (!password_verify($password, $hashedPasswordFromDB)) {
        $stmt = $conn->prepare("Update users SET failed_attempts = ? WHERE id = ?");
        $increment = $row['failed_attempts'] + 1;
        $stmt->bind_param("ss", $increment, $row["id"]);
        $stmt->execute();
        $stmt->close();
        $remaining_attempts = 5 - $increment;  
        $errors[] = "Password was not correct, number of attempts left {$remaining_attempts}";
    }

    // If no errors, proceed with login
    if (empty($errors)) {
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        
        // Optional: Set session timeout (e.g., 30 minutes)
        $_SESSION['expire_time'] = time() + (30 * 60);
        header('Location: dashboard.php');
        exit();
    } else {
        $message = implode("<br>", $errors);
        $messageClass = "error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
    <h2>User Registration</h2>
    
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>