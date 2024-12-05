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


$product_name = $_GET['product_name'];
$product_price = $_GET['product_price'];
$created_at = $_GET['created_at'];

try {
    // Prepare the statement with a placeholder
    $stmt = $conn->prepare("SELECT * FROM credit_card
                           WHERE product_name = :product_name
                           AND product_price = :product_price
                           AND created_at = :created_at
                          ");
    
    // Bind the parameter
    $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
    $stmt->bindParam(':product_price', $product_price, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    
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
            <div class="dropdown d-inline">
              <a href="javascript:;" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                Filters
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
            <div class="export-buttons mb-3">
              <button id="export-csv" class="btn btn-primary me-2">Export CSV</button>
              <button id="export-pdf" class="btn btn-danger">Export PDF</button> 
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="table-responsive">
                <table class="table table-flush" id="datatable-search">
                  <thead class="thead-light">
                    <tr>
                      <th>Id</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Customer Name</th>
                      <th>Customer Address</th>
                      <th>Product Name</th>
                      <th>Color</th>
                      <th>Price</th>
                      <th>Delivery Charge</th>
                      <th>Total Price</th>
                      <th>Image</th>
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
                            <div class="avatar avatar-xs me-2 bg-gradient-dark hide-on-print">
                              <span class="initial"><?php echo htmlspecialchars($shoe['product_name'][0]); ?></span>
                            </div>
                            <span class="full-name"><?php echo htmlspecialchars($shoe['product_name']); ?></span>
                          </div>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['product_color']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['product_price']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['delivery_charge']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['total_amount']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <img style="margin-top:-40%;"
                           src="../../<?php echo htmlspecialchars($shoe['side']); ?>" alt="Product Image" class="img-fluid">
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

    <script>
      document.getElementById('export-pdf').addEventListener('click', async function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
   
    const columns = [
        { header: 'Id', dataKey: 'id' },
        { header: 'Date', dataKey: 'date' },
        { header: 'Status', dataKey: 'status' },
        { header: 'Customer Name', dataKey: 'full_name' },
        { header: 'Customer Address', dataKey: 'address' },
        { header: 'Product Name', dataKey: 'product_name' },
        { header: 'Color', dataKey: 'color' },
        { header: 'Price', dataKey: 'price' },
        { header: 'Delivery Charge', dataKey: 'delivery_charge' },
        { header: 'Total Price', dataKey: 'total_amount' },
    ];

    // Collect filtered rows only
    const rows = Array.from(document.querySelectorAll('#datatable-search tbody tr'))
        .filter(row => row.style.display !== 'none') // Only visible rows
        .map(row => {
            return {
                id: row.cells[0].innerText.trim(),
                date: row.cells[1].innerText.trim(),
                status: row.cells[2].querySelector('span') ? row.cells[2].querySelector('span').innerText.trim() : row.cells[2].innerText.trim(),
                full_name: row.cells[3].innerText.trim(),
                address: row.cells[4].innerText.trim(),
                product_name: row.cells[5].querySelector('.full-name') ? row.cells[5].querySelector('.full-name').innerText.trim() : row.cells[5].innerText.trim(),
                color: row.cells[6].innerText.trim(),
                price: row.cells[7].innerText.trim(),
                delivery_charge: row.cells[8].innerText.trim(),
                total_amount: row.cells[9].innerText.trim()
            };
        });

    doc.autoTable({
        columns: columns,
        body: rows,
        startY: 20,
        theme: 'striped',
        headStyles: { fillColor: [22, 160, 133] },
        margin: { top: 30 },
        styles: { fontSize: 8, cellPadding: 2, lineColor: [44, 62, 80], lineWidth: 0.1 },
        head: [columns.map(col => col.header)],
        didDrawCell: async (data) => {
            if (data.column.dataKey === 'image' && data.cell.raw) {
                const img = new Image();
                img.src = data.cell.raw;
                img.onload = () => {
                    doc.addImage(img, 'PNG', data.cell.x + 5, data.cell.y + 5, 30, 30); // Adjust image placement and size
                };
            }
        }
    });

    doc.save('shoes-data.pdf');
});


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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script>
      document.getElementById('export-csv').addEventListener('click', function() {
          const headers = [];
          const rows = [];
          let imageColumnIndex = -1;

          // Get headers
          document.querySelectorAll('#datatable-search thead th').forEach((th, index) => {
              if (th.innerText !== 'Image') { // Exclude "Image" header
                  headers.push(th.innerText);
              } else {
                  imageColumnIndex = index; // Save the index of the "Image" column
              }
          });

          // Add headers to rows
          rows.push(headers);

          // Get visible table data only
          document.querySelectorAll('#datatable-search tbody tr').forEach(row => {
              if (row.style.display !== 'none') {  // Check if row is visible
                  const rowData = [];
                  Array.from(row.children).forEach((cell, index) => {
                      if (index !== imageColumnIndex) { // Skip the "Image" column data
                          if (cell.querySelector('.full-name')) {
                              rowData.push(cell.querySelector('.full-name').innerText);
                          } else {
                              rowData.push(cell.innerText);
                          }
                      }
                  });
                  rows.push(rowData);
              }
          });

          const csv = Papa.unparse(rows);
          const csvBlob = new Blob([csv], { type: 'text/csv' });
          const csvUrl = URL.createObjectURL(csvBlob);

          const link = document.createElement('a');
          link.href = csvUrl;
          link.download = 'shoes-data.csv';
          link.click();
      });
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="assets/js/soft-ui-dashboard.min.js?v=1.1.1"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8bdd770639cd46fc","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>
  </body>
</html>
