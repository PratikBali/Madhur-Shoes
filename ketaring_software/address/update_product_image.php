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

    // Handling image uploads
    $side = $_FILES['side']['name'];
    $up = $_FILES['up']['name'];
    $bottom = $_FILES['bottom']['name']; 
    $back = $_FILES['back']['name'];

    $target_dir = "../shoes/";
    $side_target_file = $target_dir . basename($side);
    $up_target_file = $target_dir . basename($up);
    $bottom_target_file = $target_dir . basename($bottom);
    $back_target_file = $target_dir . basename($back);

    // Move uploaded files
    move_uploaded_file($_FILES['side']['tmp_name'], $side_target_file);
    move_uploaded_file($_FILES['up']['tmp_name'], $up_target_file);
    move_uploaded_file($_FILES['bottom']['tmp_name'], $bottom_target_file);
    move_uploaded_file($_FILES['back']['tmp_name'], $back_target_file);

    // Prepare the SQL query to update data
    $sql = "UPDATE main_shoes SET side = :side, up = :up, bottom = :bottom, back = :back WHERE id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':side', $side_path);
    $stmt->bindParam(':up', $up_path);
    $stmt->bindParam(':bottom', $bottom_path);
    $stmt->bindParam(':back', $back_path);
    $stmt->bindParam(':id', $id);

    $side_path = 'shoes/' . $side;
    $up_path = 'shoes/' . $up;
    $bottom_path = 'shoes/' . $bottom;
    $back_path = 'shoes/' . $back;

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
                            <span>Product Images</span>
                          </button>
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
                              <input type="hidden" name="id" value="<?php echo $shoe['id']; ?>"">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Name</label>
                                  <input value="<?php echo htmlspecialchars($shoe['product_name']); ?>" class="multisteps-form__input form-control" type="text" readonly />
                                </div>
                              </div>
                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Color</label>
                                  <input value="<?php echo htmlspecialchars($shoe['product_color']); ?>" class="multisteps-form__input form-control" type="text" readonly />
                                </div>
                              </div>
                            </div>

                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <label class="form-label">Side Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-1">
                                    <p>Drag Side Image Here</p>
                                    <input value="<?php echo htmlspecialchars($shoe['side']); ?>" name="side" type="file" accept="image/*" onchange="previewImage(this, 1)" required>
                                    <img id="preview-1" src="../<?php echo htmlspecialchars($shoe['side']); ?>" alt="Preview 1" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                              <label class="form-label">Back Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-2">
                                    <p>Drag Back Image Here</p>
                                    <input value="<?php echo htmlspecialchars($shoe['back']); ?>" name="back" type="file" accept="image/*" onchange="previewImage(this, 2)" required>
                                    <img id="preview-2" src="../<?php echo htmlspecialchars($shoe['back']); ?>" alt="Preview 2" />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                              <label class="form-label">Up Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-3">
                                    <p>Drag Up Image Here</p>
                                    <input value="<?php echo htmlspecialchars($shoe['up']); ?>" name="up" type="file" accept="image/*" onchange="previewImage(this, 3)" required>
                                    <img id="preview-3" src="../<?php echo htmlspecialchars($shoe['up']); ?>" alt="Preview 3" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                              <label class="form-label">Bottom Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-4">
                                    <p>Drag Bottom Image Here</p>
                                    <input value="<?php echo htmlspecialchars($shoe['bottom']); ?>" name="bottom" type="file" accept="image/*" onchange="previewImage(this, 4)" required>
                                    <img id="preview-4" src="../<?php echo htmlspecialchars($shoe['bottom']); ?>" alt="Preview 4" />
                                  </div> 
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="button-row d-flex mt-4 col-12">
                                <a href="../admin-dashboard/pages/update_product_all.php">
                                  <button class="btn bg-gradient-light mb-0" type="button" title="Back">
                                    Back
                                  </button>
                                </a>
                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit" name="update_product" title="Submit">Update Product Images</button>
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


        // Handle drag-and-drop as well as file selection
        document.querySelectorAll('.drag-input').forEach((inputDiv) => {
          const fileInput = inputDiv.querySelector('input[type="file"]');
          
          // Drag over effect
          inputDiv.addEventListener('dragover', (event) => {
            event.preventDefault();
            inputDiv.style.borderColor = '#666';
          });

          // Drag leave effect
          inputDiv.addEventListener('dragleave', (event) => {
            event.preventDefault();
            inputDiv.style.borderColor = '#ccc';
          });

          // Drop effect
          inputDiv.addEventListener('drop', (event) => {
            event.preventDefault();
            inputDiv.style.borderColor = '#ccc';
            let files = event.dataTransfer.files;
            fileInput.files = files;  // set files to the input field
            previewImage(fileInput, inputDiv.id.split('-')[2]);  // Preview image
          });

          // Clicking the input field should also open the file browser
          inputDiv.addEventListener('click', () => {
            fileInput.click();
          });
        });

        // Function to preview the uploaded image
        function previewImage(input, index) {
          const file = input.files[0];
          const reader = new FileReader();
          
          reader.onload = function(e) {
            const preview = document.getElementById(`preview-${index}`);
            preview.src = e.target.result;
            preview.style.display = 'block';  // Show the preview image
          };
          
          if (file) {
            reader.readAsDataURL(file);
          }
        }

        function previewImage(input, index) {
            const file = input.files[0];
            const preview = document.getElementById(`preview-${index}`);
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }


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
