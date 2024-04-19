<?php

require('Database/feedback.php');

$feedback = new feedback();
$database = $feedback->getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['submitBtn']))
    {
        $fName = $_POST['fName'];
        $fPhone = $_POST['fPhone'];
        $fEmail = $_POST['fEmail'];
        $fMessage = $_POST['fMessage'];

        if(empty($fName))
        {
            $fNameError = "Name is required!!!";
        }
        else{
            $fNameError = "";
        }

        if(empty($fPhone))
        {
            $fPhoneError = "Phone is required!!!";
        }
        else if(!preg_match("/^[+-]?\d+$/",$fPhone))
        {
            $fPhoneError = "Enter valid phone number!!!";
        }
        else{
            $fPhoneError = "";
        }

        if(empty($fEmail))
        {
            $fEmailError = "Email is required!!!";
        }
        else if(!filter_var($fEmail, FILTER_VALIDATE_EMAIL))
        {
            $fEmailError = "Enter valid Email Address!!!";
        }
        else{
            $fEmailError = "";
        }

        if(empty($fMessage))
        {
            $fMessageError = "Message is required!!!";
        }
        else{
            $fMessageError = "";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
</head>
<body>
    <?php include('header.php'); ?>
    
    <main>
        <div class="text-center fs-3 fw-bold">
            Connect with us...
        </div>
    <br>
        <div class="address">
            <ul>
                <li>Phone: +61 525 240 310, 1234567890, 56847-98562</li>
                <li>Address: 239, Brave street, Kitchener.</li>
                <li>Email:info@cloudchocolate.com</li>
            </ul>
        </div>
        <br><br>
        <div class="map">
            <iframe width="80%" height="500" frameborder="0"
                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=299%20Doon%20Valley%20Dr,%20Kitchener,%20ON%20N2G%204M4+(Our%20College)&amp;t=k&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
        <br><br><br>
        <div class="content container">
            <h2 class="text-start">Provide your feedback to us</h2>
            <br>
            
            <form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
                <label for="name">Name</label>
                <input type="text" name="fName">
                <span class="fw-bold text-danger">
                        <?php if(isset($fNameError)) { echo $fNameError; } ?>
                </span>

                <label for="phone">Phone</label>
                <input type="tel" name="fPhone">
                <span class="fw-bold text-danger">
                        <?php if(isset($fPhoneError)) { echo $fPhoneError; } ?>
                </span>

                <label for="email">Email</label>
                <input type="email" name="fEmail">
                <span class="fw-bold text-danger">
                        <?php if(isset($fEmailError)) { echo $fEmailError; } ?>
                </span>

                <label for="message">Message</label>
                <textarea name="fMessage" rows="6"></textarea>
                <span class="fw-bold text-danger">
                        <?php if(isset($fMessageError)) { echo $fMessageError; } ?>
                </span>
                <br>
                <button type="submit" name="submitBtn" class="btn btn-primary px-4">Submit</button>
            </form>
            
        </div>

        <br><Br>

        <section class="contact container">
            <h2>Customer Testimonials</h2>
            <?php
            $result = $feedback->getRandomFeedbacks();
             if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="testimonial text-center">';
                    echo '<p>"' . $row['message'] . '"</p>';
                    echo '<p class="testimonial-author">- ' . $row['name']. '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No testimonials available.</p>';
            }
            ?>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['submitBtn']))
    {
        $fName = $_POST['fName'];
        $fPhone = $_POST['fPhone'];
        $fEmail = $_POST['fEmail'];
        $fMessage = $_POST['fMessage'];

        if(empty($fNameError) && empty($fMessageError) && empty($fEmailError) && empty($fMessageError))
        {
            $result = $feedback->insertFeedback($fName,$fPhone,$fEmail,$fMessage);

            if($result) {
                echo "<script>alert('Thank you for your feedback...');</script>";
                echo "<script>window.location.href='contact.php'</script>";
            } else {
                echo "<script>alert('Error submitting feedback...');</script>";
                echo "<script>window.history.back()</script>";
            }
        }
    }
}