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
  $bar_code_no = $_POST['bar_code_no'];
  $brand_name = $_POST['brand_name'];
  $category = $_POST['category'];
  $male_category = $_POST['male_category'];
  $female_category = $_POST['female_category'];
  $child_male_category = $_POST['child_male_category'];
  $child_female_category = $_POST['child_female_category'];
  $other_category = $_POST['other_category'];
  $artical_no = $_POST['artical_no'];
  $product_color = $_POST['product_color'];

  $product_size = $_POST['product_size'];
  $quantity = $_POST['quantity'];
  $original_price = $_POST['original_price'];
  $sell_price = $_POST['sell_price'];

  // Prepare the SQL query to update data
  $sql = "UPDATE main_shoes SET bar_code_no = :bar_code_no, brand_name = :brand_name,
                                  category = :category, male_category = :male_category,
                                  female_category = :female_category, child_male_category = :child_male_category,
                                  child_female_category = :child_female_category, other_category= :other_category, 
                                  artical_no = :artical_no, product_color = :product_color, 
                                  product_size = :product_size, quantity = :quantity, 
                                  original_price = :original_price, sell_price = :sell_price
                                  WHERE id = :id";

  $stmt = $conn->prepare($sql);

  // Bind the parameters
  $stmt->bindParam(':bar_code_no', $bar_code_no);
  $stmt->bindParam(':brand_name', $brand_name);
  $stmt->bindParam(':category', $category);
  $stmt->bindParam(':male_category', $male_category);
  $stmt->bindParam(':female_category', $female_category);
  $stmt->bindParam(':child_male_category', $child_male_category);
  $stmt->bindParam(':child_female_category', $child_female_category);
  $stmt->bindParam(':other_category', $other_category);
  $stmt->bindParam(':artical_no', $artical_no);
  $stmt->bindParam(':product_color', $product_color);
  $stmt->bindParam(':product_size', $product_size);
  $stmt->bindParam(':quantity', $quantity);
  $stmt->bindParam(':original_price', $original_price);
  $stmt->bindParam(':sell_price', $sell_price);
  $stmt->bindParam(':id', $id);

  // Execute the query
  if ($stmt->execute()) {
    
  } else {
    echo "<script>
                alert('Failed to update product.');
              </script>";
  }

  // Prepare the SQL query to update data
  $sql = "UPDATE main_shoes_original SET bar_code_no = :bar_code_no, brand_name = :brand_name,
                                  category = :category, male_category = :male_category,
                                  female_category = :female_category, child_male_category = :child_male_category,
                                  child_female_category = :child_female_category, other_category= :other_category, 
                                  artical_no = :artical_no, product_color = :product_color, 
                                  product_size = :product_size, quantity = :quantity, 
                                  original_price = :original_price, sell_price = :sell_price
                                  WHERE id = :id";

  $stmt = $conn->prepare($sql);

  // Bind the parameters
  $stmt->bindParam(':bar_code_no', $bar_code_no);
  $stmt->bindParam(':brand_name', $brand_name);
  $stmt->bindParam(':category', $category);
  $stmt->bindParam(':male_category', $male_category);
  $stmt->bindParam(':female_category', $female_category);
  $stmt->bindParam(':child_male_category', $child_male_category);
  $stmt->bindParam(':child_female_category', $child_female_category);
  $stmt->bindParam(':other_category', $other_category);
  $stmt->bindParam(':artical_no', $artical_no);
  $stmt->bindParam(':product_color', $product_color);
  $stmt->bindParam(':product_size', $product_size);
  $stmt->bindParam(':quantity', $quantity);
  $stmt->bindParam(':original_price', $original_price);
  $stmt->bindParam(':sell_price', $sell_price);
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

$bar_code_no = $_GET['bar_code_no'];

// Prepare the SQL query to fetch data
$sql = "SELECT * FROM main_shoes WHERE bar_code_no = :bar_code_no";
$stmt = $conn->prepare($sql);

