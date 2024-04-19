<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
</head>
<body>
    <?php 
    include('header.php'); 
    require('Database/product.php');

    $product = new product();
    $database = $product->getDatabase();

    if(!isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['userType']))
    { 
        echo "<script>alert('You need to login first!!!')</script>";
        echo "<script>window.location.href='login.php'</script>";
    }
    ?>
    <main>
        <?php
        if(empty($_SESSION['cart'])) {
            echo "<div class='container text-center'><h2 class='text-center my-5'>Your cart is empty</h2>";
            echo "<img class='emptycart' src='images/emptycart.png' alt='Empty Cart'></div>";
        } else {
            $cartProducts = array();
            $cartTotal=0;
            foreach($_SESSION['cart'] as $productID){

                $res = $product->getProductByID($productID);
                
                if($res && mysqli_num_rows($res) > 0) {
                    $productDetails = mysqli_fetch_assoc($res);
                    array_push($cartProducts, $productDetails);
                }
            }
            ?>
            
            <div class="container animation">
            <h2>Cart</h2>
            
            <table class="text-center table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($cartProducts as $product) {  
                $priceStr = str_replace('$','', $product['price']);
                $priceNum = (float) $priceStr;
                
                $quantity = 1;
                if (isset($_POST['qty_' . $product['id']])) {
                    $quantity = intval($_POST['qty_' . $product['id']]);
                }
                
                $totalPrice = $priceNum * $quantity; 

                $cartTotal = $cartTotal + $totalPrice?>
                <tr>
                    <td><img class="img-fluid mx-auto d-block img-thumbnail cart-img" src="<?php echo $product['image']; ?>" alt="Cart Product Image"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td id="price_<?php echo $product['id']; ?>"><?php echo $product['price']; ?></td>
                    <td>
                        <div class="input-group cartqty text-center">
                            <button class="btn btn-outline-secondary" type="button" onclick="updQty(this, '<?php echo $product['id']; ?>', 'dec')">-</button>
                            <input type="text" class="form-control m-0 cart-ip" value="<?php echo $quantity; ?>" name="qty_<?php echo $product['id'];?>" disabled>
                            <button class="btn btn-outline-secondary" type="button" onclick="updQty(this, '<?php echo $product['id']; ?>', 'inc')">+</button>
                        </div>
                    </td>
                    <td id="total_<?php echo $product['id']; ?>"><?php echo '$' . $totalPrice ?></td>
                    <td>
                        <form method='post' action='deletecartitem.php'>
                            <input type='hidden' name='delete_id' value='<?php echo $product['id']; ?>'>
                            <button type='submit' class='btn btn-warning text-black'>Remove</button>
                        </form>
                    </td>     
                </tr>
            <?php } ?>
            </tbody>
        </table>

            <div class="d-flex justify-content-end">
                <form method='post' action='clearcart.php'>
                    <button type='submit' name='clear_cart' class='btn btn-danger'>Clear Cart</button>
                </form>
            </div>
            
        <?php
        }
        ?>
        <form method="post" action="checkout.php" class="text-center">
        <?php if (!empty($_SESSION['cart'])) { ?>
            
            <input type="text" name="checkouttotal" class="form-control m-0 bg-primary text-white p-3 w-25 m-auto text-center rounded totalbox" id="cartTotal" value="Total: $<?php echo number_format($cartTotal, 2); ?>" readonly>
            <input type="submit" class="btn btn-success p-3 w-25 m-auto text-center rounded mt-5 " value="Proceed to Checkout" />            
        <?php } ?>
        </form>
        </div>
        
        </div>
        
    </main>
    <?php include('footer.php'); ?>

    <script>
        function updQty(element, productID, action) {
            var input = element.parentElement.querySelector('input');
            var qty = parseInt(input.value);
            if (action === 'inc' && qty < 10) {
                input.value = qty + 1;
            } else if (action === 'dec' && qty > 1) {
                input.value = qty - 1;
            }
            updateTtl(productID, input.value);
        }

        function updateTtl(productID, quantity) {
            var total=0;
            var price = parseFloat(document.querySelector('#price_' + productID).innerText.replace('$', ''));
            total = price * quantity;
            document.querySelector('#total_' + productID).innerText = '$' + total.toFixed(2);
            
            // Update cart total
            var cartTotal = 0;
            var totalElements = document.querySelectorAll('[id^=total_]');
            totalElements.forEach(function(element) {
                cartTotal += parseFloat(element.innerText.replace('$', ''));
            });
            document.getElementById('cartTotal').value = 'Total: $' + cartTotal.toFixed(2);
        }
    </script>
</body>
</html>