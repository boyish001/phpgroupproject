<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnLogin']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email))
        {
            $emailError = "Email is required!!!";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $emailError = "Enter valid Email Address!!!";
        }
        else{
            $emailError = "";
        }

        if(empty($password))
        {
            $passwordError = "Password is required!!!";
        }
        else{
            $passwordError = "";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    
    <?php include('header.php'); ?>
    
    <div class="container animation">
    <div class="row justify-content-center">
        <div class="col-md-6 p-5">
            <div class="text-center fs-1 fw-bold">
                Login
            </div>
            
            <form name="loginForm" method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input name="email" class="form-control ">
                <span class="fw-bold text-danger">
                        <?php if(isset($emailError)) { echo $emailError; } ?>
                </span>
            </div>

            <div class="form-group mt-3">
                <label for="lastName">Password</label>
                <input type="password" name="password" class="form-control ">
                <span class="fw-bold text-danger">
                <?php if(isset($passwordError)) { echo $passwordError; } ?>
                </span>
            </div>

            <div class="text-center">
                <button  name="btnLogin" class="mt-2 me-2 py-1 px-4 btn btn-primary">Login</button>
                <button class="mt-2 py-1 px-4 btn btn-danger">Cancel</button>
            </div>

            <div class="text-center mt-4 fs-4 bottomMargin">
                New User? <a href="register.php" class="text-dark">Register Here</a>
            </div>
        </form>
        </div>
    </div>
</div>

    <?php include('footer.php'); ?>
</body>
</html>


<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnLogin']))
    {
        require('Database/user.php');

        $user = new user();
        $database = $user->getDatabase();

        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if(empty($emailError) && empty($passwordError)) {

            $temp = $user->loginUser($email,$password);

            $data = mysqli_fetch_array($temp);

            if($data['email']==$email && $data['password']==$password)
            {
                if($data['userType'] == "Admin")
                {
                    echo "<script>alert(`Welcome Admin...`);</script>";
                }
                else
                {
                    echo "<script>alert(`Logged in successfully...`);</script>";
                }

                $_SESSION['userType'] = $data['userType'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['password'] = $data['password'];
                
                echo "<script>window.location.href='index.php'</script>";
            }
            else
            { 
                echo "<script>alert('Invalid Credentials........')</script>";
                echo "<script>window.location.href='login.php'</script>";
            }
        }
    }
}

?>