// Bind the parameters using PDO syntax
$stmt->bindParam(':bar_code_no', $bar_code_no);

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
                                    <label class="form-label">Product Barcode</label>
                                    <input value="<?php echo htmlspecialchars($shoe['bar_code_no']); ?>" name="bar_code_no" class="multisteps-form__input form-control" type="text" readonly />
                                  </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                  <input type="hidden" name="id" value="<?php echo $shoe['id']; ?>"">
                                  <div class=" input-group input-group-dynamic">
                                    <label class="form-label">Product Brand Name</label>
                                    <input value="<?php echo htmlspecialchars($shoe['brand_name']); ?>" name="brand_name" class="multisteps-form__input form-control" type="text" required />
                                  </div>
                                </div>
                              </div>

                              <div class="row mt-3">
                                <div class="col-12 col-sm-6">
                                  <div class="input-group input-group-dynamic">
                                    <select name="category" id="category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                      <option value="" disabled>Select Category</option>
                                      <option value="male" <?php echo $shoe['category'] == 'male' ? 'selected' : ''; ?>>जेन्टस</option>
                                      <option value="female" <?php echo $shoe['category'] == 'female' ? 'selected' : ''; ?>>लेडीज</option>
                                      <option value="child male" <?php echo $shoe['category'] == 'child male' ? 'selected' : ''; ?>>लहान मुलगा</option>
                                      <option value="child female" <?php echo $shoe['category'] == 'child female' ? 'selected' : ''; ?>>लहान मुलगी</option>
                                      <option value="other" <?php echo $shoe['category'] == 'other' ? 'selected' : ''; ?>>इतर</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-12 col-sm-6" id="male-dropdown" style="display: none;">
                                  <div class="input-group input-group-dynamic">
                                    <select name="male_category" id="male_category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                      <option value="" disabled>Select जेन्टस Product Category</option>
                                      <option value="Shoes" <?php echo $shoe['male_category'] == 'Shoes' ? 'selected' : ''; ?>>शुज</option>
                                      <option value="chappal" <?php echo $shoe['male_category'] == 'chappal' ? 'selected' : ''; ?>>चप्पल</option>
                                      <option value="Flip Flop" <?php echo $shoe['male_category'] == 'Flip Flop' ? 'selected' : ''; ?>>फ्लिप फ्लॉप</option>
                                      <option value="Crocs" <?php echo $shoe['male_category'] == 'Crocs' ? 'selected' : ''; ?>>क्रोक्स</option>
                                      <option value="Slipper" <?php echo $shoe['male_category'] == 'Slipper' ? 'selected' : ''; ?>>स्लिप्पेर</option>
                                      <option value="Loafer" <?php echo $shoe['male_category'] == 'Loafer' ? 'selected' : ''; ?>>लोफर</option>
                                      <option value="Sandal" <?php echo $shoe['male_category'] == 'Sandal' ? 'selected' : ''; ?>>सॅन्डल</option>
                                      <option value="Other" <?php echo $shoe['male_category'] == 'Other' ? 'selected' : ''; ?>>इतर</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-12 col-sm-6" id="female-dropdown" style="display: none;">
                                  <div class="input-group input-group-dynamic">
                                    <select name="female_category" id="female_category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                      <option value="" disabled>Select लेडीज Product Category</option>
                                      <option value="Shoes" <?php echo $shoe['male_category'] == 'Shoes' ? 'selected' : ''; ?>>शुज</option>
                                      <option value="chappal" <?php echo $shoe['male_category'] == 'chappal' ? 'selected' : ''; ?>>चप्पल</option>
                                      <option value="Flip Flop" <?php echo $shoe['male_category'] == 'Flip Flop' ? 'selected' : ''; ?>>फ्लिप फ्लॉप</option>
                                      <option value="Crocs" <?php echo $shoe['male_category'] == 'Crocs' ? 'selected' : ''; ?>>क्रोक्स</option>
                                      <option value="Slipper" <?php echo $shoe['male_category'] == 'Slipper' ? 'selected' : ''; ?>>स्लिप्पेर</option>
                                      <option value="Loafer" <?php echo $shoe['male_category'] == 'Loafer' ? 'selected' : ''; ?>>लोफर</option>
                                      <option value="Sandal" <?php echo $shoe['male_category'] == 'Sandal' ? 'selected' : ''; ?>>सॅन्डल</option>
                                      <option value="Other" <?php echo $shoe['male_category'] == 'Other' ? 'selected' : ''; ?>>इतर</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-12 col-sm-6" id="child-male-dropdown" style="display: none;">
                                  <div class="input-group input-group-dynamic">
                                    <select name="child_male_category" id="child_male_category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                      <option value="" disabled>Select लहान मुलगा Product Category</option>
                                      <option value="Shoes" <?php echo $shoe['male_category'] == 'Shoes' ? 'selected' : ''; ?>>शुज</option>
                                      <option value="chappal" <?php echo $shoe['male_category'] == 'chappal' ? 'selected' : ''; ?>>चप्पल</option>
                                      <option value="Flip Flop" <?php echo $shoe['male_category'] == 'Flip Flop' ? 'selected' : ''; ?>>फ्लिप फ्लॉप</option>
                                      <option value="Crocs" <?php echo $shoe['male_category'] == 'Crocs' ? 'selected' : ''; ?>>क्रोक्स</option>
                                      <option value="Slipper" <?php echo $shoe['male_category'] == 'Slipper' ? 'selected' : ''; ?>>स्लिप्पेर</option>
                                      <option value="Loafer" <?php echo $shoe['male_category'] == 'Loafer' ? 'selected' : ''; ?>>लोफर</option>
                                      <option value="Sandal" <?php echo $shoe['male_category'] == 'Sandal' ? 'selected' : ''; ?>>सॅन्डल</option>
                                      <option value="Other" <?php echo $shoe['male_category'] == 'Other' ? 'selected' : ''; ?>>इतर</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-12 col-sm-6" id="child-female-dropdown" style="display: none;">
                                  <div class="input-group input-group-dynamic">
                                    <select name="child_female_category" id="child_female_category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                      <option value="" disabled>Select लहान मुलगी Product Category</option>
                                      <option value="Shoes" <?php echo $shoe['male_category'] == 'Shoes' ? 'selected' : ''; ?>>शुज</option>
                                      <option value="chappal" <?php echo $shoe['male_category'] == 'chappal' ? 'selected' : ''; ?>>चप्पल</option>
                                      <option value="Flip Flop" <?php echo $shoe['male_category'] == 'Flip Flop' ? 'selected' : ''; ?>>फ्लिप फ्लॉप</option>
                                      <option value="Crocs" <?php echo $shoe['male_category'] == 'Crocs' ? 'selected' : ''; ?>>क्रोक्स</option>
                                      <option value="Slipper" <?php echo $shoe['male_category'] == 'Slipper' ? 'selected' : ''; ?>>स्लिप्पेर</option>
                                      <option value="Loafer" <?php echo $shoe['male_category'] == 'Loafer' ? 'selected' : ''; ?>>लोफर</option>
                                      <option value="Sandal" <?php echo $shoe['male_category'] == 'Sandal' ? 'selected' : ''; ?>>सॅन्डल</option>
                                      <option value="Other" <?php echo $shoe['male_category'] == 'Other' ? 'selected' : ''; ?>>इतर</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-12 col-sm-6" id="other-dropdown" style="display: none;">
                                  <div class="input-group input-group-dynamic">
                                    <select name="other_category" id="other_category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                      <option value="" disabled>Select इतर Product Category</option>
                                      <option value="Shoes" <?php echo $shoe['male_category'] == 'Shoes' ? 'selected' : ''; ?>>शुज</option>
                                      <option value="chappal" <?php echo $shoe['male_category'] == 'chappal' ? 'selected' : ''; ?>>चप्पल</option>
                                      <option value="Flip Flop" <?php echo $shoe['male_category'] == 'Flip Flop' ? 'selected' : ''; ?>>फ्लिप फ्लॉप</option>
                                      <option value="Crocs" <?php echo $shoe['male_category'] == 'Crocs' ? 'selected' : ''; ?>>क्रोक्स</option>
                                      <option value="Slipper" <?php echo $shoe['male_category'] == 'Slipper' ? 'selected' : ''; ?>>स्लिप्पेर</option>
                                      <option value="Loafer" <?php echo $shoe['male_category'] == 'Loafer' ? 'selected' : ''; ?>>लोफर</option>
                                      <option value="Sandal" <?php echo $shoe['male_category'] == 'Sandal' ? 'selected' : ''; ?>>सॅन्डल</option>
                                      <option value="Other" <?php echo $shoe['male_category'] == 'Other' ? 'selected' : ''; ?>>इतर</option>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row mt-3">
                                <div class="col-12 col-sm-6">
                                  <div class="input-group input-group-dynamic">
                                    <label class="form-label">Artical No</label>
                                    <input value="<?php echo htmlspecialchars($shoe['artical_no']); ?>" name="artical_no" class="multisteps-form__input form-control" type="text" required />
                                  </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                  <div class="input-group input-group-dynamic">
                                    <label class="form-label">Product Color</label>
                                    <input value="<?php echo htmlspecialchars($shoe['product_color']); ?>" name="product_color" class="multisteps-form__input form-control" type="text" required />
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

                                <div class="row mt-3">
                                  <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                                    <div class="input-group input-group-dynamic">
                                      <label class="form-label">Product Size</label>
                                      <input value="<?php echo htmlspecialchars($shoe['product_size']); ?>" oninput="validateNumericInput(this)" name="product_size" id="product_size" class="multisteps-form__input form-control" type="text" required />
                                    </div>
                                  </div>

                                  <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                                    <div class="input-group input-group-dynamic">
                                      <label class="form-label">Product Quantity</label>
                                      <input value="<?php echo htmlspecialchars($shoe['quantity']); ?>" oninput="validateNumericInput(this)" name="quantity" id="quantity" class="multisteps-form__input form-control" type="text" required />
                                    </div>
                                  </div>
                                </div>

                                <div class="row mt-3">
                                  <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                                    <div class="input-group input-group-dynamic">
                                      <label class="form-label">Product Buying Price</label>
                                      <input value="<?php echo htmlspecialchars($shoe['original_price']); ?>" oninput="validateNumericInput(this)" name="original_price" id="original_price" class="multisteps-form__input form-control" type="text" required />
                                    </div>
                                  </div>

                                  <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                                    <div class="input-group input-group-dynamic">
                                      <label class="form-label">Product Box Price</label>
                                      <input value="<?php echo htmlspecialchars($shoe['sell_price']); ?>" oninput="validateNumericInput(this)" name="sell_price" id="sell_price" class="multisteps-form__input form-control" type="text" required />
                                    </div>
                                  </div>
                                </div>

                                <div class="button-row d-flex mt-4">
                                  <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                                  <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit" name="update_product" title="Submit">Update Product Details</button>
                                </div>
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
        function showCategoryDropdown() {
          // Hide all dropdowns initially
          document.getElementById("male-dropdown").style.display = "none";
          document.getElementById("female-dropdown").style.display = "none";
          document.getElementById("child-male-dropdown").style.display = "none";
          document.getElementById("child-female-dropdown").style.display = "none";
          document.getElementById("other-dropdown").style.display = "none";

          // Get the selected category
          const category = document.getElementById("category").value;

          // Show the appropriate dropdown based on selection
          if (category === "male") {
            document.getElementById("male-dropdown").style.display = "block";
          } else if (category === "female") {
            document.getElementById("female-dropdown").style.display = "block";
          } else if (category === "child male") {
            document.getElementById("child-male-dropdown").style.display = "block";
          } else if (category === "child female") {
            document.getElementById("child-female-dropdown").style.display = "block";
          } else if (category === "other") {
            document.getElementById("other-dropdown").style.display = "block";
          }
        }

        document.addEventListener("DOMContentLoaded", function() {
          const category = "<?php echo htmlspecialchars($shoe['category']); ?>"; // Replace with the actual selected category value from the server/database
          document.getElementById("category").value = category; // Preselect the category
          showCategoryDropdown();
        });
      </script>

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