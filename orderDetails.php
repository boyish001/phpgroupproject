<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Details</title>
</head>
<body>
<?php 
    include('header.php');  
    require('Database/order.php'); 
?>
   
<?php

    $order = new order();
    $database = $order->getDatabase();

    $orderID=$_GET["id"];

    $temp = $order->getOrderByID($orderID);

    $data=mysqli_fetch_array($temp);  
?>

<div class="container animation">
    <h2 class="my-5">Viewing details for <?php echo $data['name']; ?></h2>
    <table class="table table-bordered text-center p-5">
        <tbody>
                <tr>
                    <td>Order ID</td>
                    <td><?php echo $data['id']; ?>
                </tr>
                <tr>
                    <td>User Email</td>
                    <td><?php echo $data['userEmail']; ?>
                </tr>
                <tr>
                    <td>User Password</td>
                    <td><?php echo $data['userPassword']; ?>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $data['name']; ?>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $data['email']; ?>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><?php echo $data['phone']; ?>
                </tr>
                <tr>
                    <td>Street</td>
                    <td><?php echo $data['street']; ?>
                </tr>
                <tr>
                    <td>City</td>
                    <td><?php echo $data['city']; ?>
                </tr>
                <tr>
                    <td>Province</td>
                    <td><?php echo $data['province']; ?>
                </tr>
                <tr>
                    <td>Postal Code</td>
                    <td><?php echo $data['postalCode']; ?>
                </tr>
                <tr>
                    <td>Card Number</td>
                    <td><?php echo $data['cardNumber']; ?>
                </tr>
                <tr>
                    <td>Expiry Date</td>
                    <td><?php echo $data['expiryDate']; ?>
                </tr>
                <tr>
                    <td>CVV</td>
                    <td><?php echo $data['cvv']; ?>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td><?php echo $data['date']; ?>
                </tr>
                <tr>
                    <td>Order Total</td>
                    <td><?php echo $data['total']; ?>
                </tr>
        </tbody>
    </table>
</div>
<?php include('footer.php');  ?>
</body>
</html>