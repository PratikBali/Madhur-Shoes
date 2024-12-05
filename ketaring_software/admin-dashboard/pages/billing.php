<?php

session_start();
require '../../conf/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit();
}

$email_id = $_SESSION['admin']; // Assuming admin ID is stored in the session
$admin_query = "SELECT full_name, email_id FROM admin WHERE email_id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bindParam(1, $email_id, PDO::PARAM_INT);
$stmt->execute();
$admin_details = $stmt->fetch(PDO::FETCH_OBJ);

// Check if admin details were found
if ($admin_details) {
    $full_name = $admin_details->full_name;
    $email_id = $admin_details->email_id;
    $admin_email_id = $admin_details->email_id;
} else {
    echo "Admin details not found.";
    exit();
}


// Check if form is submitted to update or insert bank account info
if (isset($_POST['update_bank_account_info'])) {
  $id = $_POST['id'];
  $account_no = $_POST['account_no'];
  $mobile_no = $_POST['mobile_no'];
  $account_holder_name = $_POST['account_holder_name'];
  $bank_name = $_POST['bank_name'];

  // Check if product_seller_email_id already exists in personal_info
  $check_query = "SELECT * FROM personal_info WHERE product_seller_email_id = :email_id";
  $stmt = $conn->prepare($check_query);
  $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
  $stmt->execute();
  $existing_record = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($existing_record) {
      // Update the existing record
      $update_query = "UPDATE personal_info 
                       SET account_no = :account_no, mobile_no = :mobile_no, account_holder_name = :account_holder_name, bank_name = :bank_name 
                       WHERE product_seller_email_id = :email_id";
      $stmt = $conn->prepare($update_query);

      // Bind the parameters for updating
      $stmt->bindParam(':account_no', $account_no, PDO::PARAM_STR);
      $stmt->bindParam(':mobile_no', $mobile_no, PDO::PARAM_STR);
      $stmt->bindParam(':account_holder_name', $account_holder_name, PDO::PARAM_STR);
      $stmt->bindParam(':bank_name', $bank_name, PDO::PARAM_STR);
      $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);

      // Execute the update query
      if ($stmt->execute()) {

          // Backup the updated record
          $backup_query = "INSERT INTO personal_info_all_backup (product_seller_email_id, account_no, mobile_no, account_holder_name, bank_name) 
                            VALUES (:email_id, :account_no, :mobile_no, :account_holder_name, :bank_name)";
          $backup_stmt = $conn->prepare($backup_query);
          $backup_stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
          $backup_stmt->bindParam(':account_no', $account_no, PDO::PARAM_STR);
          $backup_stmt->bindParam(':mobile_no', $mobile_no, PDO::PARAM_STR);
          $backup_stmt->bindParam(':account_holder_name', $account_holder_name, PDO::PARAM_STR);
          $backup_stmt->bindParam(':bank_name', $bank_name, PDO::PARAM_STR);
          $backup_stmt->execute();

          echo "<script>
                  alert('Bank Account Info updated successfully!');
                  window.location.href='../pages/billing.php';
                </script>";
      } else {
          echo "<script>
                  alert('Failed to update Bank Account Info.');
                </script>";
      }

  } else {
      // Insert a new record
      $insert_query = "INSERT INTO personal_info (product_seller_email_id, account_no, mobile_no, account_holder_name, bank_name) 
                       VALUES (:email_id, :account_no, :mobile_no, :account_holder_name, :bank_name)";
      $stmt = $conn->prepare($insert_query);  

      // Bind the parameters for insertion
      $stmt->bindParam(':account_no', $account_no, PDO::PARAM_STR);
      $stmt->bindParam(':mobile_no', $mobile_no, PDO::PARAM_STR);
      $stmt->bindParam(':account_holder_name', $account_holder_name, PDO::PARAM_STR);
      $stmt->bindParam(':bank_name', $bank_name, PDO::PARAM_STR);
      $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);

      // Execute the insert query
      if ($stmt->execute()) {

          // Backup the new record
          $backup_query = "INSERT INTO personal_info_all_backup (product_seller_email_id, account_no, mobile_no, account_holder_name, bank_name) 
                            VALUES (:email_id, :account_no, :mobile_no, :account_holder_name, :bank_name)";
          $backup_stmt = $conn->prepare($backup_query);
          $backup_stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
          $backup_stmt->bindParam(':account_no', $account_no, PDO::PARAM_STR);
          $backup_stmt->bindParam(':mobile_no', $mobile_no, PDO::PARAM_STR);
          $backup_stmt->bindParam(':account_holder_name', $account_holder_name, PDO::PARAM_STR);
          $backup_stmt->bindParam(':bank_name', $bank_name, PDO::PARAM_STR);
          $backup_stmt->execute();

          echo "<script>
                  alert('Bank Account Info inserted successfully!');
                  window.location.href='../pages/billing.php';
                </script>";
      } else {
          echo "<script>
                  alert('Failed to insert Bank Account Info.');
                </script>";
      }
    }
}

