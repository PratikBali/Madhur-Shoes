<?php
session_start();
require 'conf/db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>shoes shop</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="men/assets/css/bootstrap.min.css"> 

    <link rel="stylesheet" type="text/css" href="men/assets/css/font-awesome.css">

    <link rel="stylesheet" href="men_styles.css">

    <link rel="stylesheet" href="men/assets/css/owl-carousel.css"> 
 <style>
    .full-width {
        width: 100%;
        background-color: white;
        display: block;
      }
 </style>
    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
        <?php include 'conf/men_header.php'; ?>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content">
                        <div class="thumb">
                            <div class="inner-content">
                                <h4>Step Into Style</h4>
                                <span>Awesome, Stylist &amp; Branded Shoes</span>
                                <!--div class="main-border-button">
                                    <a href="#">Purchase Now!</a>
                                </div-->
                            </div>
                            <img src="men/assets/images/left-banner-image.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Women</h4>
                                            <span>Best Shoes For Women</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Women</h4>
                                                <div class="main-border-button">
                                                    <a href="women.php">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php
                                            $sql = "SELECT * FROM main_shoes 
                                            WHERE category = 'female'
                                            ORDER BY id DESC LIMIT 1";
                                            $result = $conn->query($sql);

                                            if ($result->rowCount() > 0) {
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <img src="<?php echo $row['side']; ?>" class='full-width'>
                                        <?php
                                                }
                                            }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Men</h4>
                                            <span>Best Shoes For Men</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Men</h4>
                                                <div class="main-border-button">
                                                    <a href="men.php">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php
                                            $sql = "SELECT * FROM main_shoes 
                                            WHERE category = 'male'
                                            ORDER BY id DESC LIMIT 1";
                                            $result = $conn->query($sql);

                                            if ($result->rowCount() > 0) {
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <img src="<?php echo $row['side']; ?>" class='full-width'>
                                        <?php
                                                }
                                            }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Women</h4>
                                            <span>Best Shoes For Women</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Women</h4>
                                                <div class="main-border-button">
                                                    <a href="women.php">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php
                                            $sql = "SELECT * FROM main_shoes 
                                            WHERE category = 'female'
                                            ORDER BY id DESC LIMIT 1 OFFSET 1";
                                            $result = $conn->query($sql);

                                            if ($result->rowCount() > 0) {
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <img src="<?php echo $row['side']; ?>" class='full-width'>
                                        <?php
                                                }
                                            }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Men</h4>
                                            <span>Best Shoes For Mens</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Men</h4>
                                                <div class="main-border-button">
                                                    <a href="men.php">Discover More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                            $sql = "SELECT * FROM main_shoes 
                                            WHERE category = 'male'
                                            ORDER BY id DESC LIMIT 1 OFFSET 1";
                                            $result = $conn->query($sql);

                                            if ($result->rowCount() > 0) {
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <img src="<?php echo $row['side']; ?>" class='full-width'>
                                        <?php
                                                }
                                            }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->
 
    <!-- ***** Men Area Starts ***** -->
    <section class="section" id="men">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Men's Latest Shoes</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="men-item-carousel">
                        <div class="owl-men-item owl-carousel">
                            <?php
                                $sql = "SELECT * FROM main_shoes 
                                WHERE category = 'male'
                                ORDER BY id DESC LIMIT 3";
                                $result = $conn->query($sql);

                                if ($result->rowCount() > 0) {
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <div class="item">

                                    <div class="thumb">
                                        <div class="hover-content">
                                            <ul>
                                                <li>
                                                    <a href="show_men_shoes.php?product_color=<?php echo $row['product_color'];?>&product_name=<?php echo $row['product_name'];?>&category=<?php echo $row['category'];?>">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <img style="filter: drop-shadow(1px 1px 20px #FFFFFF);" src="<?php echo $row['side']; ?>" alt="">
                                    </div>
                                    <div class="down-content text-center">
                                        <h4><?php echo $row['product_name']; ?></h4>
                                        <span><?php echo $row['product_price']; ?>₹</span>
                                    </div>

                                </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        
                        <div class="main-border-button" style="margin-top: 5%; display: flex; justify-content: center; align-items: center; text-align:center;">
                            <a href="men.php">More Shoes</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Men Area Ends ***** -->

    <!-- ***** Women Area Starts ***** -->
    <section class="section" id="women">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Women's Latest Shoes</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="women-item-carousel">
                        <div class="owl-women-item owl-carousel">
                            <?php
                                $sql = "SELECT * FROM main_shoes 
                                WHERE category = 'female'
                                ORDER BY id DESC LIMIT 3";
                                $result = $conn->query($sql);
                                
                                if ($result->rowCount() > 0) {
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="item">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li>
                                                <a href="show_men_shoes.php?product_color=<?php echo $row['product_color'];?>&product_name=<?php echo $row['product_name'];?>&category=<?php echo $row['category'];?>">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <img style="filter: drop-shadow(1px 1px 20px #FFFFFF);" src="<?php echo $row['side']; ?>" alt="">
                                </div>
                                <div class="down-content text-center">
                                    <h4><?php echo $row['product_name']; ?></h4>
                                    <span><?php echo $row['product_price']; ?>₹</span>
                                </div>
                            </div>

                            <?php
                                    }
                                }
                            ?>
                            
                        </div>
                        
                        <div class="main-border-button" style="margin-top: 5%; display: flex; justify-content: center; align-items: center; text-align:center;">
                            <a href="women.php">More Shoes</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Women Area Ends ***** -->
    
    <!-- ***** Footer Start ***** -->
        <?php include 'conf/men_footer.php'; ?>
    <!-- ***** Footer End ***** -->
    
    
    <!-- jQuery -->
    <script src="men/assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="men/assets/js/popper.js"></script>
    <script src="men/assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="men/assets/js/owl-carousel.js"></script>
    <script src="men/assets/js/accordions.js"></script>
    <script src="men/assets/js/datepicker.js"></script>
    <script src="men/assets/js/scrollreveal.min.js"></script>
    <script src="men/assets/js/waypoints.min.js"></script>
    <script src="men/assets/js/jquery.counterup.min.js"></script>
    <script src="men/assets/js/imgfix.min.js"></script> 
    <script src="men/assets/js/slick.js"></script> 
    <script src="men/assets/js/lightbox.js"></script> 
    <script src="men/assets/js/isotope.js"></script> 
    
    <!-- Global Init -->
    <script src="men/assets/js/custom.js"></script>

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>

  </body>
</html>