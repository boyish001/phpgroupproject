<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
</head>
<body>
    <?php 
        include('header.php'); 
        include('Database/order.php'); 
        if(!isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['userType']) )
        { 
            echo "<script>alert('You need to login first!!!')</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
        else
        {
            if($_SESSION['userType'] != "Admin")
            {
                echo "<script>alert('Only Admin can access this page!!!')</script>";
                echo "<script>window.location.href='index.php'</script>";
            }
        }
    ?>
    <div class="container my-3 animation">
    <h1 class="text-center my-5">Orders</h1>
    <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Name</th>
            <th scope="col">Order Date</th>
            <th scope="col">Total</th>
            <th scope="col">Details</th>
        </tr>
    </thead>
    <tbody>
        <?php 

        $order = new order();
        $database = $order->getDatabase();
                
        $orders = $order->getOrders();
        
        while($singleOrder=mysqli_fetch_array($orders,MYSQLI_ASSOC))
        {
        ?>
            <tr>
                <td><?php echo $singleOrder['id']; ?></td>
                <td><?php echo $singleOrder['name']; ?></td>
                <td><?php echo $singleOrder['date']; ?></td>
                <td><?php echo $singleOrder['total'] . "$"; ?></td>
                <td><a class="btn btn-warning text-white" href="orderDetails.php?id=<?php echo $singleOrder['id'];?>">View Details</td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
        </div>
    <?php include('footer.php'); ?>
</body>
</html>