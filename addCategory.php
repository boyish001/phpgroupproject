<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnAddCat']))
    {
        $catName = $_POST['catName'];

        if(empty($catName))
        {
            $catNameError = "Category Name is required!!!";
        }
        else{
            $catNameError = "";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Category</title>
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
            <div class="col-md-6 p-5">

                <div class="text-center mb-5 fs-1 fw-bold">
                    Add New Category
                </div>
                
                <form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">

                    <div class="form-group mt-3">
                        <label for="catName">Category Name</label>
                        <input name="catName" class="form-control ">
                        <span class="fw-bold text-danger">
                            <?php if(isset($catNameError)) { echo $catNameError; } ?>
                        </span>
                    </div>

                    <div class="text-center">
                        <button  name="btnAddCat" class="mt-2 me-2 py-1 px-4 btn btn-primary">Add</button>
                        <a href="manageCategories.php" class="mt-2 py-1 px-4 btn btn-danger">Cancel</a>
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
    if(isset($_POST['btnAddCat'])) {

        $catName = $_POST['catName'];

        if(empty($catNameError))
        {
            require('Database/category.php');

            $category = new Category();

            $result = $category->insertCategory($catName);

            if($result) {
                echo "<script>alert('Category Added Successfully...');</script>";
            } else {
                echo "<script>alert('Error Adding Category...');</script>";
            }
            echo "<script>window.location.href='manageCategories.php'</script>";
        }
    }  
}
?>