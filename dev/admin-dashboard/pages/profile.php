<?php
session_start();
require '../../conf/db.php';
if (!isset($_SESSION['admin'])) {
  header("Location: ../../login.php");
  exit();
}

$email_id = $_SESSION['admin']; // Assuming admin ID is stored in the session
$admin_query = "SELECT * FROM admin WHERE email_id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bindParam(1, $email_id, PDO::PARAM_STR); // Use PDO::PARAM_STR for email
$stmt->execute();
$admin_details = $stmt->fetch(PDO::FETCH_OBJ);

// Check if admin details were found
if ($admin_details) {
  $full_name = $admin_details->full_name;
  $email_id = $admin_details->email_id;
  $phone_number = $admin_details->phone_number;
  $current_address = $admin_details->current_address;
  $account_create_date = $admin_details->account_create_date;
  $profile_image = $admin_details->profile_image;
} else {
  echo "Admin details not found.";
  exit();
}

// Handle profile update
if (isset($_POST['update_Profile_info'])) {
  $full_name = $_POST['full_name'];
  $email_id = $_POST['email_id'];
  $phone_number = $_POST['phone_number'];
  $current_address = $_POST['current_address'];
  $account_create_date = $_POST['account_create_date'];

  $update_query = "UPDATE admin 
                    SET full_name = :full_name, email_id = :email_id, phone_number = :phone_number, 
                    current_address = :current_address, account_create_date = :account_create_date
                    WHERE email_id = :admin_email_id";
  $stmt = $conn->prepare($update_query);

  // Bind the parameters for updating
  $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
  $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
  $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
  $stmt->bindParam(':current_address', $current_address, PDO::PARAM_STR);
  $stmt->bindParam(':account_create_date', $account_create_date, PDO::PARAM_STR);
  $stmt->bindParam(':admin_email_id', $_SESSION['admin'], PDO::PARAM_STR);

  // Execute the update query
  if ($stmt->execute()) {
      echo "<script>
              alert('Profile Info updated successfully!');
              window.location.href='../pages/profile.php';
            </script>";
  } else {
      echo "<script>
              alert('Failed to update Profile Info.');
            </script>";
  }
}


// Handle profile Image update
if (isset($_POST['update_Profile_image'])) {
  if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    // Set the directory where you want to save the uploaded images
    $upload_dir = '../profile_image/';
    
    // Check if directory exists, if not, create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);  // Create the directory with write permissions
    }

    // Unique filename to avoid overwriting
    $profile_image_name = time() . '_' . basename($_FILES['profile_image']['name']);
    $target_file = $upload_dir . $profile_image_name;

    // Move the uploaded file to the designated directory
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
        // Update query
        $update_query = "UPDATE admin 
                        SET profile_image = :profile_image
                        WHERE email_id = :admin_email_id";
        $stmt = $conn->prepare($update_query);

        // Bind the parameters
        $stmt->bindParam(':profile_image', $target_file, PDO::PARAM_STR);
        $stmt->bindParam(':admin_email_id', $_SESSION['admin'], PDO::PARAM_STR);

        // Execute the update query
        if ($stmt->execute()) {
            echo "<script>
                  alert('Profile Image updated successfully!');
                  window.location.href='../pages/profile.php';
                </script>";
        } else {
            echo "<script>
                  alert('Failed to update Profile Image.');
                </script>";
        }
    } else {
        echo "<script>
              alert('Failed to upload the image.');
            </script>";
    }
  } else {
      echo "<script>
            alert('No image uploaded or there was an error.');
          </script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
      Shose
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
    
    <style>
      .async-hide {
        opacity: 0 !important
      }

      .drag-inputs-container {
        display: flex;
        justify-content: space-between;
      }

      .drag-input {
        width: 50%;
        height: 250px;
        color: black;
        border: 2px dashed #cb0c9f;
        border-radius: 10px;
        text-align: center;
        margin-left: 25%;
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

  </head>

  <body class="g-sidenav-show bg-gray-100">
      <!-- sidebar -->
        <?php include '../config/sidebar.php'; ?>
      <!-- End sidebar -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
        <?php include '../config/nav.php'; ?>
      <!-- End Navbar -->
      <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
          <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
          <div class="row gx-4">
            <div class="col-auto">
              <div class="avatar avatar-xl position-relative">
                <img src="<?php echo $profile_image; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
              </div>
            </div>
            <div class="col-auto my-auto">
              <div class="h-100">
                <h5 class="mb-1">
                <?php echo $full_name; ?>
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                  Admin
                </p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
              <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
                  <li class="nav-item">
                    <span class="ms-1" style="color: black;">
                      <?php 
                        $date = new DateTime($account_create_date);
                        echo htmlspecialchars($date->format('F, d, Y')); 
                      ?>
                    </span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12 col-xl-6">
            <div class="card h-100">

              <form class="multisteps-form__form" method="POST" action="" enctype="multipart/form-data">

                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Profile Image</h6>
                    </div>
                    
                    <div class="col-md-4 text-end">
                      <a class="btn btn-link" href="javascript:;">
                        <button class="btn bg-gradient-dark mb-0" name="update_Profile_image" type="submit">
                          <i class="fas fa-user-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                            Update Image
                        </button>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="card-body p-3">
                  <div class="input-group input-group-dynamic">
                    <div class="drag-input" id="drag-input-1">
                      <p>Drag / Choose </p><p>Profile Image Here</p>
                      <input name="profile_image" type="file" accept="image/*" onchange="previewImage(this, 1)" required>
                      <img id="preview-1" src="" alt="Preview 1" style="display:none;" />
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>

          <div class="col-12 col-xl-6">
            <div class="card h-100">

              <form class="multisteps-form__form" method="POST" action="" enctype="multipart/form-data">

                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Profile Information</h6>
                    </div>
                    
                    <div class="col-md-4 text-end">
                      <a class="btn btn-link" href="javascript:;">
                        <button class="btn bg-gradient-dark mb-0" name="update_Profile_info" type="submit">
                          <i class="fas fa-user-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                            Update Info
                        </button>
                      </a>
                    </div>

                  </div>
                </div>

                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                      <strong class="text-dark">Full Name:</strong>
                      <input value="<?php echo $full_name; ?>" name="full_name" class="multisteps-form__input form-control" type="text" required />
                    </li>

                    <li class="list-group-item border-0 ps-0 text-sm">
                      <strong class="text-dark">Mobile:</strong>
                      <input value="<?php echo $phone_number; ?>" name="phone_number" class="multisteps-form__input form-control" type="text" required />
                    </li>

                    <li class="list-group-item border-0 ps-0 text-sm">
                      <strong class="text-dark">Email:</strong>
                      <input value="<?php echo $email_id; ?>" name="email_id" class="multisteps-form__input form-control" type="text" required />
                    </li>

                    <li class="list-group-item border-0 ps-0 text-sm">
                      <strong class="text-dark">Location:</strong>
                      <input value="<?php echo $current_address; ?>" name="current_address" class="multisteps-form__input form-control" type="text" required />
                    </li>

                    <!--li class="list-group-item border-0 ps-0 pb-0">
                      <strong class="text-dark text-sm">Social:</strong> &nbsp;
                      <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-facebook fa-lg"></i>
                      </a>
                      <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-twitter fa-lg"></i>
                      </a>
                      <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-instagram fa-lg"></i>
                      </a>
                    </li-->
                    
                  </ul>
                </div>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </main>
    
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    
    <script>
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


    </script>

    <script>
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
  </body>

</html>
       