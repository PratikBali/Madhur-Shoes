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

  // Fetch customer and related product data
  $stmt = $conn->prepare("
          SELECT 
              cd.product_bill_no AS cd_product_bill_no,
              cd.customer_name AS cd_customer_name,
              cd.phone_number AS cd_phone_number,
              cd.grand_total AS cd_grand_total,
              ps.bar_code_no AS ps_bar_code_no,
              ps.category AS ps_category,
              ps.brand_name AS ps_brand_name,
              ps.artical_no AS ps_artical_no,
              ps.product_color AS ps_product_color,
              ps.product_size AS ps_product_size,
              ps.original_price AS ps_original_price,
              ps.quantity AS ps_quantity,
              ps.discount AS ps_discount,
              ps.sell_price AS ps_sell_price
          FROM customer_details cd
          INNER JOIN product_sales ps 
          ON cd.product_bill_no = ps.product_bill_no 
          ORDER BY cd.product_bill_no
      ");

  // Bind and execute 
  $stmt->execute();

  // Group data by product_bill_no
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $groupedData = [];
  foreach ($results as $row) {
      $billNo = $row['cd_product_bill_no'];
      if (!isset($groupedData[$billNo])) {
          $groupedData[$billNo] = [
              'customer_details' => [
                  'customer_name' => $row['cd_customer_name'],
                  'phone_number' => $row['cd_phone_number'],
                  'grand_total' => $row['cd_grand_total'],
              ],
              'products' => []
          ];
      }
      $groupedData[$billNo]['products'][] = [
          'bar_code_no' => $row['ps_bar_code_no'],
          'category' => $row['ps_category'],
          'brand_name' => $row['ps_brand_name'],
          'artical_no' => $row['ps_artical_no'],
          'product_color' => $row['ps_product_color'],
          'product_size' => $row['ps_product_size'],
          'original_price' => $row['ps_original_price'],
          'quantity' => $row['ps_quantity'],
          'discount' => $row['ps_discount'],
          'sell_price' => $row['ps_sell_price'],
      ];
  }
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
            <button id="export-csv" class="btn btn-primary me-2" onclick="window.location.href='export_csv.php'">Export CSV</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="table-responsive">
              <table class="table-bordered">
                <thead style="color: #FF0080;">
                  <tr>
                    <th>Bill No</th>
                    <th>Customer Name</th>
                    <th>Phone No</th>
                    <th>Grand Total</th>
                    <th>Product Details</th>
                  </tr>
                </thead>
                <tbody style="color: black;">
                  <?php foreach ($groupedData as $billNo => $data): ?>
                    <tr>
                      <td class="text-center">
                        <?php echo htmlspecialchars($billNo); ?>
                      </td>
                      <td class="text-center">
                        <?php echo htmlspecialchars($data['customer_details']['customer_name']); ?>
                      </td>
                      <td class="text-center">
                        <?php echo htmlspecialchars($data['customer_details']['phone_number']); ?>
                      </td>
                      <td class="text-center">
                        <?php echo htmlspecialchars($data['customer_details']['grand_total']); ?> ₹
                      </td>
                      <td>
                        <table class="table-bordered">
                          <thead style="color: #7928CA;">
                            <tr>
                              <th>Bar Code No</th>
                              <th>Category</th>
                              <th>Brand</th>
                              <th>Article No</th>
                              <th>Color</th>
                              <th>Size</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Discount (%)</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($data['products'] as $product): ?>
                              <tr>
                                <td><?php echo htmlspecialchars($product['bar_code_no']); ?></td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['artical_no']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_color']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_size']); ?></td>
                                <td><?php echo htmlspecialchars($product['original_price']); ?> ₹</td>
                                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($product['discount']); ?>%</td>
                                <td><?php echo htmlspecialchars($product['sell_price']); ?> ₹</td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
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
  </main>

  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>

  <script src="assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="assets/js/plugins/jkanban/jkanban.js"></script>
  <script src="assets/js/plugins/datatables.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
 
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script src="assets/js/soft-ui-dashboard.min.js?v=1.1.1"></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8bdd770639cd46fc","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>
</body>

</html>
