<?php
include "common/util.php"; 

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // handle paying

    if (!checkCsrfToken()) {
        $message = "CSRF token is not valid!";
        $messageClass = "error";
    } else {
        // reset the cart
        $_SESSION["apples"] = 10;
        $_SESSION["bananas"] = 0;
        $_SESSION["grapefruit"] = 0;
        $message = "Thank you for your purchase!";
        $messageClass = "success";
    }


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
    <?php if ($total == 0): ?>
        <div class="message error" style="margin-top:20px">
            You have no items in your cart!
        </div>
        <?php else: ?>
    
    <h2>Confirm your purchase</h2>
    <div>
        Please transfer the total amount of $<?php echo $total ?> (1$ = 1 coin) to the following wallet address:
        
        <div style="margin-top:10px; margin-bottom:10px" >
            <code>1LHroFft5WAxZTqXizQJjBJrPwkVQFAcsa</code>
        </div>
        You will most likely need to run this command:
        <div style="margin-top:10px; margin-bottom:10px" >
            <code> ./cli server sendtransaction --apiport 7081 --to "1LHroFft5WAxZTqXizQJjBJrPwkVQFAcsa" -amount <?php echo $total ?> </code>
        </div>        
    </div>


    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
        
        <?php echo createCsrfTokenFormField() ?>

        <div class="form-group">
            <label for="confirmationHash">Confirmation hash:</label>
            <input type="text" name="confirmationHash" required>
        </div>

        <div class="form-group">
            <label for="confirmationHash">Exact timestamp:</label>
            <input type="text" name="exactTimestamp" required>
        </div>

        <button type="submit" <?php echo $total == 0 ? "disabled" :"" ?>   >Confirm!</button>
    </form>
        <?php endif; ?>



</body>

</html>