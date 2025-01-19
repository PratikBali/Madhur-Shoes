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

$date_today = date('Y-m-d'); // Get today's date

$query = "SELECT SUM(total_amount) AS total_today 
          FROM credit_card 
          WHERE DATE(created_at) = :today
          AND product_seller_email_id = :email_id
          ";

$stmt = $conn->prepare($query);
$stmt->bindParam(':today', $date_today, PDO::PARAM_STR);
$stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_today = $result['total_today'] ?? 0; // Default to 0 if no records found


$date_today1 = date('Y-m-d'); // Get today's date

$query1 = "SELECT count(full_name) AS total_today_user 
          FROM credit_card 
          WHERE DATE(created_at) = :today
          AND product_seller_email_id = :email_id
          ";

$stmt = $conn->prepare($query1);
$stmt->bindParam(':today', $date_today1, PDO::PARAM_STR);
$stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_today_user = $result['total_today_user'] ?? 0; // Default to 0 if no records found



$query2 = "SELECT count(full_name) AS total_user 
          FROM credit_card 
          WHERE product_seller_email_id = :email_id
          ";

$stmt = $conn->prepare($query2);
$stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_user = $result['total_user'] ?? 0; // Default to 0 if no records found


$query3 = "SELECT SUM(total_amount) AS total_income 
          FROM credit_card 
          WHERE product_seller_email_id = :email_id
          ";

$stmt = $conn->prepare($query3);
$stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_income = $result['total_income'] ?? 0; // Default to 0 if no records found


