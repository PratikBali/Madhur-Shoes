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
                        <button class="multisteps-form__progress-btn" type="button" title="Address">Size/Quantity/Price</button>
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
                                <label class="form-label" for="bar_code_no">Enter Barcode (leave blank to generate):</label>
                                <input name="bar_code_no" id="bar_code_no" class="multisteps-form__input form-control" type="text" oninput="validateNumbers(this)" />
                              </div>
                            </div>

                            <div class="col-12 col-sm-6">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label" for="brand_name">Product Brand Name</label>
                                <input name="brand_name" id="brand_name" class="multisteps-form__input form-control" type="text" oninput="validateLetters(this)" required />
                              </div>
                            </div>

                          </div>
                          <div class="row mt-3">

                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                              <div class="input-group input-group-dynamic">
                                <select name="category" id="category" class="multisteps-form__input form-control" onchange="showCategoryDropdown()" required>
                                  <option value="">Select Category</option>
                                  <option value="male">जेन्टस</option>
                                  <option value="female">लेडीज</option>
                                  <option value="child male">लहान मुलगा</option>
                                  <option value="child female">लहान मुलगी</option>
                                  <option value="other">इतर</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-6 col-sm-6" id="male-dropdown" style="display: none;">
                              <div class="input-group input-group-dynamic">
                                <select name="male_category" class="multisteps-form__input form-control">
                                  <option value="">Select जेन्टस Product Category</option>
                                  <option value="Shoes">शुज</option>
                                  <option value="chappal">चप्पल</option>
                                  <option value="Flip Flop">फ्लिप फ्लॉप</option>
                                  <option value="Crocs">क्रोक्स</option>
                                  <option value="Slipper">स्लिप्पेर</option>
                                  <option value="Loafer">लोफर</option>
                                  <option value="Sandal">सॅन्डल</option>
                                  <option value="Other">इतर</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-6 col-sm-6" id="female-dropdown" style="display: none;">
                              <div class="input-group input-group-dynamic">
                                <select name="female_category" class="multisteps-form__input form-control">
                                  <option value="">Select लेडीज Product Category</option>
                                  <option value="Shoes">शुज</option>
                                  <option value="chappal">चप्पल</option>
                                  <option value="Fancy chappal">फॅन्सी चप्पल</option>
                                  <option value="Flip Flop">फ्लिप फ्लॉप</option>
                                  <option value="Crocs">क्रोक्स</option>
                                  <option value="Slipper">स्लिप्पेर</option>
                                  <option value="Loafer">लोफर</option>
                                  <option value="Sandal">सॅन्डल</option>
                                  <option value="Other">इतर</option>

                                </select>
                              </div>
                            </div>

                            <div class="col-6 col-sm-6" id="child-male-dropdown" style="display: none;">
                              <div class="input-group input-group-dynamic">
                                <select name="child_male_category" class="multisteps-form__input form-control">
                                  <option value="">Select लहान मुलगा Product Category</option>
                                  <option value="Shoes">शुज</option>
                                  <option value="chappal">चप्पल</option>
                                  <option value="Fancy chappal">फॅन्सी चप्पल</option>
                                  <option value="Flip Flop">फ्लिप फ्लॉप</option>
                                  <option value="Crocs">क्रोक्स</option>
                                  <option value="Slipper">स्लिप्पेर</option>
                                  <option value="Loafer">लोफर</option>
                                  <option value="Sandal">सॅन्डल</option>
                                  <option value="Other">इतर</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-6 col-sm-6" id="child-female-dropdown" style="display: none;">
                              <div class="input-group input-group-dynamic">
                                <select name="child_female_category" class="multisteps-form__input form-control">
                                  <option value="">Select लहान मुलगी Product Category</option>
                                  <option value="Shoes">शुज</option>
                                  <option value="chappal">चप्पल</option>
                                  <option value="Fancy chappal">फॅन्सी चप्पल</option>
                                  <option value="Flip Flop">फ्लिप फ्लॉप</option>
                                  <option value="Crocs">क्रोक्स</option>
                                  <option value="Slipper">स्लिप्पेर</option>
                                  <option value="Loafer">लोफर</option>
                                  <option value="Sandal">सॅन्डल</option>
                                  <option value="Other">इतर</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-6 col-sm-6" id="other-dropdown" style="display: none;">
                              <div class="input-group input-group-dynamic">
                                <select name="other_category" class="multisteps-form__input form-control">
                                  <option value="">Select इतर Product Category</option>
                                  <option value="Shoes">शुज</option>
                                  <option value="chappal">चप्पल</option>
                                  <option value="Fancy chappal">फॅन्सी चप्पल</option>
                                  <option value="Flip Flop">फ्लिप फ्लॉप</option>
                                  <option value="Crocs">क्रोक्स</option>
                                  <option value="Slipper">स्लिप्पेर</option>
                                  <option value="Loafer">लोफर</option>
                                  <option value="Sandal">सॅन्डल</option>
                                  <option value="Other">इतर</option>
                                </select>
                              </div>
                            </div>

                          </div>

                          <div class="row mt-3">
                            <div class="col-12 col-sm-6">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label">Artical No</label>
                                <input name="artical_no" class="multisteps-form__input form-control" type="text" required />
                              </div>
                            </div>

                            <div class="col-12 col-sm-6">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label">Product Color</label>
                                <input name="product_color" class="multisteps-form__input form-control" type="text" required />
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
                            <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label">Product Size</label>
                                <input oninput="validateNumericInput(this)" name="product_size" id="product_size" class="multisteps-form__input form-control" type="text" required />
                              </div>
                            </div>

                            <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label">Product Quantity</label>
                                <input oninput="validateNumericInput(this)" name="quantity" id="quantity" class="multisteps-form__input form-control" type="text" required />
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label">Product Buying Price</label>
                                <input oninput="validateNumericInput(this)" name="original_price" id="original_price" class="multisteps-form__input form-control" type="text" required />
                              </div>
                            </div>

                            <div class="col-6 col-sm-6 mt-3 mt-sm-0">
                              <div class="input-group input-group-dynamic">
                                <label class="form-label">Product Box Price</label>
                                <input oninput="validateNumericInput(this)" name="sell_price" id="sell_price" class="multisteps-form__input form-control" type="text" required />
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
    // Function to allow only letters
    function validateLetters(input) {
      input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }

    // Function to allow only numbers
    function validateNumbers(input) {
      input.value = input.value.replace(/[^0-9]/g, '').substring(0, 13);
    }
  </script>

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
        fileInput.files = files; // set files to the input field
        previewImage(fileInput, inputDiv.id.split('-')[2]); // Preview image
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
        preview.style.display = 'block'; // Show the preview image
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
  </script>

  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script src="assets/js/material-dashboard.min.js?v=3.0.6"></script>

  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8b722938298e3d36","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>

</body>

</html>