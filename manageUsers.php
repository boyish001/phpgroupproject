<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users</title>
</head>
<body>
    <?php 
        include('header.php'); 
        include('Database/user.php'); 

        $user = new user();
        $database = $user->getDatabase();

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
    <h1 class="text-center my-5">Users</h1>
    <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">User Type</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $users = $user->getAllUsers();
        while($singleUser=mysqli_fetch_array($users,MYSQLI_ASSOC))
        {
        ?>
            <tr>
                <td><?php echo $singleUser['id']; ?></td>
                <td><?php echo $singleUser['firstName']; ?></td>
                <td><?php echo $singleUser['lastName']; ?></td>
                <td><?php echo $singleUser['email']; ?></td>
                <td><?php echo $singleUser['password']; ?></td>
                <td><?php echo $singleUser['userType']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
        </div>
    <?php include('footer.php'); ?>
</body>
</html>