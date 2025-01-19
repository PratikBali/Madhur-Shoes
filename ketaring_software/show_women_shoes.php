<?php
session_start();
require 'conf/db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$product_name = $_GET['product_name'];

if (isset($_POST['product_name']) && !empty($_POST['product_name'])) {
    $product_name = $_POST['product_name'];
}

// Fetch product details from the database
$ret = "SELECT * FROM women_shoes WHERE product_name = ?";
$stmt = $conn->prepare($ret);
$stmt->bindParam(1, $product_name, PDO::PARAM_STR);
$stmt->execute();
$main_shoes = $stmt->fetch(PDO::FETCH_OBJ);

// Check if main_shoes contains the required properties
if ($main_shoes && isset($main_shoes->up, $main_shoes->bottom, $main_shoes->back)) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="home_material/css/home.css">
    <style>
        /* Your existing styles here */

        @keyframes slideInFromLeft1 {
            from {
                transform: translateX(-100vw) rotate(60deg);
            }
            to {
                transform: translateX(0) rotate(-47deg);
            }
        }

        @keyframes slideInFromLeft2 {
            from {
                transform: translateX(-100vw) rotate(42deg);
            }
            to {
                transform: translateX(0) rotate(42deg);
            }
        }

        @keyframes slideInFromLeft3 {
            from {
                transform: translateX(-100vw) rotate(-190deg);
            }
            to {
                transform: translateX(0) rotate(42deg);
            }
        }

        @keyframes slideInFromLeft4 {
            from {
                transform: translateX(-100vw) rotate(150deg);
            }
            to {
                transform: translateX(0) rotate(-50deg);
            }
        }

        /*@keyframes slideInFromLeft5 {
            from {
                transform: translateX(-100vw) rotate(190deg);
            }
            to {
                transform: translateX(0) rotate(-90deg);
            }
        }*/

        .other-shoes {
            position: absolute;
            bottom: 0;
            display: flex;
            justify-content: space-between;
        }

        .other-shoes1 img {
            width: 25%;
        }

        .other-shoes2 img {
            width: 25%;
        }

        .other-shoes3 img {
            width: 20%; 
        }

        .img-1{
            width: 100%;
            height: 100%;
            filter: drop-shadow(1px 1px 20px #ff007a); 
            animation: slideInFromLeft3 2s ease forwards;
        }
        .img-2{
            width: 100%;
            height: 100%;
            filter: drop-shadow(1px 1px 20px #FFFFFF);
            animation: slideInFromLeft4 2s ease forwards; 
        }
        .img-3{
            width: 100%;
            height: 100%;
            filter: drop-shadow(1px 1px 20px #ff007a); 
            animation: slideInFromLeft3 2s ease forwards;
        }

        .slash-line1 {
            position: relative;
            width: 6px;
            height: 200px;
            background: linear-gradient(45deg, transparent 10%, #ff007a 50%);
            transform: rotate(42deg);
            margin-left: 41%;
            margin-top: -65%;
            animation: slideInFromLeft2 1s ease forwards; /* Apply animation */
        }

        .slash-line2 {
            position: relative;
            width: 6px; 
            height: 200px;
            background: linear-gradient(45deg, transparent 10%, white 50%);
            transform: rotate(42deg); 
            margin-left: 23%; 
            margin-top: -21%;
            animation: slideInFromLeft2 1s ease forwards 0.5s; /* Apply animation with delay */
        }

        .slash-line3 {
            position: relative;
            width: 6px;
            height: 200px;
            background: linear-gradient(45deg, transparent 10%, #ff007a 50%);
            transform: rotate(42deg); 
            margin-left: 8%; 
            margin-top: -16%;
            animation: slideInFromLeft2 1s ease forwards 1s; /* Apply animation with delay */
        }


        .img {
            width: 100px; /* Adjust image size as needed */
            height: 100px;
            margin-top: -5%;
        }

        .carousel-container {
            position: relative;
            width: 400px;
            height: 200px;
            margin: 0 auto;
            overflow: hidden;
            /*animation: slideInFromLeft5 2s ease forwards;*/
            transform: translateX(0) rotate(-90deg);
        }

        .carousel {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
            transform-origin: 50% 100%;
            transition: transform 0.5s ease;
        }

        .carousel img {
            position: absolute;
            width: 25%;
            height: 50%;
            bottom: 0; /* Align to the bottom */
            left: 50%;
            transform-origin: 0 100%; /* Rotate around the bottom center */
            transition: transform 0.5s ease;
            border-radius: 50%;
            filter: drop-shadow(1px 1px 20px white);
        }

        .circular-line {
            position: absolute;
            width: 70px; /* Diameter of the circular line */
            height: 70px; /* Same as width for a circle */
            border: 5px solid #ff007a; /* Set color and thickness */
            border-radius: 50%; /* Make it circular */
            top: 100%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Center it properly */
            z-index: 1; /* Ensure it's above the images */
        }

    </style>
</head>
<body>
    <div class="container">

        <?php include 'conf/nav.php'; ?>

        <div class="main-content">
            <div class="left">
                <h2>Nike Pegasus Custom Trail-Running Shoes 4</h2>
                <p>2250₹</p>
                <div class="size-options">
                    <span>Size:</span>
                    <button>7</button>
                    <button>7.5</button>
                    <button>8</button>
                    <button>8.5</button>
                </div>
                <a id="buy-btn" href="payment2.php?product_name=<?php echo $main_shoes->product_name; ?>">
                    <button class="buy-btn">
                        Buy
                    </button>
                </a>
            </div>
            <div class="right">
                <div id="product-details"></div>
                <img id="main-shoe-image" src="<?php echo $main_shoes->side; ?>" width="100%" 
                    style="margin-top: -30%; margin-left: -50%;
                    animation: slideInFromLeft1 1s ease forwards;" alt="Shoe Image">

                <div>
                    <div class="slash-line1" style="margin-bottom: -22%;"></div>
                    <div class="other-shoes1">
                        <img class="img-1" src="<?php echo $main_shoes->up; ?>" style="transform: rotate(40deg); margin-left: 39%;" alt="Shoe Side">
                    </div>
                </div>

                <div>
                    <div class="slash-line2" style="margin-bottom: -22%;"></div>
                    <div class="other-shoes2">
                        <img class="img-2" src="<?php echo $main_shoes->bottom; ?>" style="transform: rotate(-50deg); margin-left: 15%;" alt="Shoe Up">
                    </div>
                </div>

                <div>
                    <div class="slash-line3" style="margin-bottom: -14%;"></div>
                    <div class="other-shoes3">
                        <img class="img-3" src="<?php echo $main_shoes->back; ?>" style="transform: rotate(44deg); margin-left: 7%;" alt="Shoe Bottom">
                    </div>
                </div>

                <div class="carousel-container" style="margin-top: -60%; margin-left: 53%;">
                <div class="circular-line"></div>
                    <div class="carousel" id="carousel">
                        <?php
                            $sql = "SELECT product_name, side FROM products";
                            $result = $conn->query($sql);

                            if ($result->rowCount() > 0) {
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<img class='img' src='shoes/" . $row['side'] . "' alt='" . $row['side'] . "' onclick='getProductDetails(\"" . $row['side'] . "\")'>";
                                }   
                            } else {
                                echo "<option value=''>No products found</option>";
                            }
                        ?>
                        
                    </div>
                </div>
                <!--div style="text-align: right;">
                    <img class="img-4" style="margin-right:10%; margin-top:5%;" src="<?php //echo $main_shoes->side; ?>" width="20%" alt="Shoe Image">
                    <h3 style="margin-right:7%; margin-top:-1%;">Select Shoes Color</h3>
                </div-->
                            
            </div>
        </div>
    </div>

    <script>
        function getProductDetails(side) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_products.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const product = JSON.parse(this.responseText);
                    
                    if (product.error) {
                        document.getElementById('product-details').innerHTML = product.error;
                    } else {
                        document.querySelector('.left h2').textContent = product.product_name;
                        document.querySelector('.left p').textContent = product.product_price+ ' ₹';
                        document.querySelector('.img-1').src = product.up;
                        document.querySelector('.img-2').src = product.bottom;
                        document.querySelector('.img-3').src = product.back;
                        updateMainShoeImage(side);
                    }
                }
            };
            xhr.send('side=' + side);
        }


        function updateMainShoeImage(side) {
            document.getElementById('main-shoe-image').src = side;
        }

        const carousel = document.getElementById('carousel');
        const images = document.querySelectorAll('.carousel img');
        let angle = 0;

        function applyCarouselStyles() {
            images.forEach((img, index) => {
                const rotation = 360 / images.length * index; // Calculate rotation based on index
                img.style.transform = `rotate(${rotation}deg) translateX(50%)`; // Centering images
            });
        }

        function rotateCarousel() {
            angle -= 45; // Rotate by 45 degrees each time
            carousel.style.transform = `rotate(${angle}deg)`; // Apply rotation to carousel
        }

        applyCarouselStyles(); // Call to apply initial styles
        setInterval(rotateCarousel, 2000); // Change image every 2 seconds
    </script>
</body>
</html>
<?php
} else {
    echo "Product details not found.";
}
?>