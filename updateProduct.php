<?php

require('Database/product.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnUpdateProduct']))
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
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
</head>
<body>
    <?php 
    include('header.php'); 

    $product = new product();
    $database = $product->getDatabase();
    
    $productID = $_GET["id"];
    
    $oneProduct = $product->getProductByID($productID);

    $singleProduct=mysqli_fetch_array($oneProduct);

    ?>
    
    <div class="container animation">
    <div class="row justify-content-center">
        <div class="col-md-10 p-5">
            <div class="text-center fs-1 fw-bold">
                Update Product
            </div>

            <form action="<?php echo $_SERVER["PHP_SELF"] . '?id=' . $productID; ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group mt-3 col">
                    <label>Product Name</label>
                    <input value="<?php echo $singleProduct['name']; ?>" name="productName" id="productName" class="form-control">
                    <span class="fw-bold text-danger">
                        <?php if(isset($productNameError)) { echo $productNameError; } ?>
                    </span>
                </div>

                <div class="form-group mt-3 col">
                    <label>Product Price</label>
                    <input value="<?php echo $singleProduct['price']; ?>" name="productPrice" id="productPrice" class="form-control">
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
                            <?php if($singleProduct['categoryID'] == $singleCategory['id'])
                            { 
                            ?>
                                <option selected value="<?php echo $singleCategory["id"]; ?>">
                                    <?php echo $singleCategory["categoryName"]; ?> 
                                </option>
                            <?php 
                            }
                            else
                            { 
                            ?>
                                <option value="<?php echo $singleCategory["id"]; ?>">
                                    <?php echo $singleCategory["categoryName"]; ?> 
                                </option>
                            <?php
                            }
                            ?>
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
                <textarea name="productDescription" id="productDescription" class="form-control" rows="4" cols="50"><?php echo $singleProduct['description']; ?></textarea>
                <span class="fw-bold text-danger">
                    <?php if(isset($productDescriptionError)) { echo $productDescriptionError; } ?>
                </span>
            </div>

            <div class="form-group mt-3">
                <label>Product Image</label>
                <img class="img-fluid" src=<?php echo $singleProduct['image']; ?>>
                <input type="file" name="productImage" id="productImage" class="form-control">
                <span class="fw-bold text-danger">
                    If you don't upload new image, image won't be updated...
                </span>
            </div>

            <input type="hidden" name="oldProductImage" value="<?php echo $singleProduct['image']; ?>">

            <input type="hidden" name="productID" value="<?php echo $singleProduct['id']; ?>">

            <div class="text-center">
                <button class="mt-2 me-2 py-1 px-4 btn btn-primary" name="btnUpdateProduct" id="btnUpdateProduct">Update</button>
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
    if(isset($_POST['btnUpdateProduct'])) {

        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productCategoryID = $_POST['productCategory'];
        $productDescription = $_POST['productDescription'];
        $productID = $_POST['productID'];

        if(empty($productNameError) && empty($productPriceError) && empty($productCategoryIDError) && empty($productDescriptionError) && empty($productImageError))
        {
            if(isset($_FILES['productImage']) && $_FILES['productImage']['error'] == UPLOAD_ERR_OK)
            {
                $filename=$_FILES["productImage"]["name"];
                $tempname=$_FILES["productImage"]["tmp_name"];
                $productImagePath="images/products/".$filename;
                move_uploaded_file($tempname,$productImagePath);
            }
            else
            {
                $productImagePath = $_POST['oldProductImage'];
            }

            $product = new product();
            $result = $product->updateProduct($productCategoryID,$productDescription,$productImagePath,$productPrice,$productName,$productID);
                
            if($result) {
                echo "<script>alert('Product Updated successfully...');</script>";
            } else {
                echo "<script>alert('Error Updating Product...');</script>";
            }
            echo "<script>window.location.href='manageProducts.php'</script>";
        }
        else
        {
            echo "<script>alert('Reached...');'</script>";
        }
    }  
}
?>
