<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // handle paying

}
    $total = $_SESSION["apples"] * 2 + $_SESSION["bananas"] * 3 + $_SESSION["grapefruit"] * 4;
?>

<?php include "common/htmlDocHeader.php"; ?>


<body>
    <?php include('topBar.php'); ?>

    <h1>Welcome <?php echo $_SESSION["username"] ?>!</h1>
    <h2>Shopping Cart</h2>

    <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label>Apples: <?php echo $_SESSION["apples"] ?></label>
        </div>

        <div class="form-group">
            <label for="username">Bananas: <?php echo $_SESSION["bananas"] ?></label>
        </div>

        <div class="form-group">
            <label for="username">Grapefruit: <?php echo $_SESSION["grapefruit"] ?></label>
        </div>

        <div class="form-group">
            <label style="font-weight: bold;" for="username">You total: $<?php echo $total?></label>
        </div>

        <button type="submit">Pay!</button>
    </form>
</body>

</html>