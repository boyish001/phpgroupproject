<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories</title>
</head>
<body>
    <?php 
    include('header.php'); 
    include('Database/category.php'); 
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
    <h1 class="text-center my-5">Manage Categories</h1>
    <a class="btn btn-success mb-5" href="addCategory.php">Add New Category</a>
    <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col" colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $category = new category();
        $database = $category->getDatabase();

        $categories=$category->getCategories();
        while($singleCategory=mysqli_fetch_array($categories,MYSQLI_ASSOC))
        {
        ?>
            <tr>
                <td><?php echo $singleCategory['id']; ?></td>
                <td><?php echo $singleCategory['categoryName']; ?></td>
                <td><a class="btn btn-warning text-white" href="updateCategory.php?id=<?php echo $singleCategory['id'];?>">Update</td>
                <td><a class="btn btn-danger" href="deleteCategory.php?id=<?php echo $singleCategory['id'];?>">Delete</td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
        </div>
    <?php include('footer.php'); ?>
</body>
</html>