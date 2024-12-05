<?php
session_start();
require '../conf/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_color = $_POST['product_color'];
    $category = $_POST['category'];
    $size_1 = $_POST['size_1'];
    $size_2 = $_POST['size_2'];
    $size_3 = $_POST['size_3'];
    $size_4 = $_POST['size_4'];
    $size_5 = $_POST['size_5'];
    $size_6 = $_POST['size_6'];
    $size_7 = $_POST['size_7'];
    $size_8 = $_POST['size_8'];
    $size_9 = $_POST['size_9'];
    $size_10 = $_POST['size_10'];
    $quantity = $_POST['quantity'];

    $size_1_original_price = $_POST['size_1_original_price'] ?? '';
    $size_2_original_price = $_POST['size_2_original_price'] ?? '';
    $size_3_original_price = $_POST['size_3_original_price'] ?? '';
    $size_4_original_price = $_POST['size_4_original_price'] ?? '';
    $size_5_original_price = $_POST['size_5_original_price'] ?? '';
    $size_6_original_price = $_POST['size_6_original_price'] ?? '';
    $size_7_original_price = $_POST['size_7_original_price'] ?? '';
    $size_8_original_price = $_POST['size_8_original_price'] ?? '';
    $size_9_original_price = $_POST['size_9_original_price'] ?? '';
    $size_10_original_price = $_POST['size_10_original_price'] ?? '';
    
    $size_1_price = $_POST['size_1_price'] ?? '';
    $size_2_price = $_POST['size_2_price'] ?? '';
    $size_3_price = $_POST['size_3_price'] ?? '';
    $size_4_price = $_POST['size_4_price'] ?? '';
    $size_5_price = $_POST['size_5_price'] ?? '';
    $size_6_price = $_POST['size_6_price'] ?? '';
    $size_7_price = $_POST['size_7_price'] ?? '';
    $size_8_price = $_POST['size_8_price'] ?? '';
    $size_9_price = $_POST['size_9_price'] ?? '';
    $size_10_price = $_POST['size_10_price'] ?? '';

    // Prepare the SQL query to update data
    $sql = "UPDATE main_shoes SET product_name = :product_name, product_price = :product_price,
                                  product_color = :product_color, category = :category, size_1 = :size_1, size_2 = :size_2,
                                  size_3 = :size_3, size_4 = :size_4, size_5 = :size_5, size_6 = :size_6, size_7 = :size_7, 
                                  size_8 = :size_8, size_9 = :size_9, size_10 = :size_10, quantity = :quantity, 
                                  size_1_original_price = :size_1_original_price, size_2_original_price = :size_2_original_price,
                                  size_3_original_price = :size_3_original_price, size_4_original_price = :size_4_original_price, 
                                  size_5_original_price = :size_5_original_price, size_6_original_price = :size_6_original_price, 
                                  size_7_original_price = :size_7_original_price, size_8_original_price = :size_8_original_price, 
                                  size_9_original_price = :size_9_original_price, size_10_original_price = :size_10_original_price,
                                  size_1_price = :size_1_price, size_2_price = :size_2_price, 
                                  size_3_price = :size_3_price, size_4_price = :size_4_price, 
                                  size_5_price = :size_5_price, size_6_price = :size_6_price,
                                  size_7_price = :size_7_price, size_8_price = :size_8_price, 
                                  size_9_price = :size_9_price, size_10_price = :size_10_price,
                                  WHERE id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':product_price', $product_price);
    $stmt->bindParam(':product_color', $product_color);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':size_1', $size_1);
    $stmt->bindParam(':size_2', $size_2);
    $stmt->bindParam(':size_3', $size_3);
    $stmt->bindParam(':size_4', $size_4);
    $stmt->bindParam(':size_5', $size_5);
    $stmt->bindParam(':size_6', $size_6);
    $stmt->bindParam(':size_7', $size_7);
    $stmt->bindParam(':size_8', $size_8);
    $stmt->bindParam(':size_9', $size_9);
    $stmt->bindParam(':size_10', $size_10);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':size_1_original_price', $size_1_original_price);
    $stmt->bindParam(':size_2_original_price', $size_2_original_price);
    $stmt->bindParam(':size_3_original_price', $size_3_original_price);
    $stmt->bindParam(':size_4_original_price', $size_4_original_price);
    $stmt->bindParam(':size_5_original_price', $size_5_original_price);
    $stmt->bindParam(':size_6_original_price', $size_6_original_price);
    $stmt->bindParam(':size_7_original_price', $size_7_original_price);
    $stmt->bindParam(':size_8_original_price', $size_8_original_price);
    $stmt->bindParam(':size_9_original_price', $size_9_original_price);
    $stmt->bindParam(':size_10_original_price', $size_10_original_price);
    $stmt->bindParam(':size_1_price', $size_1_price);
    $stmt->bindParam(':size_2_price', $size_2_price);
    $stmt->bindParam(':size_3_price', $size_3_price);
    $stmt->bindParam(':size_4_price', $size_4_price);
    $stmt->bindParam(':size_5_price', $size_5_price);
    $stmt->bindParam(':size_6_price', $size_6_price);
    $stmt->bindParam(':size_7_price', $size_7_price);
    $stmt->bindParam(':size_8_price', $size_8_price);
    $stmt->bindParam(':size_9_price', $size_9_price);
    $stmt->bindParam(':size_10_price', $size_10_price);
    $stmt->bindParam(':id', $id);

    // Execute the query
    if ($stmt->execute()) {
      echo "<script>
              alert('Product updated successfully!');
              window.location.href='../admin-dashboard/pages/update_product_all.php';
            </script>";
    } else {
        echo "<script>
                alert('Failed to update product.');
              </script>";
    }
  
}

