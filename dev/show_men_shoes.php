<?php
session_start();
require 'conf/db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$product_name = $_GET['product_name'];
$product_color = $_GET['product_color'];
$category = $_GET['category'];

if (isset($_POST['product_color']) && !empty($_POST['product_color'])) {
    $product_color = $_POST['product_color'];
}

// Fetch product details from the database
$ret = "SELECT * FROM main_shoes WHERE product_color = ? 
                                 AND product_name = ? 
                                 AND category = ?
        ";
$stmt = $conn->prepare($ret);
$stmt->execute([$product_color, $product_name, $category]);
$main_shoes = $stmt->fetch(PDO::FETCH_OBJ);

// Check if main_shoes contains the required properties
if ($main_shoes && isset($main_shoes->product_name, $main_shoes->up, $main_shoes->bottom, $main_shoes->back)) {
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

        @keyframes slideInFromLeft5 {
            from {
                transform: translateX(-100vw) rotate(-190deg);
            }
            to {
                transform: translateX(0) rotate(50deg);
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
            width: 18%;
        }

        .other-shoes2 img {
            width: 18%;
        }

        .other-shoes3 img {
            width: 14%; 
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
            animation: slideInFromLeft5 2s ease forwards;
        }

        .slash-line1 {
            position: relative;
            width: 6px;
            height: 200px;
            background: linear-gradient(45deg, transparent 10%, #ff007a 50%);
            transform: rotate(42deg);
            margin-left: 75%;
            margin-top: -45%;
            animation: slideInFromLeft2 1s ease forwards; /* Apply animation */
        }

        .slash-line2 {
            position: relative;
            width: 6px; 
            height: 200px;
            background: linear-gradient(45deg, transparent 10%, white 50%);
            transform: rotate(42deg); 
            margin-left: 62%; 
            margin-top: -15%;
            animation: slideInFromLeft2 1s ease forwards 0.5s; /* Apply animation with delay */
        }

        .slash-line3 {
            position: relative;
            width: 6px;
            height: 200px;
            background: linear-gradient(45deg, transparent 10%, #ff007a 50%);
            transform: rotate(42deg); 
            margin-left: 50%; 
            margin-top: -15%;
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

        .size-options button.active {
            background-color: #ff007a; /* Change this color to your desired highlight color */
            color: white;
        }

    </style>
</head>
<body>
    <div class="container">
        
        <?php include 'conf/nav.php'; ?>

        <div class="main-content"> 
            <div class="right">
                <div id="product-details-container" style="position: relative;">
                    <img id="main-shoe-image" src="<?php echo $main_shoes->side; ?>" width="70%" 
                        style="margin-top: -20%; margin-left: 10%; animation: slideInFromLeft1 1s ease forwards;" 
                        alt="Shoe Image">
            
                    <div class="left" style="position: absolute; top: 0%; left: 0%; color: white; padding: 10px; border-radius: 10px;">
                        <h2><?php echo $main_shoes->product_name; ?></h2>
                        <p><?php echo $main_shoes->product_price; ?> ₹</p>
                        <h3>Color :- <?php echo $main_shoes->product_color; ?></h3>
                        <div class="size-options">
                            <span>Size:</span>
                            <button id="size-6">6</button>
                            <button id="size-7">7</button>
                            <button id="size-8">8</button>
                            <button id="size-9">9</button>
                            <button id="size-10">10</button>
                        </div>
                        <h4>Category :- <?php echo $main_shoes->category; ?></h4>
                        <a id="buy-btn" href="address/address.php?product_color=<?php echo $main_shoes->product_color; ?>&product_name=<?php echo $main_shoes->product_name; ?>&size=&category=<?php echo $main_shoes->category; ?>">
                            <button class="buy-btn">
                                Buy
                            </button>
                        </a>

                    </div>

                    <div>
                        <div class="slash-line1" style="margin-bottom: -15%;"></div>
                        <div class="other-shoes1">
                            <img class="img-1" src="<?php echo $main_shoes->up; ?>" style="transform: rotate(40deg); margin-left: 74%;" alt="Shoe Side">
                        </div>
                    </div>

                    <div>
                        <div class="slash-line2" style="margin-bottom: -16%;"></div>
                        <div class="other-shoes2">
                            <img class="img-2" src="<?php echo $main_shoes->bottom; ?>" style="transform: rotate(-50deg); margin-left: 57%;" alt="Shoe Up">
                        </div>
                    </div>

                    <div>
                        <div class="slash-line3" style="margin-bottom: -9%;"></div>
                        <div class="other-shoes3">
                            <img class="img-3" src="<?php echo $main_shoes->back; ?>" style="transform: rotate(48deg); margin-left: 50%;" alt="Shoe Bottom">
                        </div>
                    </div>

                    <div class="carousel-container" style="margin-top: -40%; margin-right: -25%;">
                        <div class="circular-line"></div>
                        <div class="carousel" id="carousel">
                            <?php
                                $product_name = $_GET['product_name'];
                                $category = $_GET['category'];
                                $sql = "SELECT product_name, side FROM main_shoes WHERE product_name=?AND category=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$product_name, $category]);
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                                if ($stmt->rowCount() > 0) {
                                    foreach ($result as $row) {
                                        echo "<img class='img' src='shoes/" . $row['side'] . "' alt='" . $row['side'] . "' onclick='getProductDetails(\"" . $row['side'] . "\")'>";
                                    }
                                } else {
                                    echo "<option value=''>No products found</option>";
                                }

                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const sizeButtons = document.querySelectorAll('.size-options button');
            let selectedSize = null;

            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    sizeButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to the clicked button
                    this.classList.add('active');

                    // Update the selected size
                    selectedSize = this.textContent;

                    // Update the Buy button's href
                    const productColor = "<?php echo $main_shoes->product_color; ?>";
                    const productName = "<?php echo $main_shoes->product_name; ?>";
                    const productCategory = "<?php echo $main_shoes->category; ?>";
                    updateBuyButton(productColor, productName, selectedSize, productCategory);
                });
            });

            const buyButton = document.getElementById('buy-btn');
            buyButton.addEventListener('click', function(event) {
                if (!selectedSize) {
                    event.preventDefault(); // Prevent default action
                    alert('Please select a size before proceeding.');
                }
            });

        });


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
                        document.querySelector('.left h3').textContent = 'Color :- ' + product.product_color;
                        document.querySelector('.img-1').src = product.up;
                        document.querySelector('.img-2').src = product.bottom;
                        document.querySelector('.img-3').src = product.back;
                        updateMainShoeImage(side);
                        updateBuyButton(product.product_color, product.product_name);
                    }
                }
            };
            xhr.send('side=' + side);
        }


        function updateMainShoeImage(side) {
            document.getElementById('main-shoe-image').src = side;
        }

        function updateBuyButton(productColor, productName, size, category) {
            const buyButton = document.getElementById('buy-btn');
            buyButton.href = `address/address.php?product_color=${productColor}&product_name=${productName}&size=${size}&category=${category}`;
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