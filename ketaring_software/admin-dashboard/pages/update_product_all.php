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
} else {
    echo "Admin details not found.";
    exit();
}


try {
    // Prepare the statement with a placeholder
    $stmt = $conn->prepare("SELECT * FROM main_shoes");
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all rows as an associative array
    $shoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalDoneThisMonth = count($shoes);
    
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
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
    admin
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
      <!--div class="row">
        <div class="col-lg-8">
          <div class="row">
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
                      <h6 class="text-center mb-0">Salary</h6>
                      <span class="text-xs">Belong Interactive</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">+$2000</h5>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fab fa-paypal opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Paypal</h6>
                      <span class="text-xs">Freelance Payment</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">$455.00</h5>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>

            <div class="col-md-4 mt-md-0 mt-4">
              <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                  <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                    <i class="fab fa-paypal opacity-10"></i>
                  </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                  <h6 class="text-center mb-0">akash</h6>
                  <span class="text-xs">Freelance Payment</span>
                  <hr class="horizontal dark my-3">
                  <h5 class="mb-0">$455.00</h5>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div-->


      <div class="row my-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Projects</h6>
                  <p class="text-sm mb-0">
                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                    <span class="font-weight-bold ms-1" style="color:#ff00f7"><?php echo $totalDoneThisMonth; ?> done</span> this month
                  </p>
                </div>
                 
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">S.No.</h6></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">Product ID</h6></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">Product Name</h6></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">Color</h6></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">Quantity</h6></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">Category</h6></th>     
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><h6 style="color:#cf2aab">Operation</h6></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $serialNo = 1;?>
                    <?php foreach ($shoes as $shoe): ?>
                      <tr> 
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo $serialNo++;?></span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo htmlspecialchars($shoe['product_id']); ?></span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo htmlspecialchars($shoe['product_name']); ?></span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo htmlspecialchars($shoe['product_color']); ?></span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo htmlspecialchars($shoe['quantity']); ?></span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo htmlspecialchars($shoe['category']); ?></span>
                        </td>
                        <td class="align-middle text-center text-sm">
                        
                          <a class="btn bg-gradient-primary mt-3 w-100" href="../../address/update_product.php?product_color=<?php echo htmlspecialchars($shoe['product_color']); ?>&product_name=<?php echo htmlspecialchars($shoe['product_name']); ?>&product_id=<?php echo htmlspecialchars($shoe['product_id']); ?>">
                            <span class="text-xs font-weight-bold">Edit Info</span>
                          </a>
                        <br>
                          <a class="btn bg-gradient-dark mt-3 w-100" href="../../address/update_product_image.php?product_color=<?php echo htmlspecialchars($shoe['product_color']); ?>&product_name=<?php echo htmlspecialchars($shoe['product_name']); ?>&product_id=<?php echo htmlspecialchars($shoe['product_id']); ?>">
                            <span class="text-xs font-weight-bold">Edit Image</span>
                          </a>
                          
                        </td>
                      </tr>  
                      <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
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
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>