try {
  $date_today = date('Y-m-d');

  // Prepare the statement with a placeholder
  $stmt = $conn->prepare("SELECT * FROM credit_card 
                          WHERE product_seller_email_id = :email_id
                          AND DATE(created_at) = :today
                          ");
  
  // Bind the parameter
  $stmt->bindParam(':email_id', $email_id, PDO::PARAM_STR);
  $stmt->bindParam(':today', $date_today, PDO::PARAM_STR);
  
  // Execute the query
  $stmt->execute();
  
  // Fetch all rows as an associative array
  $shoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $totalDoneThisMonth = count($shoes);
  
} catch (PDOException $e) {
  echo "Query failed: " . $e->getMessage();
}



// Query to fetch sales data by month
$query = "SELECT MONTH(created_at) as month, SUM(total_amount) as total_sales 
          FROM credit_card 
          WHERE YEAR(created_at) = YEAR(CURRENT_DATE) 
          GROUP BY MONTH(created_at)";
$stmt = $conn->prepare($query);
$stmt->execute();
$sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare an array with 12 months for the chart data
$monthly_sales = array_fill(0, 12, 0);
foreach ($sales_data as $row) {
    $month_index = $row['month'] - 1; // Months are indexed from 0 to 11
    $monthly_sales[$month_index] = $row['total_sales'];
}

// Encode the sales data as JSON
$sales_data_json = json_encode($monthly_sales);

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
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. >
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script-->
    <style>
      .circle {
        display: inline-block;
        width: 40px;  /* Circle width */
        height: 40px; /* Circle height */
        background: linear-gradient(135deg, #7928CA, #FF0080); /* Light green background */
        color: white; /* Text color */
        border-radius: 50%; /* Makes the span a circle */
        text-align: center; /* Horizontally centers the text */
        line-height: 40px; /* Vertically centers the text */
        font-weight: bold; /* Bold text */
        border: 1px solid red; /* Optional green border */
      }
    </style>
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
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Money</p>
                      <h5 class="font-weight-bolder mb-0">
                        <?php echo number_format($total_today, 2);?>
                        <!--span class="text-success text-sm font-weight-bolder">+55%</span-->
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Sales</p>
                      <h5 class="font-weight-bolder mb-0">
                        <?php echo $total_today_user;?>
                        <!--span class="text-success text-sm font-weight-bolder">+3%</span-->
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Sales</p>
                      <h5 class="font-weight-bolder mb-0">
                        <?php echo $total_user;?>
                        <!--span class="text-danger text-sm font-weight-bolder">-2%</span-->
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Money</p>
                      <h5 class="font-weight-bolder mb-0">
                        <?php echo $total_income;?>
                        <!--span class="text-success text-sm font-weight-bolder">+5%</span-->
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  
        <div class="row my-4">
          <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h6>Products</h6>
                      <p class="text-sm mb-0">
                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                        Today Sales
                        <span class="font-weight-bold ms-1">
                          <span class="circle"><?php echo $total_today_user; ?></span>
                        </span>
                      </p>
                  </div>
                  <div class="col-lg-6 col-5 my-auto text-end">
                    <div class="dropdown d-inline float-lg-end pe-4">
                      <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v text-secondary"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="navbarDropdownMenuLink2" data-popper-placement="left-start">
                        <li><a class="dropdown-item border-radius-md filter-item" data-filter="Paid" href="javascript:;">Status: Paid</a></li>
                        <li><a class="dropdown-item border-radius-md filter-item" data-filter="Refunded" href="javascript:;">Status: Refunded</a></li>
                        <li><a class="dropdown-item border-radius-md filter-item" data-filter="In Process" href="javascript:;">Status: In Process</a></li>
                        <li><a class="dropdown-item border-radius-md filter-item" data-filter="Canceled" href="javascript:;">Status: Canceled</a></li>
                        <li>
                          <hr class="horizontal dark my-2">
                        </li>
                        <li><a class="dropdown-item border-radius-md text-danger remove-filter" href="javascript:;">Remove Filter</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $serialNo = 1; ?>
                      <?php foreach ($shoes as $shoe): ?>
                        <tr>
                          <td class="text-xs font-weight-bold text-center">
                            <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['id']); ?></span>
                          </td> 
                          <td class="font-weight-bold text-center">
                            <span class="my-2 text-xs">
                              <?php 
                                $date = new DateTime($shoe['created_at']);
                                echo htmlspecialchars($date->format('F, d, Y h:i A')); 
                              ?>
                            </span>
                          </td>
                          <td class="text-xs font-weight-bold">
                            <div class="d-flex align-items-center">
                              <?php 
                                $status = htmlspecialchars($shoe['status']);

                                if ($status == 'In Process') {
                                  echo '<button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                                          <svg width="70%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                            <path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64l0 11c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437l0 11c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 256 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-11c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1l0-11c17.7 0 32-14.3 32-32s-14.3-32-32-32L320 0 64 0 32 0zM288 437l0 11L96 448l0-11c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/>
                                          </svg>
                                        </button>';
                                  echo '<span>In Process</span>';
                                } elseif ($status == 'Paid') {
                                  echo '<button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                                          <i class="fas fa-check" aria-hidden="true"></i>
                                        </button>';
                                  echo '<span>Paid</span>';
                                } elseif ($status == 'Refunded') {
                                  echo '<button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                                          <i class="fas fa-undo" aria-hidden="true"></i>
                                        </button>';
                                  echo '<span>Refunded</span>';
                                } elseif ($status == 'Canceled') {
                                  echo '<button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                                          <i class="fas fa-times" aria-hidden="true"></i>
                                        </button>';
                                  echo '<span>Canceled</span>';
                                } else {
                                  echo '<button class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                                          <i class="fas fa-question" aria-hidden="true"></i>
                                        </button>';
                                  echo '<span>Unknown Status</span>';
                                }
                              ?>
                            </div>
                          </td>
                          <td class="text-xs font-weight-bold text-center">
                            <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['full_name']); ?></span>
                          </td>
                          <td class="text-xs font-weight-bold text-center">
                            <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['address']); ?></span>
                          </td>
                          <td class="text-xs font-weight-bold">
                            <div class="d-flex align-items-center">
                              <span class="full-name"><?php echo htmlspecialchars($shoe['product_name']); ?></span>
                            </div>
                          </td>
                          <td class="text-xs font-weight-bold text-center">
                            <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['product_color']); ?></span>
                          </td>
                          <td class="text-xs font-weight-bold text-center">
                            <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['product_price']); ?></span>
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
        
        <div class="row mt-4">
          <div class="col-lg-5 mb-lg-0 mb-4">
            <div class="card z-index-2">
              <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                  <div class="chart">
                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                  </div>
                </div>
                <!--h6 class="ms-2 mt-4 mb-0"> Active Users </h6>
                <p class="text-sm ms-2"> (<span class="font-weight-bolder">+23%</span>) than last week </p>
                <div class="container border-radius-lg">
                  <div class="row">
                    <div class="col-3 py-3 ps-0">
                      <div class="d-flex mb-2">
                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                          <svg width="10px" height="10px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>document</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                  <g transform="translate(154.000000, 300.000000)">
                                    <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                    <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"></path>
                                  </g>
                                </g>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <p class="text-xs mt-1 mb-0 font-weight-bold">Users</p>
                      </div>
                      <h4 class="font-weight-bolder">36K</h4>
                      <div class="progress w-75">
                        <div class="progress-bar bg-dark w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </div>
                    <div class="col-3 py-3 ps-0">
                      <div class="d-flex mb-2">
                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-info text-center me-2 d-flex align-items-center justify-content-center">
                          <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>spaceship</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                  <g transform="translate(4.000000, 301.000000)">
                                    <path class="color-background" d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z"></path>
                                    <path class="color-background" d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z"></path>
                                    <path class="color-background" d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z" opacity="0.598539807"></path>
                                    <path class="color-background" d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z" opacity="0.598539807"></path>
                                  </g>
                                </g>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <p class="text-xs mt-1 mb-0 font-weight-bold">Clicks</p>
                      </div>
                      <h4 class="font-weight-bolder">2m</h4>
                      <div class="progress w-75">
                        <div class="progress-bar bg-dark w-90" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </div>
                    <div class="col-3 py-3 ps-0">
                      <div class="d-flex mb-2">
                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                          <svg width="10px" height="10px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>credit-card</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                  <g transform="translate(453.000000, 454.000000)">
                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                  </g>
                                </g>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <p class="text-xs mt-1 mb-0 font-weight-bold">Sales</p>
                      </div>
                      <h4 class="font-weight-bolder">435$</h4>
                      <div class="progress w-75">
                        <div class="progress-bar bg-dark w-30" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </div>
                    <div class="col-3 py-3 ps-0">
                      <div class="d-flex mb-2">
                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-danger text-center me-2 d-flex align-items-center justify-content-center">
                          <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>settings</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                  <g transform="translate(304.000000, 151.000000)">
                                    <polygon class="color-background" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                    <path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                    <path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                  </g>
                                </g>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <p class="text-xs mt-1 mb-0 font-weight-bold">Items</p>
                      </div>
                      <h4 class="font-weight-bolder">43</h4>
                      <div class="progress w-75">
                        <div class="progress-bar bg-dark w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </div>
                  </div>
                </div-->
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="card z-index-2">
              <div class="card-header pb-0">
                <h6>Sales overview</h6>
                <!--p class="text-sm">
                  <i class="fa fa-arrow-up text-success"></i>
                  <span class="font-weight-bold">4% more</span> in 2021
                </p-->
              </div>
              <div class="card-body p-3">
                <div class="chart">
                  <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <select id="chartType" onchange="updateChart()">
    <option value="bar">Bar Chart</option>
    <option value="line">Line Chart</option>
    <option value="pie">Pie Chart</option>
