<!DOCTYPE html>
<html lang="en">
<head>
    <title>Single Product</title>
</head>
<body>
<?php 
    include('header.php');  
    require('Database/product.php'); 

    $product = new product();
    $database = $product->getDatabase();
?>
   
<?php

    $productID=$_GET["id"];
    
    $temp = $product->getProductByID($productID);

    $data=mysqli_fetch_array($temp);
    //print_r($data);
?>

<div class="container mt-5 animation">
    <div class="flex">
        <div class="row">
            <div class="col">
                <div class="pimg">
                    <img class="pimg" src="<?php echo $data['image']; ?>" alt="Card image cap">
                </div>
            </div>   
            <div class="col">

                <div class="pname">
                    <h2><?php echo $data['name']; ?></h2>
                </div>


                <?php 
                    if(isset($_POST['addcart'])){
                        echo "<div class=' w-50 text-center p-3 m-auto text-white bg-success rounded'> Product Added to Cart </div>";

                    }
                ?>

                

                <div class="pdesc">
                    <p><?php echo $data['description']; ?></p>
                </div>

                

                <div class="pprice">
                    <h3>Price : <?php echo $data['price']; ?></h3>
                </div>  

                

                <form method="post" class="text-center">
                    <button type="submit" name="addcart" class="btn btn-success px-4">Add to Cart</button>
                </form>

                
            </div>  
        </div>
    </div>
</div>
<?php
    if(isset($_POST['addcart'])) {

        if(!isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['userType']) )
        { 
            echo "<script>alert('You need to login first!!!')</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
        else
        {
            if(!isset($_SESSION['cart'])) {
    
                $_SESSION['cart'] = array();
            }
    
            array_push($_SESSION['cart'], $productID);
            // echo "<div class=' w-25 text-center p-3 m-auto text-white bg-success rounded'> Product Added to Cart </div>";
        }
    }
?>
<?php include('footer.php'); ?>


</body>
</html>