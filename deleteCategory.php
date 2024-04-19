<?php 
    require('Database/category.php');

    $category = new category();
    $database = $category->getDatabase();
    
    $catId=$_GET["id"];

    $temp = $category->checkIfProductExists($catId);

    if(mysqli_num_rows($temp)>0)
    {
        echo "
        <script>
            alert('Cannot Delete Category As Product Of These Category Exists......');
            window.location.href='manageCategories.php'
        </script>";
    }
    else
    {
        $result = $category->deleteCategory($catId);
        if($result)
        {
            echo "<script>alert('Category Deleted Successfully......');</script>";
        }
        else
        {
            echo "<script>alert('Error Delete Category......')</script>";
        }
        echo "<script>window.location.href='manageCategories.php'</script>";
    }
?>