$product_color = $_GET['product_color'];
$product_name = $_GET['product_name'];

// Prepare the SQL query to fetch data
$sql = "SELECT * FROM main_shoes WHERE product_name = :product_name AND product_color = :product_color";
$stmt = $conn->prepare($sql);

// Bind the parameters using PDO syntax
$stmt->bindParam(':product_name', $product_name);
$stmt->bindParam(':product_color', $product_color);

// Execute the query
$stmt->execute();

// Fetch the data as an associative array
$shoes_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($shoes_data)) {
    foreach ($shoes_data as $shoe) {
        // Your code to handle the data goes here
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    
    <title>shoes</title>

    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="assets/css/material-dashboard.min.css?v=3.0.6" rel="stylesheet" />

    <style>
      .async-hide {
        opacity: 0 !important
      }

      .drag-inputs-container {
        display: flex;
        justify-content: space-between;
      }

      .drag-input {
        width: 100%;
        height: 150px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        text-align: center;
        position: relative;
        cursor: pointer;
        padding-top: 40px;
      }

      .drag-input input[type="file"] {
        display: none;
      }

      .drag-input img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 10px;
      }

    </style>

    <script>
      (function(a, s, y, n, c, h, i, d, e) {
        s.className += ' ' + y;
        h.start = 1 * new Date;
        h.end = i = function() {
          s.className = s.className.replace(RegExp(' ?' + y), '')
        };
        (a[n] = a[n] || []).hide = h;
        setTimeout(function() {
          i();
          h.end = null
        }, c);
        h.timeout = c;
      })(window, document.documentElement, 'async-hide', 'dataLayer', 4000, {
        'GTM-K9BGS8K': true
      });
    </script>

    <script>
      (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
      ga('create', 'UA-46172202-22', 'auto', {
        allowLinker: true
      });
      ga('set', 'anonymizeIp', true);
      ga('require', 'GTM-K9BGS8K');
      ga('require', 'displayfeatures');
      ga('require', 'linker');
      ga('linker:autoLink', ["2checkout.com", "avangate.com"]);
    </script>

  </head>

  <body class="g-sidenav-show  bg-gray-200">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

      <div class="container-fluid py-4" style="margin-top: 5%;">

        <div class="row">
          <div class="col-12">
            <div class="multisteps-form mb-9">

              <div class="row">
                <div class="col-12 col-lg-8 m-auto">
                  <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="multisteps-form__progress">
                          <button class="multisteps-form__progress-btn js-active" type="button" title="User Info">
                            <span>Product Info</span>
                          </button>
                          <button class="multisteps-form__progress-btn" type="button" title="Address">Size/Quantity</button>
                          <button class="multisteps-form__progress-btn" type="button" title="Price">Price</button>
                          <!--button class="multisteps-form__progress-btn" type="button" title="Socials">Product Images</button>
                          <button class="multisteps-form__progress-btn" type="button" title="Profile">Profile</button-->
                        </div>
                      </div>
                    </div>
                    <div class="card-body">

                    <form class="multisteps-form__form" method="POST" action="" enctype="multipart/form-data">

                        <div class="multisteps-form__panel border-radius-xl bg-white js-active" data-animation="FadeIn">
                          <h5 class="font-weight-bolder mb-0">About Product</h5>
                          <p class="mb-0 text-sm">Mandatory informations</p>
                          <div class="multisteps-form__content">
                            <div class="row mt-3">

                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product ID</label>
                                  <input value="<?php echo htmlspecialchars($shoe['product_id']); ?>" class="multisteps-form__input form-control" type="text" readonly />
                                </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                <input type="hidden" name="id" value="<?php echo $shoe['id']; ?>"">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Name</label>
                                  <input value="<?php echo htmlspecialchars($shoe['product_name']); ?>" name="product_name" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Color</label>
                                  <input oninput="allowLettersOnly(this)" value="<?php echo htmlspecialchars($shoe['product_color']); ?>" name="product_color" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>  
                              <div class="col-12 col-sm-3">
                                <div class="input-group input-group-dynamic">
                                  <!--label class="form-label">Category</label>
                                  <input value="<//?php echo htmlspecialchars($shoe['category']); ?>" name="category" class="multisteps-form__input form-control" type="text" required /-->
                                  <select name="category" class="multisteps-form__input form-control" type="text" required />
                                    <option style="text-align: center;" value="<?php echo htmlspecialchars($shoe['category']); ?>"><?php echo htmlspecialchars($shoe['category']); ?></option>
                                    <option style="text-align: center;" value="male">Male</option>
                                    <option style="text-align: center;" value="female">Female</option>
                                    <option style="text-align: center;" value="other">Other</option>
                                  </select>
                                </div>
                              </div>

                            </div>
                            <div class="button-row d-flex mt-4">

                              <a href="../admin-dashboard/pages/update_product_all.php">
                                <button class="btn bg-gradient-light mb-0" type="button" title="Back">
                                  Back
                                </button>
                              </a>

                              <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                            </div>
                          </div>
                        </div>

                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                          <h5 class="font-weight-bold mb-0">Product Size/Quantity</h5>
                          <!--p class="mb-0 text-sm">Tell us where are you living</p-->
                          <div class="multisteps-form__content">
                            <div class="row mt-3">

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-1</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_1']); ?>" name="1" id="input-1" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div> 

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-2</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_2']); ?>" name="2" id="input-2" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-3</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_3']); ?>" name="3" id="input-3" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-4</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_4']); ?>" name="4" id="input-4" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-5</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_5']); ?>" name="5" id="input-5" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-6</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_6']); ?>" name="6" id="input-6" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <div class="row mt-3">

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-7</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_7']); ?>" name="7" id="input-7" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-8</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_8']); ?>" name="8" id="input-8" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-9</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_9']); ?>" name="9" id="input-9" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-10</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_10']); ?>" name="10" id="input-10" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>
                            </div>
                          
                            <div class="button-row d-flex mt-4">

                              <a href="../admin-dashboard/pages/update_product_all.php">
                                <button class="btn bg-gradient-light mb-0" type="button" title="Back">
                                  Back
                                </button>
                              </a>

                              <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                            </div>

                          </div>
                        </div>

                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                          <h5 class="font-weight-bold mb-0">Product Original Price</h5>
                          <!--p class="mb-0 text-sm">Tell us where are you living</p-->
                          <div class="multisteps-form__content">
                            <div class="row mt-3">

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-1-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_1_original_price']); ?>" name="size_1_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>


                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-2-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_2_original_price']); ?>" name="size_2_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-3-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_3_original_price']); ?>" name="size_3_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-4-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_4_original_price']); ?>" name="size_4_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-5-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_5_original_price']); ?>" name="size_5_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-6-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_6_original_price']); ?>" name="size_6_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <div class="row mt-3">
                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-7-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_7_original_price']); ?>" name="size_7_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-8-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_8_original_price']); ?>" name="size_8_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-9-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_9_original_price']); ?>" name="size_9_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-10-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_10_original_price']); ?>" name="size_10_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <h5 class="font-weight-bold mb-0" style="margin-top: 5%;">Product Selling Price</h5>
                            <div class="row mt-3">

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-1-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_1_price']); ?>" name="size_1_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>


                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-2-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_2_price']); ?>" name="size_2_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-3-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_3_price']); ?>" name="size_3_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-4-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_4_price']); ?>" name="size_4_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-5-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_5_price']); ?>" name="size_5_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-6-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_6_price']); ?>" name="size_6_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <div class="row mt-3">
                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-7-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_7_price']); ?>" name="size_7_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-8-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_8_price']); ?>" name="size_8_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-9-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_9_price']); ?>" name="size_9_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-10-price</label>
                                  <input oninput="validateNumericInput(this)" value="<?php echo htmlspecialchars($shoe['size_10_price']); ?>" name="size_10_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>

                            <div class="button-row d-flex mt-4">
                              <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                              <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit" name="update_product" title="Submit">Update Product Details</button>
                            </div>
                          </div>
                        </div>
                        
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script>
      function allowLettersOnly(input) {
        var regex = /[^A-Za-z\s]/g;
        input.value = input.value.replace(regex, '');
      }

      function validateNumericInput(input) {
        // Remove non-numeric characters using a regular expression
        var numericValue = input.value.replace(/[^0-9]/g, '');
        
        if (numericValue.length <= 10) {
        // Update the input value with the cleaned numeric value
        input.value = numericValue;
        } else {
            input.value = numericValue.slice(0, 10);
        }
      }
    </script>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="assets/js/plugins/choices.min.js"></script>
    <script src="assets/js/plugins/multistep-form.js"></script>
    <script>
        if (document.getElementById('choices-state')) {
          var element = document.getElementById('choices-state');
          const example = new Choices(element, {
            searchEnabled: false
          });
        };
      </script>

    <script src="assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="assets/js/plugins/jkanban/jkanban.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

        document.querySelectorAll('.drag-input').forEach((input) => {
          input.addEventListener('dragover', (event) => {
            event.preventDefault();
            input.style.borderColor = '#666';
          });

          input.addEventListener('dragleave', (event) => {
            event.preventDefault();
            input.style.borderColor = '#ccc';
          });

          input.addEventListener('drop', (event) => {
            event.preventDefault();
            input.style.borderColor = '#ccc';
            let fileInput = input.querySelector('input[type="file"]');
            let files = event.dataTransfer.files;
            fileInput.files = files; // set files to the input field
            previewImage(fileInput, input.id.split('-')[2]);
          });
        });


        // Function to update the quantity
        function updateQuantity() {
          // Get the values of the inputs
          const input6 = parseFloat(document.getElementById('input-6').value) || 0;
          const input7 = parseFloat(document.getElementById('input-7').value) || 0;
          const input8 = parseFloat(document.getElementById('input-8').value) || 0;
          const input9 = parseFloat(document.getElementById('input-9').value) || 0;
          const input10 = parseFloat(document.getElementById('input-10').value) || 0;

          // Calculate the sum
          const sum = input6 + input7 + input8 + input9 + input10;

          // Display the sum in the Quantity input
          document.getElementById('input-quantity').value = sum;
        }

        // Attach the updateQuantity function to the input events
        document.querySelectorAll('#input-6, #input-7, #input-8, #input-9, #input-10').forEach(input => {
          input.addEventListener('input', updateQuantity);
        });


      </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="assets/js/material-dashboard.min.js?v=3.0.6"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8b722938298e3d36","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>

  </body>

</html>
<?php 
    }
  } else {
      echo "No shoes found.";
  }
?>
