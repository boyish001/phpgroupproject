<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
</head>
<body>
    <?php 
    include('header.php'); 
    include('Database/product.php');

    $product = new product();
    $database = $product->getDatabase();

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
    <div class="container text-center animation">
    <h1 class="text-center my-5">Manage Products</h1>
    <a class="btn btn-success mb-5" href="addProduct.php">Add New Product</a>
    <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Category</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col" colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $products = $product->getProducts();
        
        while($singleProduct=mysqli_fetch_array($products,MYSQLI_ASSOC))
        {
        ?>
            <tr>
                <td><?php echo $singleProduct['id']; ?></td>
                <td><?php echo $singleProduct['categoryID']; ?></td>
                <td><?php echo $singleProduct['name']; ?></td>
                <td><?php echo $singleProduct['description']; ?></td>
                <td><?php echo $singleProduct['price']; ?></td>
                <td><img src=<?php echo $singleProduct['image']; ?>></td>
                <td><a class="btn btn-warning text-white" href="updateProduct.php?id=<?php echo $singleProduct['id'];?>">Update</td>
                <td><a class="btn btn-danger" href="deleteProduct.php?id=<?php echo $singleProduct['id'];?>">Delete</td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
        </div>
    <?php include('footer.php'); ?>
</body>
</html>