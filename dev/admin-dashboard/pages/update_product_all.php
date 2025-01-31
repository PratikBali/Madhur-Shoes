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
  <style>
    /* For main and nested tables */
    .table-bordered {
      border: 1px solid black;
      border-collapse: collapse;
      /* Removes double borders */
    }

    /* For table headers and cells */
    .table-bordered th,
    .table-bordered td {
      border: 1px solid black;
      /* Ensures a single black border */
      padding: 8px;
      /* Optional: Adjust padding for better readability */
      text-align: center;
      /* Centers the text */
    }

    /* Remove default table styling if needed */
    table {
      width: 100%;
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

                <div style="text-align: right; margin-bottom: 10px;">
                  <input style="color: #FF0080;" type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for Bill No...">
                </div>
                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table-bordered" id="recordTable">
                  <thead style="color: #FF0080;">
                    <tr>
                      <th>Action</th>
                      <th>Bar Code No</th>
                      <th>Category</th>
                      <th>Brand</th>
                      <th>Article No</th>
                      <th>Color</th>
                      <th>Size</th>
                      <th>Price</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody style="color: black;">
                    <?php $serialNo = 1; ?>
                    <?php foreach ($shoes as $shoe): ?>
                      <tr>
                        <td>

                          <a class="btn bg-gradient-primary mt-3 w-100" href="../../address/update_product.php?bar_code_no=<?php echo htmlspecialchars($shoe['bar_code_no']); ?>">
                            <span class="text-xs font-weight-bold">Edit Info</span>
                          </a>
                          <br>
                          <a class="btn bg-gradient-dark mt-3 w-100" href="../../address/update_product_image.php?bar_code_no=<?php echo htmlspecialchars($shoe['bar_code_no']); ?>">
                            <span class="text-xs font-weight-bold">Edit Image</span>
                          </a>

                        </td>
                        <td><?php echo htmlspecialchars($shoe['bar_code_no']); ?></td>
                        <td><?php echo htmlspecialchars($shoe['category']); ?></td>
                        <td><?php echo htmlspecialchars($shoe['brand_name']); ?></td>
                        <td><?php echo htmlspecialchars($shoe['artical_no']); ?></td>
                        <td><?php echo htmlspecialchars($shoe['product_color']); ?></td>
                        <td><?php echo htmlspecialchars($shoe['product_size']); ?></td>
                        <td><?php echo htmlspecialchars($shoe['original_price']); ?> ₹</td>
                        <td><?php echo htmlspecialchars($shoe['quantity']); ?></td>

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
    function searchTable() {
      var input = document.getElementById("searchInput");
      var filter = input.value.toUpperCase();
      var table = document.getElementById("recordTable");
      var rows = table.getElementsByTagName("tr");

      // Loop through all table rows (skip the header row)
      for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var match = false;

        // Check the outer table columns (Bill No, Customer Name, Phone No, Grand Total)
        for (var j = 0; j < cells.length - 1; j++) { // Exclude last column (Product Details)
          var cell = cells[j];
          var textValue = cell.textContent || cell.innerText;
          if (textValue.toUpperCase().indexOf(filter) > -1) {
            match = true;
            break;
          }
        }

        // Check the Product Details column (if it contains a nested table)
        if (!match && cells[cells.length - 1]) {
          var nestedTable = cells[cells.length - 1].querySelector('table');
          if (nestedTable) {
            var nestedRows = nestedTable.getElementsByTagName('tr');
            for (var k = 1; k < nestedRows.length; k++) { // Skip nested table header row
              var nestedCells = nestedRows[k].getElementsByTagName('td');
              for (var l = 0; l < nestedCells.length; l++) {
                var nestedText = nestedCells[l].textContent || nestedCells[l].innerText;
                if (nestedText.toUpperCase().indexOf(filter) > -1) {
                  match = true;
                  break;
                }
              }
              if (match) break;
            }
          }
        }

        // Show or hide the row based on the match
        if (match) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
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
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>