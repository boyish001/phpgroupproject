<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['btnRegister']))
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if(empty($firstName))
        {
            $firstNameError = "First Name is required!!!";
        }
        else if(preg_match("/[\d!@#$%^&*()_+{}\[\]:;\'\\<>,.?\/`~\-|=]/",$firstName))
        {
            $firstNameError = "First name cannot contain special charaters or digits!!!";
        }
        else{
            $firstNameError = "";
        }

        if(empty($lastName))
        {
            $lastNameError = "Last Name is required!!!";
        }
        else if(preg_match("/[\d!@#$%^&*()_+{}\[\]:;\'\\<>,.?\/`~\-|=]/",$lastName))
        {
            $lastNameError = "Last name cannot contain special charaters or digits!!!";
        }
        else{
            $lastNameError = "";
        }

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

        if(empty($confirmPassword))
        {
            $confirmPasswordError = "Confirm Password is required!!!";
        }
        else if($password != $confirmPassword)
        {
            $confirmPasswordError = "Password and Confirm Password must be same!!!";
        }
        else{
            $confirmPasswordError = "";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container animation">
    <div class="row justify-content-center">
        <div class="col-md-6 p-5">
            <div class="text-center fs-1 fw-bold">
                Register
            </div>

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="row">
                <div class="form-group mt-3 col">
                    <label>First Name</label>
                    <input name="firstName" id="firstName" class="form-control">
                    <span class="fw-bold text-danger">
                        <?php if(isset($firstNameError)) { echo $firstNameError; } ?>
                    </span>
                </div>

                <div class="form-group mt-3 col">
                    <label>Last Name</label>
                    <input name="lastName" id="lastName" class="form-control">
                    <span class="fw-bold text-danger">
                        <?php if(isset($lastNameError)) { echo $lastNameError; } ?>
                    </span>
                </div>
            </div>
            
            <div class="form-group mt-3">
                <label>Email</label>
                <input name="email" id="email" class="form-control">
                <span class="fw-bold text-danger">
                        <?php if(isset($emailError)) { echo $emailError; } ?>
                </span>
            </div>

            <div class="form-group mt-3">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <span class="fw-bold text-danger">
                        <?php if(isset($passwordError)) { echo $passwordError; } ?>
                </span>
            </div>

            <div class="form-group mt-3">
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                <span class="fw-bold text-danger">
                        <?php if(isset($confirmPasswordError)) { echo $confirmPasswordError; } ?>
                </span>
            </div>

            <div class="text-center">
                <button class="mt-2 me-2 py-1 px-4 btn btn-primary" name="btnRegister" id="btnRegister">Register</button>
                <button class="mt-2 py-1 px-4 btn btn-danger" onClick="location.href='index.php'">Cancel</button>
            </div>
            </form>

            <div class="text-center mt-4 fs-4">
                Already Registered? <a href="login.php" class="text-dark">Login Here</a>
            </div>
        </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if(isset($_POST['btnRegister'])) 
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $userType = "User";

        if(empty($firstNameError) && empty($lastNameError) && empty($emailError) 
            && empty($passwordError) && empty($confirmPasswordError)) {

            require('Database/user.php');

            $user = new user();
            $database = $user->getDatabase();

            $ifExist = $user->loginUser($email,$password);

            if(mysqli_num_rows($ifExist)>0)
            {
                echo "<script>alert('An account with same email and password exists, please login...');</script>";
                echo "<script>window.location.href='login.php'</script>";
            }
            else
            {
                $result = $user->registerUser($firstName,$lastName,$email,$password,$userType);

                if($result) {
                    echo "<script>alert('You are registered successfully...');</script>";
                    echo "<script>window.location.href='login.php'</script>";
                } else {
                    echo "<script>alert('Error registering...');</script>";
                    echo "<script>window.history.back()</script>";
                }
            }
        }
    }  
}
?>
