<?php 
    require('Database/product.php');

    $product = new product();
    $database = $product->getDatabase();

    $productId=$_GET["id"];

    $result = $product->deleteProduct($productId);
    
    if($result)
    {
        echo "<script>alert('Product Deleted Successfully......');</script>";
    }
    else
    {
        echo "<script>alert('Error Delete Product......')</script>";
    }
    echo "<script>window.location.href='manageProducts.php'</script>";

?>