</select>

<canvas id="myChart" height="400"></canvas>

      </div>
    </main>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script>
      let myChart;

function updateChart() {
    const chartType = document.getElementById("chartType").value;

    // Destroy the previous chart if it exists
    if (myChart) {
        myChart.destroy();
    }

    const ctx = document.getElementById("myChart").getContext("2d");

    // Chart data
    const data = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Sales",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500], // Replace with your PHP data
            backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)"],
            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)"],
            borderWidth: 1,
        }],
    };

    // Chart options
    const options = {
        responsive: true,
        plugins: {
            legend: {
                display: true,
            },
        },
    };

    // Create the chart based on the selected type
    myChart = new Chart(ctx, {
        type: chartType,
        data: data,
        options: options,
    });
}

// Initialize the chart on page load
updateChart();

    </script>
    <script> 
      document.addEventListener('DOMContentLoaded', function() {
        let currentFilter = ''; // Variable to store current filter status
        const filterItems = document.querySelectorAll('.filter-item');
        const removeFilter = document.querySelector('.remove-filter');
        const rows = Array.from(document.querySelectorAll('tbody tr'));

        // Apply filter
        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                currentFilter = this.getAttribute('data-filter');
                rows.forEach(row => {
                    const statusCell = row.querySelector('td:nth-child(3)').textContent.trim();
                    if (statusCell === currentFilter || currentFilter === 'Remove Filter') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Remove filter
        removeFilter.addEventListener('click', function() {
            currentFilter = ''; // Clear filter status
            rows.forEach(row => {
                row.style.display = '';
            });
        });
        // Export functionality
        document.querySelectorAll(".export").forEach(function(el) {
            el.addEventListener("click", function(e) {
                var type = el.dataset.type;

                var data = {
                    type: type,
                    filename: "soft-ui-" + type,
                };

                if (type === "csv") {
                    data.columnDelimiter = "|";
                }

                // Collect filtered data
                const filteredData = [];
                const headers = Array.from(document.querySelectorAll('thead th')).map(th => th.textContent.trim());
                filteredData.push(headers); // Add headers to CSV content

                rows.forEach(row => {
                    if (row.style.display !== 'none') {
                        const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
                        filteredData.push(rowData);
                    }
                });

                // Convert filteredData to CSV format
                let csvContent = "data:text/csv;charset=utf-8,"
                    + filteredData.map(e => e.join(",")).join("\n");

                // Create a download link and click it
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", data.filename + ".csv");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
      });
    </script>

    <script>

      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: <?php echo $sales_data_json; ?>, // Insert PHP data here
            maxBarThickness: 8
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: Math.max(...<?php echo $sales_data_json; ?>), // Dynamically set max value
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: true,
                color: 'red'
              },
            },
          },
        },
      });

    </script>
    
    <script>
      // Get the sales data from PHP
      var salesData = <?php echo $sales_data_json; ?>;

      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Sales Overview",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: salesData, // Use the PHP data here
              maxBarThickness: 6
            }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
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

  </body>

</html>




<script>
        var ctx = document.getElementById("chart-canvas").getContext("2d");
        var chart; // Declare chart variable

        function renderChart(type) {
            // Clear the previous chart if it exists
            if (chart) {
                chart.destroy();
            }

            var chartData = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales",
                    data: <?php echo $sales_data_json; ?>,
                    backgroundColor: type === "bar" ? "#FF0080" : "rgba(203,12,159,0.2)",
                    borderColor: type === "line" ? "#cb0c9f" : undefined,
                    borderWidth: type === "line" ? 3 : 0,
                    fill: type === "line",
                    maxBarThickness: 8
                }]
            };

            chart = new Chart(ctx, {
                type: type,
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { drawBorder: false, display: true },
                            ticks: { color: "#fff" }
                        },
                        x: {
                            ticks: { color: "white" }
                        }
                    }
                }
            });
        }

        // Initial chart render
        renderChart(document.getElementById("chartType").value);

        // Event listener for select dropdown
        document.getElementById("chartType").addEventListener("change", function () {
            renderChart(this.value);
        });
    </script>
