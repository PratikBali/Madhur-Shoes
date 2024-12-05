<?php
session_start();
require '../conf/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch admin details from the database
$email_id = $_SESSION['admin'];
$admin_query = "SELECT email_id FROM admin WHERE email_id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bindParam(1, $email_id, PDO::PARAM_INT);
$stmt->execute();
$admin_details = $stmt->fetch(PDO::FETCH_OBJ);

// Check if admin details were found
if ($admin_details) {
    $email_id = $admin_details->email_id;
} else {
    echo "Admin details not found.";
    exit();
}
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

      .ak:hover {
        background-color: red;
      }
    </style>
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
                          <button class="multisteps-form__progress-btn" type="button" title="Socials">Product Images</button>
                          <!--button class="multisteps-form__progress-btn" type="button" title="Profile">Profile</button-->
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                    <form class="multisteps-form__form" method="POST" action="add_product_process.php" enctype="multipart/form-data">

                        <div class="multisteps-form__panel border-radius-xl bg-white js-active" data-animation="FadeIn">
                          <h5 class="font-weight-bolder mb-0">About Product</h5>
                          <p class="mb-0 text-sm">Mandatory informations</p>
                          <div class="multisteps-form__content">
                            <div class="row mt-3">
                               
                              <input value="<?php echo $email_id ?>" name="product_seller_email_id" class="multisteps-form__input form-control" type="hidden" readonly />
                               
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Name</label>
                                  <input oninput="allowLettersOnly(this)" name="product_name" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>
                              <!--div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Price</label>
                                  <input oninput="validateNumericInput(this)" name="product_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div-->
                            </div>
                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Product Color</label>
                                  <input name="product_color" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-12 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <!--label class="form-label">Category</label-->
                                  <select name="category" class="multisteps-form__input form-control" type="text" required />
                                    <option style="text-align: center;">Select Category</option>
                                    <option style="text-align: center;" value="male">Male</option>
                                    <option style="text-align: center;" value="female">Female</option>
                                    <option style="text-align: center;" value="other">Other</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="button-row d-flex mt-4">

                              <a href="../admin-dashboard/pages/dashboard.php">
                                <button class="btn bg-gradient-light mb-0" type="button" title="Back To Dashboard">
                                  Back To Dashboard
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
                                  <input oninput="validateNumericInput(this)" name="1" id="input-1" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div> 

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-2</label>
                                  <input oninput="validateNumericInput(this)" name="2" id="input-2" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-3</label>
                                  <input oninput="validateNumericInput(this)" name="3" id="input-3" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-4</label>
                                  <input oninput="validateNumericInput(this)" name="4" id="input-4" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-5</label>
                                  <input oninput="validateNumericInput(this)" name="5" id="input-5" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-6</label>
                                  <input oninput="validateNumericInput(this)" name="6" id="input-6" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <div class="row mt-3">

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-7</label>
                                  <input oninput="validateNumericInput(this)" name="7" id="input-7" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-8</label>
                                  <input oninput="validateNumericInput(this)" name="8" id="input-8" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-9</label>
                                  <input oninput="validateNumericInput(this)" name="9" id="input-9" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-10</label>
                                  <input oninput="validateNumericInput(this)" name="10" id="input-10" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                             
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <label class="form-label">Total Quantity</label>
                                <div class="input-group input-group-dynamic"> 
                                  <input name="quantity" id="input-quantity" class="multisteps-form__input form-control" type="text" readonly/>
                                </div>
                              </div>
                            </div>

                            <div class="button-row d-flex mt-4">
                              <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
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
                                  <input oninput="validateNumericInput(this)" name="size_1_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>


                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-2-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_2_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-3-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_3_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-4-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_4_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-5-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_5_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-6-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_6_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <div class="row mt-3">
                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-7-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_7_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-8-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_8_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-9-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_9_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-10-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_10_original_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <h5 class="font-weight-bold mb-0" style="margin-top: 5%;">Product Selling Price</h5>
                            <div class="row mt-3">

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-1-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_1_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>


                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-2-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_2_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-3-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_3_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-4-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_4_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-5-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_5_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-6-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_6_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>
                            <div class="row mt-3">
                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-7-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_7_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-8-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_8_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-9-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_9_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                              
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Size-10-price</label>
                                  <input oninput="validateNumericInput(this)" name="size_10_price" class="multisteps-form__input form-control" type="text" required />
                                </div>
                              </div>

                            </div>

                            <div class="button-row d-flex mt-4">
                              <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                              <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                            </div>
                          </div>
                        </div>

                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                          <h5 class="font-weight-bolder mb-0">Product Images</h5>
                          <p class="mb-0 text-sm">Please provide at least one social link</p>
                          <div class="multisteps-form__content">

                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <label class="form-label">Side Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-1">
                                    <p>Drag Side Image Here</p>
                                    <input name="side" type="file" accept="image/*" onchange="previewImage(this, 1)" required>
                                    <img id="preview-1" src="" alt="Preview 1" style="display:none;" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label class="form-label">Back Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-2">
                                    <p>Drag Back Image Here</p>
                                    <input name="back" type="file" accept="image/*" onchange="previewImage(this, 2)" required>
                                    <img id="preview-2" src="" alt="Preview 2" style="display:none;" />
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
                                    <input name="up" type="file" accept="image/*" onchange="previewImage(this, 3)" required>
                                    <img id="preview-3" src="" alt="Preview 3" style="display:none;" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label class="form-label">Bottom Image</label>
                                <div class="input-group input-group-dynamic">
                                  <div class="drag-input" id="drag-input-4">
                                    <p>Drag Bottom Image Here</p>
                                    <input name="bottom" type="file" accept="image/*" onchange="previewImage(this, 4)" required>
                                    <img id="preview-4" src="" alt="Preview 4" style="display:none;" />
                                  </div>
                                </div>
                              </div>

                            </div>

                            <div class="row">
                              <div class="button-row d-flex mt-4 col-12">
                                <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit" title="Next">Submit</button>
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
        let preview = document.getElementById('preview-' + index);
        if (input.files && input.files[0]) {
          let reader = new FileReader();
          reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
          };
          reader.readAsDataURL(input.files[0]);
        }
      }


      // Function to update the quantity
      function updateQuantity() {
        // Get the values of the inputs
        const input1 = parseFloat(document.getElementById('input-1').value) || 0;
        const input2 = parseFloat(document.getElementById('input-2').value) || 0;
        const input3 = parseFloat(document.getElementById('input-3').value) || 0;
        const input4 = parseFloat(document.getElementById('input-4').value) || 0;
        const input5 = parseFloat(document.getElementById('input-5').value) || 0;
        const input6 = parseFloat(document.getElementById('input-6').value) || 0;
        const input7 = parseFloat(document.getElementById('input-7').value) || 0;
        const input8 = parseFloat(document.getElementById('input-8').value) || 0;
        const input9 = parseFloat(document.getElementById('input-9').value) || 0;
        const input10 = parseFloat(document.getElementById('input-10').value) || 0;

        // Calculate the sum
        const sum = input1 + input2 + input3 + input4 + input5 + input6 + input7 + input8 + input9 + input10;

        // Display the sum in the Quantity input
        document.getElementById('input-quantity').value = sum;
      }

      // Attach the updateQuantity function to the input events
      document.querySelectorAll('#input-1, #input-2, #input-3, #input-4, #input-5, #input-6, #input-7, #input-8, #input-9, #input-10').forEach(input => {
        input.addEventListener('input', updateQuantity);
      });

    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="assets/js/material-dashboard.min.js?v=3.0.6"></script>

    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8b722938298e3d36","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>

  </body>

</html>
