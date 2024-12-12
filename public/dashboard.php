<?php
   session_start();
   
   if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Redirect to login page
        header('Location: login.php');
        exit();
    }

    if (!isset($_SESSION['apples'])) {
        $_SESSION['apples'] = 0;
    }
    if (!isset($_SESSION['bananas'])) {
        $_SESSION['bananas'] = 0;
    }
    if (!isset($_SESSION['grapefruit'])) {
        $_SESSION['grapefruit'] = 0;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

?>


<?php include "common/htmlDocHeader.php"; ?>

<body>

    <?php include('topBar.php'); ?>

    <h1>Welcome <?php echo htmlspecialchars($_SESSION["username"]) ?>!</h1>

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