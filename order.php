<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
</head>

<body>
    <?php include('header.php'); ?>
    <?php

    if(!isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['userType']) )
    { 
        echo "<script>alert('You need to login first!!!')</script>";
        echo "<script>window.location.href='login.php'</script>";
    }
    
?>
    <div id="orderpage" class="animation">
        <?php 
        require('Database/order.php');

        $order = new order();
        $database = $order->getDatabase();

        $userEmail = $_SESSION['email'];
        $userPassword = $_SESSION['password'];

        $orders = $order->getOrderByUser($userEmail,$userPassword);
        
        if(mysqli_num_rows($orders) > 0) {
            while ($singleOrder = mysqli_fetch_array($orders, MYSQLI_ASSOC)) {
            ?>
                <div class="container weatherContainer mt-5">
                    <h4><?php echo $singleOrder['id']; ?></h4>
                    <br>
                    <h6>Order Date : <?php echo $singleOrder['date']; ?><h6>
                    <h6>Grand Total : $<?php echo $singleOrder['total']; ?><h6>
                    <form method="post" action="view_invoice.php">
                        <input type="hidden" name="order_id" value="<?php echo $singleOrder['id']; ?>">
                        <button type="submit" class="btn btn-primary mt-3">View Payment Invoice</button>
                    </form>
                </div>
            <?php 
            }
        } else {
            echo '<div class="container weatherContainer mt-5">';
            echo '<img src="Images/noorder.png" alt="No Orders" style="max-width: 100%;">';
            echo '</div>';
            echo '<div class="text-center mx-auto my-4"><a href="menu.php" class="bg-primary rounded text-white py-3 px-4">Order now!</a></p></div>';
        }
    ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>