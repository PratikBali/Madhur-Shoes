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

        <!-- TemplateMo 571 Hexashop https://templatemo.com/tm-571-hexashop -->

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
        <div class="page-heading" id="top">
            
        </div>
        <!-- ***** Main Banner Area End ***** -->


        <!-- ***** Products Area Starts ***** -->
        <section class="section" id="products">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>Our All Men's Shoes</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <?php
                        $sql = "SELECT * FROM main_shoes 
                        WHERE category = 'male'
                        ORDER BY id DESC";
                        $result = $conn->query($sql);

                        if ($result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <div class="col-lg-4">
                            <div class="item">

                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li>
                                                <a href="show_men_shoes.php?product_color=<?php echo $row['product_color'];?>&product_name=<?php echo $row['product_name']; ?>&category=<?php echo $row['category']; ?>">
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
                        </div>
                    <?php
                            }
                        }
                    ?>
                    
                </div>
            </div>

        </section>
        <!-- ***** Products Area Ends ***** -->
        
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