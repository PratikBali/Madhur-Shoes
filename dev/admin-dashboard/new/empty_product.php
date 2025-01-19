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
  $stmt = $conn->prepare("SELECT * FROM main_shoes WHERE quantity = 0");

  // Bind the parameter

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
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    Shose
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

  <link id="pagestyle" href="assets/css/soft-ui-dashboard.min.css?v=1.1.1" rel="stylesheet" />

  <style>
    .async-hide {
      opacity: 0 !important
    }

    .export-buttons .btn {
      font-size: 14px;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
    }

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
      <div class="d-sm-flex justify-content-between">
        <div>
        </div>
        <div class="d-flex">

          <div class="export-buttons mb-3">
            <button id="export-csv" class="btn btn-primary me-2" onclick="window.location.href='export_csv_empty.php'">Export CSV</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="table-responsive">
              <table class="table-bordered" id="datatable-search">
                <thead style="color: #FF0080;">
                  <tr>
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
  </main>

  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>

  <script src="assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="assets/js/plugins/jkanban/jkanban.js"></script>
  <script src="assets/js/plugins/datatables.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let currentFilter = ''; // Variable to store current filter status
      const filterItems = document.querySelectorAll('.filter-item');
      const removeFilter = document.querySelector('.remove-filter');
      const rows = Array.from(document.querySelectorAll('tbody tr'));

      // Show only rows with any size column equal to 0
      rows.forEach(row => {
        const sizeColumns = Array.from(row.querySelectorAll('td:nth-child(n+6):nth-child(-n+15)')); // Select size columns
        const hasZeroSize = sizeColumns.some(cell => cell.innerText.trim() === '0');

        if (!hasZeroSize) {
          row.style.display = 'none'; // Hide rows without size = 0
        } else {
          sizeColumns.forEach(cell => {
            if (cell.innerText.trim() === '0') {
              //cell.style.backgroundColor = 'red'; // Highlight cells with value 0
              cell.style.color = 'red';
            }
          });
        }
      });

      // Filter functionality
      filterItems.forEach(item => {
        item.addEventListener('click', function() {
          currentFilter = this.getAttribute('data-filter');
          rows.forEach(row => {
            const statusCell = row.querySelector('td:nth-child(3)').textContent.trim();
            const sizeColumns = Array.from(row.querySelectorAll('td:nth-child(n+6):nth-child(-n+15)'));
            const hasZeroSize = sizeColumns.some(cell => cell.innerText.trim() === '0');

            if (
              (statusCell === currentFilter || currentFilter === 'Remove Filter') &&
              hasZeroSize // Ensure it matches the size=0 condition
            ) {
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
          const sizeColumns = Array.from(row.querySelectorAll('td:nth-child(n+6):nth-child(-n+15)'));
          const hasZeroSize = sizeColumns.some(cell => cell.innerText.trim() === '0');

          if (hasZeroSize) {
            row.style.display = ''; // Show rows with size=0
          } else {
            row.style.display = 'none';
          }
        });
      });
      
    });
  </script>

  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script src="assets/js/soft-ui-dashboard.min.js?v=1.1.1"></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8bdd770639cd46fc","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>
</body>

</html>                        