<?php

require('Database/product.php');

$product = new product();
$database = $product->getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnAddProduct']))
    {
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productCategoryID = $_POST['productCategory'];
        $productDescription = $_POST['productDescription'];

        if(empty($productName))
        {
            $productNameError = "Product Name is required!!!";
        }
        else{
            $productNameError = "";
        }

        if(empty($productPrice))
        {
            $productPriceError = "Product Price is required!!!";
        }
        else if(!preg_match('/^\d{1,2}\.\d{2}\$$/',$productPrice))
        {
            $productPriceError = "Enter valid Price in X.XX$ or XX.XX$ format !!!";
        }
        else{
            $productPriceError = "";
        }

        if($productCategoryID == "default")
        {
            $productCategoryIDError = "Please select a category!!!";
        }
        else{
            $productCategoryIDError = "";
        }

        if(empty($productDescription))
        {
            $productDescriptionError = "Product Description is required!!!";
        }
        else{
            $productDescriptionError = "";
        }

        if(isset($_FILES['productImage']) && $_FILES['productImage']['error'] == UPLOAD_ERR_OK)
        {
            $productImageError = "";
        }
        else
        {
            $productImageError = "Product image is required!!!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
    <?php 
    include('header.php'); 
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
    
    <div class="container animation">
    <div class="row justify-content-center">
        <div class="col-md-10 p-5">
            <div class="text-center fs-1 fw-bold">
                Add New Product
            </div>

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group mt-3 col">
                    <label>Product Name</label>
                    <input name="productName" id="productName" class="form-control">
                    <span class="fw-bold text-danger">
                        <?php if(isset($productNameError)) { echo $productNameError; } ?>
                    </span>
                    
                </div>

                <div class="form-group mt-3 col">
                    <label>Product Price</label>
                    <input name="productPrice" id="productPrice" class="form-control">
                    <span class="fw-bold text-danger">
                        <?php if(isset($productPriceError)) { echo $productPriceError; } ?>
                    </span>
                </div>
            </div>
            
            <div class="form-group mt-3">
                <label>Product Category</label>
                <select name="productCategory" id="productCategory" class="form-control">
                <option value="default">Select Category</option>
                    <?php
                    
                        $categories = $product->getCategories();

                        while($singleCategory=mysqli_fetch_array($categories,MYSQLI_ASSOC))
                        {
                    ?>
                            <option value="<?php echo $singleCategory["id"]; ?>">
                            <?php echo $singleCategory["categoryName"]; ?> 
                            </option>
                    <?php 
                        }
                    ?>
					</select>
                    <span class="fw-bold text-danger">
                        <?php if(isset($productCategoryIDError)) { echo $productCategoryIDError; } ?>
                    </span>    
            </div>

            <div class="form-group mt-3">
                <label>Product Desctiption</label>
                <textarea name="productDescription" id="productDescription" class="form-control" rows="4" cols="50"></textarea>
                <span class="fw-bold text-danger">
                    <?php if(isset($productDescriptionError)) { echo $productDescriptionError; } ?>
                </span>
            </div>

            <div class="form-group mt-3">
                <label>Product Image</label>
                <input type="file" name="productImage" id="productImage" class="form-control">
                <span class="fw-bold text-danger">
                    <?php if(isset($productImageError)) { echo $productImageError; } ?>
                </span>
            </div>

            <div class="text-center">
                <button class="mt-2 me-2 py-1 px-4 btn btn-primary" name="btnAddProduct" id="btnAddProduct">Add</button>
                <a class="mt-2 py-1 px-4 btn btn-danger" href="manageProducts.php">Cancel</a>
            </div>
            </form>
        </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if(isset($_POST['btnAddProduct'])) {

        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productCategoryID = $_POST['productCategory'];
        $productDescription = $_POST['productDescription'];

        if(empty($productNameError) && empty($productPriceError) && empty($productCategoryIDError) && empty($productDescriptionError) && empty($productImageError))
        {
            $filename=$_FILES["productImage"]["name"];
            $tempname=$_FILES["productImage"]["tmp_name"];
            $productImagePath="images/products/".$filename;
            move_uploaded_file($tempname,$productImagePath);

            $result = $product->insertProduct($productName,$productPrice,$productCategoryID,$productDescription,$productImagePath);

            if($result) {
                echo "<script>alert('Added Product successfully...');</script>";
            } else {
                echo "<script>alert('Error Adding Product...');</script>";
            }
            echo "<script>window.location.href='manageProducts.php'</script>";
        }
    }  
}
?>
