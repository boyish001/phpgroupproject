<?php
    // Start the session
    session_start();

    // Clear the cart session variable
    unset($_SESSION['cart']);

    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
?>