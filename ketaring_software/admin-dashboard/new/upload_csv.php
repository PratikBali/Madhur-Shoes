<?php
session_start();
require '../../conf/db.php';

if (!isset($_SESSION['admin'])) {
  header("Location: ../../login.php");
  exit();
}

$email_id = $_SESSION['admin']; 
$admin_query = "SELECT full_name, email_id FROM admin WHERE email_id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bindParam(1, $email_id, PDO::PARAM_STR);
$stmt->execute();
$admin_details = $stmt->fetch(PDO::FETCH_OBJ);

if ($admin_details) {
  $full_name = $admin_details->full_name;
  $email_id = $admin_details->email_id;
} else {
  echo "Admin details not found.";
  exit();
}

$message = '';
$uploadedData = [];

if (isset($_POST['import'])) {
  if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");

    $rowCount = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
      if ($rowCount === 0) {
        // Skip header row
        $rowCount++;
        continue;
      }
      
      $product_id = $data[0];
      $bar_code_no = $data[1];
      $category = $data[2];
      $male_category = $data[3];
      $female_category = $data[4];
      $child_male_category = $data[5];
      $child_female_category = $data[6];
      $other_category = $data[7];
      $artical_no = $data[8];
      $brand_name = $data[9];
      $product_color = $data[10];
      $quantity = $data[11];
      $product_size = $data[12];
      $original_price = $data[13];
      $sell_price = $data[14];

      $insert_original_query = "INSERT INTO main_shoes_original (product_id, bar_code_no, category, male_category, female_category, 
                                                                  child_male_category, child_female_category, other_category, artical_no, 
                                                                  brand_name, product_color, quantity, product_size, original_price, sell_price) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_original_query);
      $stmt->execute([$product_id, $bar_code_no, $category, $male_category, $female_category, $child_male_category, $child_female_category, 
                      $other_category, $artical_no, $brand_name, $product_color, $quantity, $product_size, $original_price, $sell_price]);

      $insert_shoes_query = "INSERT INTO main_shoes (product_id, bar_code_no, category, male_category, female_category, 
                                                                  child_male_category, child_female_category, other_category, artical_no, 
                                                                  brand_name, product_color, quantity, product_size, original_price, sell_price) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_shoes_query);
      $stmt->execute([$product_id, $bar_code_no, $category, $male_category, $female_category, $child_male_category, $child_female_category, 
      $other_category, $artical_no, $brand_name, $product_color, $quantity, $product_size, $original_price, $sell_price]);

      $lastId = $conn->lastInsertId();

      $uploadedData[] = [
        'product_id' => $product_id,
        'bar_code_no' => $bar_code_no,
        'category' => $category,
        'male_category' => $male_category,
        'female_category' => $female_category,
        'child_male_category' => $child_male_category,
        'child_female_category' => $child_female_category,
        'other_category' => $other_category,
        'artical_no' => $artical_no,
        'brand_name' => $brand_name,
        'product_color' => $product_color,
        'quantity' => $quantity,
        'product_size' => $product_size,
        'original_price' => $original_price,
        'sell_price' => $sell_price
      ];

      $rowCount++;
    }
    fclose($handle);

    $message = "Successfully imported $rowCount rows.";
  } else {
    $message = "Please upload a valid CSV file.";
  }
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
    Shoes
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.min.css?v=1.1.1" rel="stylesheet" />

  <style>
    .table-bordered {
      border: 1px solid black;
      border-collapse: collapse;
    }
    .table-bordered th,
    .table-bordered td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }
    .table {
      width: 100%;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../config/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php include '../config/nav.php'; ?>
    <div class="container-fluid py-4">
      <div class="card-header">
        Upload CSV File
      </div>

      <div class="outer-scontainer">
        <?php if (!empty($message)) : ?>
          <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
          <input type="file" name="file" accept=".csv" required>
          <button type="submit" name="import" class="btn btn-primary btn-sm">Import</button>
        </form>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="table-responsive">
              <table class="table-bordered">
                <thead>
                  <tr>
                    <th>Product Id</th>
                    <th>Barcode No</th>
                    <th>Category</th>
                    <th>Male Category</th>
                    <th>Female Category</th>
                    <th>Child Male Category</th>
                    <th>Child Female Category</th>
                    <th>Other Category</th>
                    <th>Artical No</th>
                    <th>brand_name</th>
                    <th>Product Color</th>
                    <th>Quantity</th>
                    <th>Product Size</th>
                    <th>Original Price</th>
                    <th>Sell Price</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($uploadedData as $shoe) : ?>
                    <tr>
                      <td><?php echo htmlspecialchars($shoe['product_id']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['bar_code_no']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['category']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['male_category']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['female_category']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['child_male_category']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['child_female_category']); ?> ₹</td>
                      <td><?php echo htmlspecialchars($shoe['other_category']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['artical_no']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['brand_name']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['product_color']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['quantity']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['product_size']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['original_price']); ?></td>
                      <td><?php echo htmlspecialchars($shoe['sell_price']); ?> ₹</td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (empty($uploadedData)) : ?>
                    <tr>
                      <td colspan="8">No data uploaded yet.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>

