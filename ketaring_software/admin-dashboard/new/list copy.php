<?php
session_start();
require '../../conf/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit();
}

$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';

try {
  $stmt = $conn->query("SELECT * FROM main_shoes"); // Use PDO's query method
  $shoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array
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
              <a href="javascript:;" class="btn btn-outline-dark dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
              Filters
              </a>
              <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="navbarDropdownMenuLink2" data-popper-placement="left-start">
              <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Paid</a></li>
              <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Refunded</a></li>
              <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: In Proccess</a></li>
              <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Canceled</a></li>
              <li>
              <hr class="horizontal dark my-2">
              </li>
              <li><a class="dropdown-item border-radius-md text-danger" href="javascript:;">Remove Filter</a></li>
              </ul>
            </div>
            <button class="btn btn-icon btn-outline-dark ms-2 export" data-type="csv" type="button">
              <span class="btn-inner--icon"><i class="ni ni-archive-2"></i></span>
              <span class="btn-inner--text">Export CSV</span>
            </button>
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
                      <th>Customer</th>
                      <th>Product</th>
                      <th>Revenue</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td>
                        <div class="d-flex align-items-center"> 
                          <p class="text-xs font-weight-bold ms-2 mb-0">#10421</p>
                        </div>
                      </td>
                      <td class="font-weight-bold">
                        <span class="my-2 text-xs">1 Nov, 10:20 AM</span>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <div class="d-flex align-items-center">
                          <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                            <svg width="70%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                              <path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64l0 11c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437l0 11c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 256 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-11c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1l0-11c17.7 0 32-14.3 32-32s-14.3-32-32-32L320 0 64 0 32 0zM288 437l0 11L96 448l0-11c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/>
                            </svg>
                          </button>
                          <span>In Proccess</span>
                        </div>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-xs me-2 bg-gradient-dark">
                            <span>O</span>
                          </div>
                          <span>Orlando Imieto</span>
                        </div>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <span class="my-2 text-xs">Nike Sport V2</span>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <span class="my-2 text-xs">$140,20</span>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="d-flex align-items-center"> 
                          <p class="text-xs font-weight-bold ms-2 mb-0">#10421</p>
                        </div>
                      </td>
                      <td class="font-weight-bold">
                        <span class="my-2 text-xs">1 Nov, 10:20 AM</span>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <div class="d-flex align-items-center">
                          <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check" aria-hidden="true"></i></button>
                          <span>Paid</span>
                        </div>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-xs me-2 bg-gradient-dark">
                            <span>O</span>
                          </div>
                          <span>Orlando Imieto</span>
                        </div>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <span class="my-2 text-xs">Nike Sport V2</span>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <span class="my-2 text-xs">$140,20</span>
                      </td>
                    </tr>

                    <tr>
  <td>
    <div class="d-flex align-items-center">
      <p class="text-xs font-weight-bold ms-2 mb-0">#10423</p>
    </div>
  </td>
  <td class="font-weight-bold">
    <span class="my-2 text-xs">1 Nov, 11:13 AM</span>
  </td>
  <td class="text-xs font-weight-bold">
    <div class="d-flex align-items-center">
      <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
        <i class="fas fa-undo" aria-hidden="true"></i>
      </button>
      <span>Refunded</span>
    </div>
  </td>
  <td class="text-xs font-weight-bold">
    <div class="d-flex align-items-center">
      <div class="avatar avatar-xs me-2 bg-gradient-dark">
        <span id="initial"></span>
      </div>
      <span id="full-name">Aichael Mirra</span>
    </div>
  </td>
  <td class="text-xs font-weight-bold">
    <span class="my-2 text-xs">
      Leather Wallet
      <span class="text-secondary ms-2"> +1 more </span>
    </span>
  </td>
  <td class="text-xs font-weight-bold">
    <span class="my-2 text-xs">$25,50</span>
  </td>
</tr> 

<script>
  // Extract the first letter of the name and insert it into the avatar
  const fullName = document.getElementById("full-name").innerText;
  const firstLetter = fullName.charAt(0);
  document.getElementById("initial").innerText = firstLetter;
</script>

                     
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <p class="text-xs font-weight-bold ms-2 mb-0">#10425</p>
                        </div>
                      </td>
                      <td class="font-weight-bold">
                        <span class="my-2 text-xs">1 Nov, 1:40 PM</span>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <div class="d-flex align-items-center">
                          <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times" aria-hidden="true"></i></button>
                          <span>Canceled</span>
                        </div>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <div class="d-flex align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2 bg-gradient-dark">
                              <span>S</span>
                            </div>
                            <span>Sebastian Koga</span>
                          </div>
                        </div>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <span class="my-2 text-xs">
                          Phone Case Pink
                          <span class="text-secondary ms-2"> x 2 </span>
                        </span>
                      </td>
                      <td class="text-xs font-weight-bold">
                        <span class="my-2 text-xs">$44,90</span>
                      </td>
                    </tr>

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
      const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
        searchable: true,
        fixedHeight: false,
        perPageSelect: false
      });

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

          dataTableSearch.export(data);
        });
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

  <script src="assets/js/soft-ui-dashboard.min.js?v=1.1.1"></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8bdd770639cd46fc","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>
  </body>
</html>