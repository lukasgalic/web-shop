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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_UNSAFE_RAW));
    $homeAddress = trim(filter_input(INPUT_POST, 'home_address', FILTER_UNSAFE_RAW));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate inputs
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long";
    }

    if (empty($homeAddress)) {
        $errors[] = "Home address is required";
    } elseif (strlen($homeAddress) < 3) {
        $errors[] = "Home address must be at least 3 characters long";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/', $password) === 0) {
        $errors[] = "Must include upper and lower case letters, as well as a number";
    }

    $file = fopen('commonPasswords.txt', 'r');
    while(!feof($file)) {
        $line = trim(fgets($file)); // Remove whitespace and line endings
        if ($line === $password) {
            $errors[] = "Password is too common";
            break;
        } 
    }
    fclose($file);

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errors[] = "Username already exists";
    }
    $stmt->close();

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare and execute the INSERT statement
        $stmt = $conn->prepare("INSERT INTO users (username, password, home_address, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $hashedPassword, $homeAddress);
        
        if ($stmt->execute()) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = time();
        
            $_SESSION['expire_time'] = time() + (30 * 60);
            header('Location: dashboard.php');
            exit();
        } else {
            $message = "Error occurred during registration. Please try again.";
            $messageClass = "error";
        }
        $stmt->close();
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
            <label for="home_address">Home Address:</label>
            <input type="text" id="home_address" name="home_address" value="<?php echo isset($homeAddress) ? htmlspecialchars($homeAddress) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit">Register</button>
        <a href="login.php" class="button">Click here to login</a>
    </form>
</body>
</html>