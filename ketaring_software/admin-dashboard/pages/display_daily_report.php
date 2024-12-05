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

$query = "SELECT SUM(sell_price) AS total_today 
          FROM product_sales 
          WHERE DATE(created_at) = :today
          ";

$stmt = $conn->prepare($query);
$stmt->bindParam(':today', $date_today, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_today = $result['total_today'] ?? 0; // Default to 0 if no records found


$date_today1 = date('Y-m-d'); // Get today's date

$query1 = "SELECT count(product_id) AS total_today_user 
          FROM product_sales 
          WHERE DATE(created_at) = :today
          ";

$stmt = $conn->prepare($query1);
$stmt->bindParam(':today', $date_today1, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_today_user = $result['total_today_user'] ?? 0; // Default to 0 if no records found


try {
    $date_today = date('Y-m-d');

    // Prepare the statement with a placeholder
    $stmt = $conn->prepare("SELECT * FROM product_sales 
                          WHERE DATE(created_at) = :today
                          ");

    // Bind the parameter
    $stmt->bindParam(':today', $date_today, PDO::PARAM_STR);

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
    <style>
        .circle {
            display: inline-block;
            width: 40px;
            /* Circle width */
            height: 40px;
            /* Circle height */
            background: linear-gradient(135deg, #7928CA, #FF0080);
            /* Light green background */
            color: white;
            /* Text color */
            border-radius: 50%;
            /* Makes the span a circle */
            text-align: center;
            /* Horizontally centers the text */
            line-height: 40px;
            /* Vertically centers the text */
            font-weight: bold;
            /* Bold text */
            border: 1px solid red;
            /* Optional green border */
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
                                            <?php echo number_format($total_today, 2); ?>
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
                                            <?php echo $total_today_user; ?>
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
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Product Name</th>
                                            <th>Product Category</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Original Price</th>
                                            <th>Set Price</th>
                                            <th>Quantity</th>
                                            <th>Final Price</th>
                                            <th>Discount (%)</th>
                                            <th>Selling Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $serialNo = 1; ?>
                                        <?php foreach ($shoes as $shoe): ?>
                                            <tr>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['product_id']); ?></span>
                                                </td>
                                                <td class="font-weight-bold text-center">
                                                    <span class="my-2 text-xs">
                                                        <?php
                                                        $date = new DateTime($shoe['created_at']);
                                                        echo htmlspecialchars($date->format('F, d, Y h:i A'));
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['customer_name']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['product_name']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['category']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['color']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['original_price']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['price']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['quantity']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['total_price']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['discount']); ?></span>
                                                </td>
                                                <td class="text-xs font-weight-bold text-center">
                                                    <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['sell_price']); ?></span>
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
                    legend: {
                        display: false
                    }
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
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                };
            } else {
                chartOptions.scales = {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            display: true
                        },
                        ticks: {
                            color: "#fff"
                        }
                    },
                    x: {
                        ticks: {
                            color: "white"
                        }
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
        document.getElementById("chartType").addEventListener("change", function() {
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
