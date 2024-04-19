<?php

require('Database/category.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnUpdateCat']))
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
    <title>Update Category</title>
</head>
<body>
<?php 
    include('header.php'); 

    $category = new Category();
    $database = $category->getDatabase();

    $catID = $_GET["id"];

    $cat = $category->getCategoryByID($catID);

    $data=mysqli_fetch_array($cat);
    ?>
    <div class="container animation">
        <div class="row justify-content-center">
            <div class="col-md-6 p-5">

                <div class="text-center mb-5 fs-1 fw-bold">
                    Update Category
                </div>
                
                <form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">

                    <div class="form-group mt-3">
                        <label for="catName">Category Name</label>
                        <input name="catName" class="form-control" value="<?php echo $data['categoryName']; ?>">
                        <span class="fw-bold text-danger">
                            <?php if(isset($catNameError)) { echo $catNameError; } ?>
                        </span>
                    </div>

                    <input type="hidden" name="categoryId" value="<?php echo $catID; ?>">

                    <div class="text-center">
                        <button  name="btnUpdateCat" class="mt-2 me-2 py-1 px-4 btn btn-primary">Update</button>
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
    if(isset($_POST['btnUpdateCat'])) {

        $categoryId = $_POST['categoryId'];
        $catName = $_POST['catName'];

        if(empty($catNameError))
        {
            $result = $category->updateCategory($categoryId,$catName);

            if($result) {
                echo "<script>alert('Category Updated Successfully...');</script>";
            } else {
                echo "<script>alert('Error Updating Category...');</script>";
            }
            echo "<script>window.location.href='manageCategories.php'</script>";
        }
    }  
}
?>