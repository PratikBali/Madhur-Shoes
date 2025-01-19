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

$query = "SELECT count(product_id) AS total_products 
          FROM main_shoes
          ";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_products = $result['total_products'] ?? 0; // Default to 0 if no records found

$date_today1 = date('Y-m-d'); // Get today's date

$query1 = "SELECT count(product_id) AS total_today_product 
          FROM product_sales 
          WHERE DATE(created_at) = :today 
          ";

$stmt = $conn->prepare($query1);
$stmt->bindParam(':today', $date_today1, PDO::PARAM_STR); 
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_today_product = $result['total_today_product'] ?? 0; // Default to 0 if no records found


$query2 = "SELECT count(product_id) AS total_user 
          FROM product_sales 
          ";

$stmt = $conn->prepare($query2);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_user = $result['total_user'] ?? 0; // Default to 0 if no records found


$query3 = "SELECT SUM(sell_price) AS total_income 
          FROM product_sales 
          ";

$stmt = $conn->prepare($query3);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_income = $result['total_income'] ?? 0; // Default to 0 if no records found


try {
  // Prepare the statement with a placeholder
  $stmt = $conn->prepare("SELECT * FROM product_sales 
                          ORDER BY created_at DESC
                          ");
  
  // Execute the query
  $stmt->execute();
  
  // Fetch all rows as an associative array
  $shoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $totalDoneThisMonth = count($shoes);
  
} catch (PDOException $e) {
  echo "Query failed: " . $e->getMessage();
}


// Query to fetch sales data by month
$query = "SELECT MONTH(created_at) as month, SUM(sell_price) as sell_price 
          FROM product_sales 
          WHERE YEAR(created_at) = YEAR(CURRENT_DATE) 
          GROUP BY MONTH(created_at)";
$stmt = $conn->prepare($query);
$stmt->execute();
$sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare an array with 12 months for the chart data
$monthly_sales = array_fill(0, 12, 0);
foreach ($sales_data as $row) {
    $month_index = $row['month'] - 1; // Months are indexed from 0 to 11
    $monthly_sales[$month_index] = $row['sell_price'];
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
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Products</p>
                      <h5 class="font-weight-bolder mb-0">
                        <?php echo number_format($total_products);?>
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
                        <?php echo $total_today_product;?>
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

        <div class="row mt-4">
          <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2">
              <div class="card-body p-3">
                <div class="d-flex justify-content-end mb-3">
                  <h5 style="color: #FF0080;">Select Chart Type 
                  <i class="fa fa-hand-pointer" style="transform: rotate(90deg);"></i>&nbsp;&nbsp;
                  </h5>
                  <select id="chartType" class="form-select w-15" style="color: black">
                    <option value="bar">Bar Chart</option>
                    <option value="line">Line Chart</option>
                    <option value="pie">Pie Chart</option>
                  </select>
                </div>
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                  <div class="chart">
                    <canvas id="chart-canvas" class="chart-canvas" height="170"></canvas>
                  </div>
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
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    
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
      });
    </script>

    <script>
      var ctx = document.getElementById("chart-canvas").getContext("2d");
      var chart; // Declare chart variable

      function renderChart(type) {
          // Clear the previous chart if it exists in this part
          if (chart) {
              chart.destroy();
          }

          var monthColors = [
              "#FF0000", "#0000FF", "#FFFF00", "#7FFF00", "#00FF00", 
              "#00FF7F", "#00FFFF", "#FF7F00", "#007FFF", "#7F00FF", 
              "#FF00FF", "#FF007F", "#ASR43E", "#RAS1907",
          ];

          var chartData = {
              labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              datasets: [{
                  label: "Sales",
                  data: <?php echo $sales_data_json; ?>,
                  borderColor: type === "line" ? "#cb0c9f" : monthColors, // Color for line or month colors
                  backgroundColor: type === "line" ? "rgba(203,12,159,0.2)" : monthColors, // Optional fill
                  borderWidth: type === "line" ? 3 : 0,
                  fill: type === "line",
                  maxBarThickness: 8
              }]
          };

          var chartOptions = {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: { display: false }
              },
              interaction: {
                  intersect: false,
                  mode: 'index',
              },
          };

          // Specific option to hide axes only for Pie Chart 
          if (type === "pie") {
              chartOptions = {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                      legend: { display: true }
                  },
                  scales: {
                      x: { display: false },
                      y: { display: false }
                  }
              };
          } else {
              chartOptions.scales = {
                  y: {
                      beginAtZero: true,
                      grid: { drawBorder: false, display: true },
                      ticks: { color: "#fff" }
                  },
                  x: {
                      ticks: { color: "white" }
                  }
              };
          }

          // Create the chart with the selected type
          chart = new Chart(ctx, {
              type: type,
              data: chartData,
              options: chartOptions
          });
      }

      // Initial chart render
      renderChart(document.getElementById("chartType").value);

      // Event listener for select dropdown
      document.getElementById("chartType").addEventListener("change", function () {
          renderChart(this.value);
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
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script> 

  </body>

</html>
