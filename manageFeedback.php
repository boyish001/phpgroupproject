<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feedbacks</title>
</head>
<body>
    <?php 
    include('header.php'); 
    include('Database/feedback.php'); 
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
    <h1 class="text-center my-5">Feedbacks</h1>
    <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Message</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 

        $feedback = new feedback();
        $database = $feedback->getDatabase();
        
        $feedbacks = $feedback->getFeedbacks();
        
        while($singleFeedback=mysqli_fetch_array($feedbacks,MYSQLI_ASSOC))
        {
        ?>
            <tr>
                <td><?php echo $singleFeedback['id']; ?></td>
                <td><?php echo $singleFeedback['name']; ?></td>
                <td><?php echo $singleFeedback['phone']; ?></td>
                <td><?php echo $singleFeedback['email']; ?></td>
                <td><?php echo $singleFeedback['message']; ?></td>
                <td><a class="btn btn-danger" href="deletefeedback.php?id=<?php echo $singleFeedback['id'];?>">Delete</td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
        </div>
    <?php include('footer.php'); ?>
</body>
</html>