// Prepare the SQL query to fetch data

$sql = "SELECT * FROM personal_info WHERE product_seller_email_id = :email_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
$stmt->execute();
$shoes_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set default values in case no data is found
$id = '';
$account_no = '';
$mobile_no = '';
$account_holder_name = '';
$bank_name = '';

if (!empty($shoes_data)) {
    $shoe = $shoes_data[0]; // Assuming you want the first record if multiple exist
    $id = $shoe['id'];
    $account_no = $shoe['account_no'];
    $mobile_no = $shoe['mobile_no'];
    $account_holder_name = $shoe['account_holder_name'];
    $bank_name = $shoe['bank_name'];
} else {
    $message = "No shoes found.";
}

$no_shoes_found = empty($shoes_data);

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
</head>

<body class="g-sidenav-show  bg-gray-100">
    <!-- sidebar -->
      <?php include '../config/sidebar.php'; ?>
    <!-- End sidebar -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
      <?php include '../config/nav.php'; ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            
            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-transparent shadow-xl">
                <!--div class="overflow-hidden position-relative border-radius-xl" style="background-image: url('../assets/img/curved-images/curved14.jpg');"-->
                <div class="overflow-hidden position-relative border-radius-xl" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
                  <span class="mask bg-gradient-dark"></span>
                  <div class="card-body position-relative z-index-1 p-3">
                    <i class="text-white p-2">Bank Account Number :-</i>
                    <h5 class="text-white mt-2 mb-5 pb-0">
                      <?php echo $account_no; ?>
                    </h5>
                      
                    <div class="d-flex">
                      <div class="me-4">
                        <h6  class="text-white mb-0">
                          Mobile No:- <?php echo $mobile_no; ?>
                        </h6>
                      </div>
                    </div>

                    <div class="d-flex">
                      <div class="me-4">
                        <h6  class="text-white mb-0">
                          Name:- <?php echo $account_holder_name; ?>
                        </h6>
                      </div>
                    </div>

                    <div class="ms-auto w-100 d-flex align-items-end justify-content-end">
                      <h6  class="text-white mb-0">
                        <?php echo $bank_name; ?>
                      </h6>
                    </div> 
                      
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <div class="row">

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Total Earn Amounts</h6>
                      <hr class="horizontal dark my-3">
                      <?php
                        $sql = "SELECT *, SUM(sell_price) as total_prices FROM product_sales";
                        $stmt = $conn->prepare($sql); 
                        $stmt->execute();
                        
                        $credit_card_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($credit_card_data)) {
                          foreach ($credit_card_data as $credit_card) {
                      ?>
                      <h5 class="mb-0"><?php echo htmlspecialchars($credit_card['total_prices']); ?>&nbsp;₹</h5> 
                      <?php 
                          } 
                        }
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-check-circle opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Saled Total Products</h6>
                      <hr class="horizontal dark my-3">
                      <?php
                        $sql = "SELECT * FROM product_sales";
                        $stmt = $conn->prepare($sql); 
                        $stmt->execute();
                        
                        $credit_card_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $total_count = count($credit_card_data);

                      ?>
                      <h5 class="mb-0">  
                        <?php echo $total_count; ?>
                      </h5> 
                    </div>
                  </div>
                </div>
                
                <!--div class="col-md-6 mt-md-0 mt-4">
                  <div class="card" style="margin-top: 20px;">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-times opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Canceled Products</h6>
                      <hr class="horizontal dark my-3">
                      <//?php
                        $sql = "SELECT * FROM credit_card WHERE status = 'Canceled' AND product_seller_email_id = :email_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
                        $stmt->execute();
                        
                        $canceled_credit_cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $canceled_count = count($canceled_credit_cards);

                      ?>
                      <h5 class="mb-0">
                        <//?php echo $canceled_count; ?>
                      </h5>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 mt-md-0 mt-4">
                  <div class="card" style="margin-top: 20px;">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-sync opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">In Process Products</h6>
                      <hr class="horizontal dark my-3">
                      <//?php
                        $sql = "SELECT * FROM credit_card WHERE status = 'In Process' AND product_seller_email_id = :email_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
                        $stmt->execute();
                        
                        $in_process_credit_cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $in_process_count = count($in_process_credit_cards);

                      ?>
                      <h5 class="mb-0">
                        <//?php echo $in_process_count; ?>
                      </h5>
                    </div>
                  </div>
                </div-->

              </div>
            </div>

            <div class="col-md-12 mb-lg-0 mb-4">
              <div class="card mt-4">
                <form class="multisteps-form__form" method="POST" action="" enctype="multipart/form-data">
                  <div class="card-header pb-0 p-3">
                    <div class="row">
                      <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Bank Account Info</h6>
                      </div>
                      <div class="col-6 text-end">
                        <a href="javascript:;">
                          <button class="btn bg-gradient-dark mb-0" name="update_bank_account_info" type="submit">
                              <i class="fas fa-edit"></i>&nbsp;&nbsp;<?php echo $no_shoes_found ? 'Insert' : 'Update'; ?>
                          </button>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <div class="row"> 
                      <input value="<?php echo $id; ?>" name="id" id="numbersInput" oninput="validateNumbers(this)" class="multisteps-form__input form-control" type="hidden" required />
                      <div class="col-md-6 mb-md-0 mb-4">
                        <h6>Bank Account Number</h6>  
                        <input value="<?php echo $account_no; ?>" name="account_no" id="numbersInput" oninput="validateNumbers(this)" class="multisteps-form__input form-control" type="text" required /> 
                        </div>
                        <div class="col-md-6">
                        <h6>Bank Registered Mobile Number</h6>  
                        <input value="<?php echo $mobile_no; ?>" name="mobile_no" id="numbersInput" oninput="validateNumbers(this)" class="multisteps-form__input form-control" type="text" required />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-md-0 mb-4">
                        <h6>Bank Holder Name</h6>  
                        <input value="<?php echo $account_holder_name; ?>" name="account_holder_name" id="lettersInput" oninput="validateLetters(this)" class="multisteps-form__input form-control" type="text" required />
                      </div>
                      <div class="col-md-6">
                        <h6>Bank Name</h6>  
                        <input value="<?php echo $bank_name; ?>" name="bank_name" id="lettersInput" oninput="validateLetters(this)" class="multisteps-form__input form-control" type="text" required />
                      </div>
                    </div>
                  </div>
                </form>               
              </div>
            </div>

          </div>
        </div>

        <div class="col-lg-4">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-6 d-flex align-items-center">
                  <h6 class="mb-0">Invoices</h6>
                </div>
                <div class="col-6 text-end">
                  <a href="../new/all_bill_view.php">
                    <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body p-3 pb-0">
              <ul class="list-group">
                <?php
                  $sql = "SELECT * FROM product_sales
                          ORDER BY created_at DESC 
                          LIMIT 8
                          ";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  
                  $show_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  if (!empty($show_data)) {
                    foreach ($show_data as $show_datas) {
                ?>
                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark font-weight-bold text-sm">
                        <?php 
                          $date = new DateTime($show_datas['created_at']);
                          echo htmlspecialchars($date->format('F, d, Y')); 
                        ?>
                      </h6>
                      <span class="text-xs">
                        <?php echo htmlspecialchars($show_datas['product_name']); ?>
                      </span>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                      <?php echo htmlspecialchars($show_datas['sell_price']); ?>&nbsp;₹
                      <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">
                      <a href="../new/single_bill_view.php?
                              product_name=<?php echo htmlspecialchars($show_datas['product_name']); ?>&
                              product_price=<?php echo htmlspecialchars($show_datas['sell_price']); ?>&
                              created_at=<?php echo htmlspecialchars($show_datas['created_at']); ?>
                      "> 
                        <i class="fas fa-eye text-lg me-1"></i>
                      </a>
                      </button>
                    </div>
                  </li>
                <?php 
                    }  
                  }  
                ?> 
              </ul>
            </div>
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
    // Function to allow only letters
    function validateLetters(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }


    // Function to allow only numbers
    function validateNumbers(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
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

