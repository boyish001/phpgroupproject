<?php
/* Validation if the page is not in post then redirected to cart  */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cart.php");
    exit();
}


$name_pattern = '/^[a-zA-Z\s]+$/';
$email_pattern = '/^\S+@\S+\.\S+$/';
$street_pattern = '/^[a-zA-Z0-9\s]+$/';
$postal_pattern = '/^[A-Za-z]\d[A-Za-z] \d[A-Za-z]\d$/';
$card_pattern = '/^\d{16}$/';
$cvv_pattern = '/^\d{3}$/';
$phone_pattern = '/^\d{10}$/';

$name_error = $email_error = $city_error = $prov_error = $street_error = $postal_error = $card_error = $cvv_error = $expiry_error = $phone_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if (!preg_match($name_pattern, $name)) {
            $name_error = "Name must contain only letters and spaces";
        }
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (!preg_match($email_pattern, $email)) {
            $email_error = "Invalid email format";
        }
    }

    if (isset($_POST['phone'])) {
        $phone = $_POST['phone'];
        if (!preg_match($phone_pattern, $phone)) {
            $phone_error = "Enter valid 10 digit phone number";
        }
    }

    if (isset($_POST['city'])) {
        $city = $_POST['city'];
        if (!preg_match($name_pattern, $city)) {
            $city_error = "City contains only letter and spaces";
        }
    }

    if (isset($_POST['province'])) {
        $prov = $_POST['province'];
        if (!preg_match($name_pattern, $prov)) {
            $prov_error = "Province contains only letter and spaces";
        }
    }

    if (isset($_POST['street'])) {
        $street = $_POST['street'];
        if (!preg_match($street_pattern, $street)) {
            $street_error = "Street contains only letter, number and spaces";
        }
    }

    if (isset($_POST['postal_code'])) {
        $postal = $_POST['postal_code'];
        if (!preg_match($postal_pattern, $postal)) {
            $postal_error = "Postal code must be in A1A 1A1 format";
        }
    }

    if (isset($_POST['card_number'])) {
        $card = $_POST['card_number'];
        if (!preg_match($card_pattern, $card)) {
            $card_error = "Card number must contain 16 digits";
        }
    }

    if (isset($_POST['expiry_date'])) {
        $expiry_date = $_POST['expiry_date'];
        if (empty($expiry_date)) {
            $expiry_error = "Please select expiry date";
        }
    }

    if (isset($_POST['cvv'])) {
        $cvv = $_POST['cvv'];
        if (!preg_match($cvv_pattern, $cvv)) {
            $cvv_error = "CVV must contain 3 digits";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
</head>
<body>
<?php include('header.php');
    if(!isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['userType']) )
    { 
        echo "<script>alert('You need to login first!!!')</script>";
        echo "<script>window.location.href='login.php'</script>";
    }
    ?>    
    
    <div class="col-sm-8 container animation">
        <div class="content">
            <h2 class="my-5">Checkout</h2>
            <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $chkttl = $_POST['checkouttotal'];
            ?>
            <div>
                <div class="my-4 fs-3 text-center"  style="font-weight: 700; color: brown"><?php echo $chkttl; ?></div>
            </div>
            <?php } ?>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 form-label m-auto ">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control m-0" id="name" name="name" placeholder="Enter your name">
                        <?php if (!empty($name_error)) { ?>
                            <div class="text-danger"><?php echo $name_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 form-label m-auto">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control m-0" id="email" name="email" placeholder="Enter your email">
                        <?php if (!empty($email_error)) { ?>
                            <div class="text-danger"><?php echo $email_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phone" class="col-sm-2 form-label m-auto">Phone:</label>
                    <div class="col-sm-10">
                        <input type="phone" class="form-control m-0" id="phone" name="phone" placeholder="Enter your phone number">
                        <?php if (!empty($phone_error)) { ?>
                            <div class="text-danger"><?php echo $phone_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="checkouttotal" value="<?php echo isset($chkttl) ? $chkttl : ''; ?>">
                    <label class="form-label my-4 text-center">Shipping Details</label>
                    <div class="row">
                        <div class="col-md-6 mb-3 row">
                            <label for="street" class="col-md-4 form-label m-auto ">Street:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control m-0" id="street" name="street" placeholder="Enter your street address">
                                <?php if (!empty($street_error)) { ?>
                                    <div class="text-danger"><?php echo $street_error; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 row">
                            <label for="city" class="col-md-4 form-label m-auto">City:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control m-0" id="city" name="city" placeholder="Enter your city">
                                <?php if (!empty($city_error)) { ?>
                                    <div class="text-danger"><?php echo $city_error; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 row">
                            <label for="province" class="col-md-4 form-label m-auto">Province:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control m-0" id="province" name="province" placeholder="Enter your province">
                                <?php if (!empty($prov_error)) { ?>
                                    <div class="text-danger"><?php echo $prov_error; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 row">
                            <label for="postal_code" class="col-md-4 form-label m-auto">Postal Code:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control m-0" id="postal_code" name="postal_code" placeholder="Enter your postal code">
                                <?php if (!empty($postal_error)) { ?>
                                    <div class="text-danger"><?php echo $postal_error; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <label class="form-label my-4 text-center">Payment Details</label>
                    <div class="mb-3 row">
                        <label for="card_number" class="col-sm-2 form-label m-auto">Card Number:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control m-0" id="card_number" name="card_number" placeholder="Enter your card number">
                            <?php if (!empty($card_error)) { ?>
                                    <div class="text-danger"><?php echo $card_error; ?></div>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="expiry_date" class="col-sm-2 form-label m-auto">Expiry Date:</label>
                        <div class="col-sm-10">
                        <?php $max_date = date('Y-m', strtotime('+5 years')); ?>
                            <input type="month" class="form-control m-0" id="expiry_date" name="expiry_date" placeholder="MM/YYYY" min="<?php echo date('Y-m'); ?>" max="<?php echo $max_date; ?>">
                            <?php if (!empty($expiry_error)) { ?>
                                    <div class="text-danger"><?php echo $expiry_error; ?></div>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="cvv" class="col-sm-2 form-label m-auto">CVV:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control m-0" id="cvv" name="cvv" placeholder="Enter CVV">
                            <?php if (!empty($cvv_error)) { ?>
                                    <div class="text-danger"><?php echo $cvv_error; ?></div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-success p-3 w-25 m-auto text-center rounded mt-5 " name="submit" value="Place Order"/>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <?php 
    include('Database/checkout.php');

    $checkout = new checkout();
    $database = $checkout->getDatabase();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['submit']) && empty($name_error) && empty($email_error) && empty($city_error) && empty($prov_error) && empty($street_error) && empty($postal_error) && empty($card_error) && empty($cvv_error) && empty($phone_error)){

            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $orderID = '';
            $orderID .= 'ORD-';
            $orderID .= date('YmdHis');
            for ($i = 0; $i < 5; $i++) {
                $orderID .= $characters[rand(0, $charactersLength - 1)];
            }

            $orderDate = date('d/m/Y') ;

            $totalString = $chkttl;

            if (preg_match("/\d+\.\d+/", $totalString, $matches)) {
                $number = floatval($matches[0]);
                $total = $number;
            }

            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $prov = $_POST['province'];
            $street = $_POST['street'];
            $postal = $_POST['postal_code'];
            $card = $_POST['card_number'];
            $expiry_date = $_POST['expiry_date'];
            $cvv = $_POST['cvv'];
            $userEmail = $_SESSION['email'];
            $userPassword = $_SESSION['password'];

            $result = $checkout->insertCheckoutForm($orderID,$userEmail,$userPassword,$name,$email,$phone,$street,$city,$prov,$postal,$card,$expiry_date,$cvv,$orderDate,$total);

            if($result) {
                echo "<script>alert('Order Placed Successfully')</script>";
                unset($_SESSION['cart']);
            } else {
                echo "<script>alert('Error Placing Order...');</script>";
            }
            echo "<script>window.location.href='index.php'</script>";
        }
    }           
    
    ?>

</body>
</html>