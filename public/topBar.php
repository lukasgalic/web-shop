<?php
// A simple top-bar that redirects to all needed pages

$current_path = $_SERVER['REQUEST_URI'];

$user_is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

function createMenuButton(string $target_path, bool $disabled, string $title ) {

    global $current_path;

    $disabled = $disabled | $current_path === $target_path ;

    ob_start(); // buffer all code into the output, as if directly written to the client

    ?>
        <button onclick="location.href = '<?php echo $target_path; ?>';" <?php echo $disabled  ? 'disabled' : '' ?> ><?php echo $title ?> </button>    
    <?php

return ob_get_clean();
}

?>


<div>
    <div>

        <b>Page Navigation:</b>
        
        <?php
            echo createMenuButton('/login.php', $user_is_logged_in, 'Login');
            echo createMenuButton('/register-page.php', $user_is_logged_in, 'Register');
            echo createMenuButton('/cart.php', !$user_is_logged_in, 'Cart');
            echo createMenuButton('/dashboard.php', !$user_is_logged_in, 'Dashboard');
        ?>
    </div>
    
    <br> 
    
    <div>
        <b>Actions:</b>

        <?php
            echo createMenuButton('/logout.php', !$user_is_logged_in, 'Logout');
        ?>

    </div>
</div>

