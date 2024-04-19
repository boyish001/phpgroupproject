<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="images/logo.png" type="image/x-icon">
</head>
<body>
    <nav>
        <a href="index.php" <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>>Home</a>
        <?php
        
        session_start();
        
        if(!isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['userType']) )
        {
        ?>
        <a href="menu.php" <?php if(basename($_SERVER['PHP_SELF']) == 'menu.php') echo 'class="active"'; ?>>Menu</a>
        <a href="about.php" <?php if(basename($_SERVER['PHP_SELF']) == 'about.php') echo 'class="active"'; ?>>About Us</a>
        <a href="contact.php" <?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'class="active"'; ?>>Contact Us</a>
        <a href="login.php" <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>>Login</a>
        <?php 
        }
        else
        {
            if($_SESSION['userType'] == "Admin")
            {?>
                <a href="manageUsers.php" <?php if(basename($_SERVER['PHP_SELF']) == 'manageUsers.php') echo 'class="active"'; ?>>Users</a>
                <a href="manageCategories.php" <?php if(basename($_SERVER['PHP_SELF']) == 'manageCategories.php') echo 'class="active"'; ?>>Categories</a>
                <a href="manageProducts.php" <?php if(basename($_SERVER['PHP_SELF']) == 'manageProducts.php') echo 'class="active"'; ?>>Products</a>
                <a href="manageFeedback.php" <?php if(basename($_SERVER['PHP_SELF']) == 'manageFeedback.php') echo 'class="active"'; ?>>Feedback</a>
                <a href="manageOrders.php" <?php if(basename($_SERVER['PHP_SELF']) == 'manageOrders.php') echo 'class="active"'; ?>>Orders</a>
            <?php }
            else
            { ?>
                <a href="menu.php" <?php if(basename($_SERVER['PHP_SELF']) == 'menu.php') echo 'class="active"'; ?>>Menu</a>
                <a href="about.php" <?php if(basename($_SERVER['PHP_SELF']) == 'about.php') echo 'class="active"'; ?>>About Us</a>
                <a href="contact.php" <?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'class="active"'; ?>>Contact Us</a>
                <a href="cart.php" <?php if(basename($_SERVER['PHP_SELF']) == 'cart.php') echo 'class="active"'; ?>>Cart</a>
                <a href="order.php" <?php if(basename($_SERVER['PHP_SELF']) == 'order.php') echo 'class="active"'; ?>>Orders</a>
            <?php } ?>
            <a href="logout.php" <?php if(basename($_SERVER['PHP_SELF']) == 'logout.php') echo 'class="active"'; ?>>Logout</a>
        <?php } ?>
    </nav>
</body>
</html>