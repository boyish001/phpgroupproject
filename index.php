<?php

$apiKey = '62d8b3ce353c6db94ca6f8272096854c';
$city = 'Kitchener';
$weatherUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

$response = file_get_contents($weatherUrl);

if ($response) {
    $weatherData = json_decode($response, true);

    if ($weatherData && $weatherData['cod'] == 200) {
        $cityName = $weatherData['name'];
        $weatherDesc = $weatherData['weather'][0]['description'];
        $temp = $weatherData['main']['temp'];
        $minTemp = $weatherData['main']['temp_min'];
        $maxTemp = $weatherData['main']['temp_max'];
        $humidity = $weatherData['main']['humidity'];
        $windSpeed = $weatherData['wind']['speed'];
        $countryCode = $weatherData['sys']['country'];
    } else {
        echo "Error fetching weather data.";
    }
} else {
    echo "Error fetching weather data. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cloud Kitchen</title>
</head>

<body>
    <?php require_once('Database/initializeDatabase.php'); ?>
    <?php include('header.php'); ?>
    <div class="cover-photo">
        <div class="cover-text">
            <h1>Taste the Difference. From Our brands</h1>
            <h5>Discover the finest flavors of chocolates delivered straight to your doorstep</h5>
            <a href="menu.php" class="menu-button">Order Now</a>
        </div>
    </div>

    <div class="container weatherContainer mt-5">
    <h2 class="text-center">Current Weather in <?php echo $cityName . ", " . $countryCode; ?></h2>
    <h4 class="text-center">Condition : <?php echo $weatherDesc; ?></h4>
    <h4 class="text-center">Temperature : <?php echo $temp . "&deg;" . "C" . " " . " [" . $minTemp . "&deg;" . "C" . " - " . $maxTemp . "&deg;" . "C" . "]"; ?></h4>
    <h4 class="text-center">Humidity : <?php echo $humidity. "%"; ?></h4>
    <h4 class="text-center">Wind Speed : <?php echo $windSpeed . "m/s"; ?></h4>
    </div>

    <div class="container"> <br><Br>
        <h3 class="text-center">Today's Special Chocolates</h3>
        <br>
        <h5 class="text-center" > Discover the joy of chocolate today. With convenient online ordering, fast shipping, and exceptional customer service, we make it easy to indulge in your favorite treats whenever the craving strikes.</h5>
        <?php
        include('Database/product.php'); 

        $product = new product();
        $database = $product->getDatabase();

        $random_products = $product->getRandomProducts();
        ?>
        <div class="menucontainer">
            <?php
            while ($product = mysqli_fetch_array($random_products, MYSQLI_ASSOC)) {
                ?>
                <div class="card align-items-center">
                        <img class="card-img-top" src="<?php echo $product['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $product['name']; ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $product['price']; ?>
                            </p>
                            <a href="productDetails.php?id=<?php echo $product['id']; ?>" class="btn btn-primary"></i>View
                                Details</a>
                        </div>
                    </div>
            <?php
            }
            ?>
        </div>
        <div class="container index-container">
        <br><br>
        <h3 class="text-center">Our Mission</h3>
        <br>
        <p class="fs-5">
        At Cloud Kitchen, 

        <br><br>
        We believe that indulging in delicious chocolates should be convenient and accessible to everyone. With our easy-to-use online platform, fast shipping, and exceptional customer service, we make it simple for customers to satisfy their chocolate cravings anytime, anywhere.
Ultimately, our mission is to spread joy through chocolate. Whether it's a special treat for yourself or a thoughtful gift for a loved one, we believe that chocolate has the power to brighten any day and create moments of happiness and connection.
        </p>
        </div>
        <br><br>
        <h3 class="text-center">Special Signarture Chocolates</h3>
        <br>
        <?php
        $product = new product();
        $random_products = $product->getRandomProducts();
        ?>
        <div class="menucontainer">
            <?php
            while ($product = mysqli_fetch_array($random_products, MYSQLI_ASSOC)) {
                ?>
                <div class="card align-items-center">
                        <img class="card-img-top" src="<?php echo $product['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $product['name']; ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $product['price']; ?>
                            </p>
                            <a href="productDetails.php?id=<?php echo $product['id']; ?>" class="btn btn-primary"></i>View
                                Details</a>
                        </div>
                    </div>
            <?php
            }
            ?>
        </div>

        </div>
        <?php include('footer.php'); ?>
</body>

</html>
