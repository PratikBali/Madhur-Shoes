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
                      <th>Name</th>
                      <th>Color</th>
                      <th>Category</th>
                      <th>Quantity</th>
                      <th>Size 1</th>
                      <th>Size 2</th>
                      <th>Size 3</th>
                      <th>Size 4</th>
                      <th>Size 5</th>
                      <th>Size 6</th>
                      <th>Size 7</th>
                      <th>Size 8</th>
                      <th>Size 9</th>
                      <th>Size 10</th>
                      <!--th>Image</th-->
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
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['created_at']); ?></span>
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
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['category']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['quantity']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_1']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_2']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_3']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_4']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_5']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_6']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_7']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_8']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_9']); ?></span>
                        </td>
                        <td class="text-xs font-weight-bold text-center">
                          <span class="my-2 text-xs"><?php echo htmlspecialchars($shoe['size_10']); ?></span>
                        </td>
                        <!--td class="text-xs font-weight-bold text-center">
                          <img style="margin-top:-40%;"
                           src="../../<//?php echo htmlspecialchars($shoe['side']); ?>" alt="Product Image" class="img-fluid">
                        </span>
                        </td-->
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
        { header: 'Name', dataKey: 'name' },
        { header: 'Color', dataKey: 'color' },
        { header: 'Category', dataKey: 'category' },
        { header: 'Quantity', dataKey: 'quantity' },
        { header: 'Size 1', dataKey: 'size_1' },
        { header: 'Size 2', dataKey: 'size_2' },
        { header: 'Size 3', dataKey: 'size_3' },
        { header: 'Size 4', dataKey: 'size_4' },
        { header: 'Size 5', dataKey: 'size_5' },
        { header: 'Size 6', dataKey: 'size_6' },
        { header: 'Size 7', dataKey: 'size_7' },
        { header: 'Size 8', dataKey: 'size_8' },
        { header: 'Size 9', dataKey: 'size_9' },
        { header: 'Size 10', dataKey: 'size_10' }
    ];

    // Collect filtered rows only
    const rows = Array.from(document.querySelectorAll('#datatable-search tbody tr'))
        .filter(row => row.style.display !== 'none') // Only visible rows
        .map(row => {
            return {
                id: row.cells[0].innerText.trim(),
                date: row.cells[1].innerText.trim(),
                name: row.cells[2].querySelector('.full-name') ? row.cells[2].querySelector('.full-name').innerText.trim() : row.cells[2].innerText.trim(),
                color: row.cells[3].innerText.trim(),
                category: row.cells[4].innerText.trim(),
                quantity: row.cells[5].innerText.trim(),
                size_1: row.cells[5].innerText.trim(),
                size_2: row.cells[6].innerText.trim(),
                size_3: row.cells[7].innerText.trim(),
                size_4: row.cells[8].innerText.trim(),
                size_5: row.cells[9].innerText.trim(),
                size_6: row.cells[10].innerText.trim(),
                size_7: row.cells[11].innerText.trim(),
                size_8: row.cells[12].innerText.trim(),
                size_9: row.cells[13].innerText.trim(),
                size_10: row.cells[14].innerText.trim()
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
