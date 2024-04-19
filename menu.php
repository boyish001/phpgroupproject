<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <title>Menu</title>
</head>

<body>
    <?php
    include ('header.php');
    require ('Database/product.php');

    $product = new product();
    $database = $product->getDatabase();
    ?>
    <div class="animation">
        <div class="dropdown">
            <div class="text-center" style="padding-bottom:15px">
                <button class="btn btn-primary my-2 dropdown-toggle " style="width:20%" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Categories
                </button>

                <ul class="dropdown-menu fs-6" style="width:20%" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item fs-5" href="menu.php?cat=all">All Products</a></li>

                    <?php
                    $all = $product->getCategories();
                    while ($cat = mysqli_fetch_array($all, MYSQLI_ASSOC)) { ?>
                        <li>
                            <a class="dropdown-item fs-5" href="menu.php?cat=<?php echo $cat["id"]; ?>">
                                <?php echo $cat["categoryName"]; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
            $all = $product->getProducts();

            if (isset($_GET['cat'])) {
                $nm = $_GET['cat'];
                if ($nm == "all") {
                    $all = $product->getProducts();
                } else {
                    $all = $product->getProductByCategory($nm);
                }
            }
            ?>
            <div class="menucontainer">
                <?php
                while ($cat = mysqli_fetch_array($all, MYSQLI_ASSOC)) {
                    ?>
                    <div class="card align-items-center">
                        <img class="card-img-top" src="<?php echo $cat['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $cat['name']; ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $cat['price']; ?>
                            </p>
                            <a href="productDetails.php?id=<?php echo $cat['id']; ?>" class="btn btn-primary"></i>View
                                Details</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <?php include ('footer.php'); ?>
        </div>
        </div>
    </div>
</body>

</html>