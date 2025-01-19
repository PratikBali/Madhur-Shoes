<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['update_bank_account_info'])) {
  // Generate unique bill number
  $product_bill_no = 'BILL_' . time() . rand(1000, 9999);

  // Debug: Check if data is coming from the form
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';

  // Customer details
  $customer_name = $_POST['customer_name'];
  $phone_number = $_POST['phone_number'];
  $grand_total = floatval($product['total_price']) - (floatval($product['total_price']) * floatval($product['discount']) / 100);

  // Begin transaction
  $conn->begin_transaction();

  try {
      // Insert customer details
      $stmt = $conn->prepare("INSERT INTO customer_details (product_bill_no, customer_name, phone_number, grand_total) 
                              VALUES (?, ?, ?, ?)");
      $stmt->bind_param("sssd", $product_bill_no, $customer_name, $phone_number, $grand_total);

      if (!$stmt->execute()) {
          throw new Exception("Error inserting customer_details: " . $stmt->error);
      }
      echo "Customer details inserted successfully.<br>";

      // Iterate over each product in the form
      for ($i = 0; $i < count($_POST['bar_code_no']); $i++) {
          $product = [
              'product_id' => $_POST['product_id'][$i],
              'bar_code_no' => $_POST['bar_code_no'][$i],
              'category' => $_POST['category'][$i],
              'male_category' => $_POST['male_category'][$i] ?? null,
              'female_category' => $_POST['female_category'][$i] ?? null,
              'child_male_category' => $_POST['child_male_category'][$i] ?? null,
              'child_female_category' => $_POST['child_female_category'][$i] ?? null,
              'other_category' => $_POST['other_category'][$i] ?? null,
              'brand_name' => $_POST['brand_name'][$i],
              'artical_no' => $_POST['artical_no'][$i],
              'product_color' => $_POST['product_color'][$i],
              'product_size' => $_POST['product_size'][$i],
              'original_price' => $_POST['original_price'][$i],
              'aval_quantity' => $_POST['aval_quantity'][$i],
              'quantity' => $_POST['quantity'][$i],
              'total_price' => str_replace(" ₹", "", $_POST['total_price'][$i]), // Remove currency symbol
              'discount' => $_POST['discount'][$i],
              'sell_price' => str_replace(" ₹", "", $_POST['sell_price'][$i]), // Remove currency symbol
          ];

          // Insert product sale
          $stmt = $conn->prepare("INSERT INTO product_sales (product_id, product_bill_no, bar_code_no, category, male_category, 
              female_category, child_male_category, child_female_category, other_category, brand_name, artical_no, 
              product_color, product_size, original_price, aval_quantity, quantity, total_price, discount, sell_price) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param(
              "ssssssssssssssiddid",
              $product['product_id'],
              $product_bill_no,
              $product['bar_code_no'],
              $product['category'],
              $product['male_category'],
              $product['female_category'],
              $product['child_male_category'],
              $product['child_female_category'],
              $product['other_category'],
              $product['brand_name'],
              $product['artical_no'],
              $product['product_color'],
              $product['product_size'],
              $product['original_price'],
              $product['aval_quantity'],
              $product['quantity'],
              $product ['total_price'],
              $product['discount'],
              $product['sell_price']
          );

          if (!$stmt->execute()) {
              throw new Exception("Error inserting product_sales: " . $stmt->error);
          }
          echo "Product sales record inserted successfully for product {$product['bar_code_no']}<br>";

          // Update inventory in the main_shoes table
          $update_query = "UPDATE main_shoes SET quantity = quantity - ?, product_size = ? WHERE bar_code_no = ?";
          $update_stmt = $conn->prepare($update_query);
          $update_stmt->bind_param("iss", $product['quantity'], $product['product_size'], $product['bar_code_no']);

          if (!$update_stmt->execute()) {
              throw new Exception("Error updating inventory: " . $update_stmt->error);
          }
          echo "Inventory updated successfully for product {$product['bar_code_no']}<br>";
      }

      // Commit transaction
      $conn->commit();
      echo "<script>alert('All records added and inventory updated successfully!');</script>";
  } catch (Exception $e) {
      // Rollback transaction on error
      $conn->rollback();
      echo "Transaction failed: " . $e->getMessage();
  } finally {
      // Close statements
      if (isset($stmt)) $stmt->close();
      if (isset($update_stmt)) $update_stmt->close();
  }
}


// Fetch product names
$product_query = "SELECT * FROM main_shoes";
$product_result = $conn->query($product_query);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoes</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <form method="POST" action="" enctype="multipart/form-data">
    <div class="card-header pb-0 p-3">
      <div class="row">
        <div class="col-6">
          <h6 class="mb-0" style="color: black;"><u><i>Product Details</i></u></h6>
        </div>
      </div>
    </div>
    <div class="card-body p-3">

      <div class="col-md-3">
        <button type="button" id="reset_form" class="btn btn-danger mt-4">Reset Form Data</button>
      </div>

      <div class="row">

        <!-- Bar Code Number Dropdown -->

        <div class="col-md-3">
          <label for="bar_code_no">Search Bar Code Number</label>
          <input
            type="text"
            id="bar_code_search"
            class="form-control"
            placeholder="Search by last 4 digits"
            onkeyup="filterBarcodes()">
        </div>


        <div class="col-md-3">
          <label for="bar_code_no">Select Bar Code Number</label>
          <select id="bar_code_no" class="form-control" name="bar_code_no[]">
            <option value="">Select Bar Code Number</option>
            <?php while ($row = $product_result->fetch_assoc()): ?>
              <option value="<?= $row['bar_code_no'] ?>"><?= $row['bar_code_no'] ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <input type="hidden" class="form-control" id="product_id" name="product_id[]" readonly>

        <!-- Person Category -->
        <div class="col-md-3">
          <label for="category">Person Category:</label>
          <div>
            <input type="text" class="form-control" id="category" name="category[]" readonly>
          </div>
        </div>

        <!-- Additional Fields (Based on Person Category) -->
        <div id="additional_fields" class="col-md-3"></div>

      </div>

      <div class="row">

        <!-- Dynamic Fields -->
        <div class="col-md-3" id="product_fields">
          <label for="brand_name">Product Brand:</label>
          <div>
            <input type="text" class="form-control" id="product_brand" name="brand_name[]" readonly>
          </div>
        </div>

        <div class="col-md-3">
          <label for="artical_no">Artical Number:</label>
          <div>
            <input type="text" class="form-control" id="artical_no" name="artical_no[]" readonly>
          </div>
        </div>

        <div class="col-md-3">
          <label for="product_color">Product Color:</label>
          <div>
            <input type="text" class="form-control" id="product_color" name="product_color[]" readonly>
          </div>
        </div>

        <div class="col-md-3">
          <label for="product_size">Product Size:</label>
          <div>
            <input type="text" class="form-control" id="product_size" name="product_size[]" readonly>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-md-3">
          <label for="sell_price">Product Price:</label>
          <div>
            <input type="text" class="form-control" id="sell_price" name="original_price[]" readonly>
          </div>
        </div>

        <div class="col-md-3">
          <label for="aval_quantity">Available Quantity:</label>
          <div>
            <input type="text" class="form-control" id="quantity" name="aval_quantity[]" readonly>
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <label for="purchase_quantity">Purchase Quantity:</label>
            <input type="number" id="purchase_quantity" class="form-control" name="quantity[]" value="0" min="1">
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <label>Total Price</label>
            <input name="total_price[]" id="total_price" class="form-control" type="text" required>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-md-3">
          <div style="position: relative;">
            <label for="discount">Enter Discount</label>
            <input type="number" id="discount" class="form-control" name="discount[]" value="0" min="0" max="100" style="padding-right: 30px;">
            <span style="position: absolute; right: 10px; top: 70%; transform: translateY(-50%);">%</span>
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <label>Sell Price</label>
            <input name="sell_price[]" id="sell_price_final" class="form-control" type="text" required>
          </div>
        </div>

        <div class="col-md-3">
          <button type="button" id="add_product" class="btn btn-primary mt-4">Add Product</button>
        </div>

      </div>

      <!-- Table to display added products -->
      <div class="mt-4">
        <table class="table table-bordered" id="product_table">
          <thead>
            <tr>
              <th>Bar Code No</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Article No</th>
              <th>Color</th>
              <th>Size</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Discount</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <td colspan="9" class="text-right"><strong>Grand Total:</strong></td>
              <td id="grand_total">0 ₹</td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="row d-flex justify-content-center text-center">
        <div class="col-md-3">
          <label>Customer Name</label>
          <input name="customer_name" class="form-control" oninput="validateLetters(this)" type="text" required>
        </div>
        <div class="col-md-3">
          <label>Customer Mobile No</label>
          <input name="phone_number" class="form-control" oninput="validateNumbers(this)" type="text" required>
        </div>
      </div>

      <div class="text-center" style="margin-top: 2%;">
        <button class="btn bg-gradient-primary mb-0" name="update_bank_account_info" type="submit">
          Sale
        </button>
      </div>
    </div>

    </div>
  </form>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $('#reset_form').click(function() {
      $('#bar_code_no').val('');
      $('#bar_code_search').val('');
      $('#category').val('');
      $('#product_brand').val('');
      $('#artical_no').val('');
      $('#product_color').val('');
      $('#product_size').val('');
      $('#sell_price').val('');
      $('#quantity').val('');
      $('#purchase_quantity').val(0);
      $('#discount').val(0);
      $('#total_price').val(0);
      $('#sell_price_final').val('');
    });
  </script>

  <script>
    function filterBarcodes() {
      const input = document.getElementById('bar_code_search');
      const filter = input.value.slice(-4).toLowerCase(); // Get last 4 digits
      const select = document.getElementById('bar_code_no');
      const options = select.getElementsByTagName('option');

      for (let i = 1; i < options.length; i++) { // Skip the first option
        const txtValue = options[i].textContent || options[i].innerText;
        options[i].style.display = txtValue.endsWith(filter) ? '' : 'none';
      }
    }
  </script>

  <script>
    $(document).ready(function() {
      // Function to calculate the total price
      function calculateTotalPrice() {
        const price = parseFloat($('#sell_price').val()); // Product price
        const availableQty = parseInt($('#quantity').val()); // Available quantity
        const purchaseQty = parseInt($('#purchase_quantity').val()); // Purchase quantity
        const discountPercentage = parseFloat($('#discount').val()); // Discount percentage

        if (!isNaN(price) && purchaseQty > 0 && purchaseQty <= availableQty) {
          // Calculate total price
          const totalPrice = price * purchaseQty;

          // Apply discount if valid
          let discountedPrice = totalPrice;
          if (!isNaN(discountPercentage) && discountPercentage > 0) {
            const discountAmount = (totalPrice * discountPercentage) / 100;
            discountedPrice = totalPrice - discountAmount;
          }

          // Update fields with calculated values
          $('#total_price').val(totalPrice.toFixed(2) + ' ₹');
          $('#sell_price_final').val(discountedPrice.toFixed(2) + ' ₹');
        } else {
          // Reset fields if inputs are invalid
          $('#total_price').val('--');
          $('#sell_price_final').val('--');
        }
      }

      // Trigger calculation on input or change of relevant fields
      $('#purchase_quantity, #discount').on('input change', function() {
        calculateTotalPrice();
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#bar_code_no').change(function() {
        var barCodeNo = $(this).val();

        if (barCodeNo) {
          // Send AJAX request to fetch_product_details.php
          $.ajax({
            url: 'fetch_product_details.php',
            type: 'POST',
            data: {
              bar_code_no: barCodeNo
            },
            dataType: 'json',
            success: function(response) {
              if (response) {
                // Populate fields with response data
                $('#product_id').val(response.product_id || '');
                $('#category').val(response.category || '');
                $('#product_brand').val(response.brand_name || '');
                $('#artical_no').val(response.artical_no || '');
                $('#product_color').val(response.product_color || '');
                $('#sell_price').val(response.sell_price || '');
                $('#product_size').val(response.product_size || '');
                $('#quantity').val(response.quantity || '');

                // Show additional fields based on Person Category
                let additionalFields = '';
                if (response.category === 'जेन्टस') {
                  additionalFields += '<label>Male Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="male_category[]" value="' + (response.male_category || '') + '" readonly>';
                }
                if (response.category === 'लेडीज') {
                  additionalFields += '<label>Female Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="female_category[]" value="' + (response.female_category || '') + '" readonly>';
                }
                if (response.category === 'लहान मुलगा') {
                  additionalFields += '<label>Child Male Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="child_male_category[]" value="' + (response.child_male_category || '') + '" readonly>';
                }
                if (response.category === 'लहान मुलगी') {
                  additionalFields += '<label>Child Female Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="child_female_category[]" value="' + (response.child_female_category || '') + '" readonly>';
                }
                if (response.category === 'इतर') {
                  additionalFields += '<label>Other Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="other_category[]" value="' + (response.other_category || '') + '" readonly>';
                }

                $('#additional_fields').html(additionalFields);
              } else {
                alert('No details found for the selected Bar Code Number.');
              }
            },
          });
        } else {
          // Clear fields if no bar code is selected 
          $('#product_id').val('');
          $('#category').val('');
          $('#product_brand').val('');
          $('#artical_no').val('');
          $('#product_color').val('');
          $('#additional_fields').html('');
        }
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      let grandTotal = 0;

      // Function to calculate total price
      function calculateTotalPrice() {
        const price = parseFloat($('#sell_price').val());
        const quantity = parseInt($('#purchase_quantity').val());
        const discount = parseFloat($('#discount').val());

        if (!isNaN(price) && !isNaN(quantity) && quantity > 0) {
          let totalPrice = price * quantity;
          if (!isNaN(discount) && discount > 0) {
            const discountAmount = (totalPrice * discount) / 100;
            totalPrice -= discountAmount;
          }
          $('#sell_price_final').val(totalPrice.toFixed(2) + ' ₹');
        } else {
          $('#sell_price_final').val('--');
        }
      }

      // Add product to table
      $('#add_product').click(function() {
        const barCode = $('#bar_code_no').val();
        const category = $('#category').val();
        const brand = $('#product_brand').val();
        const artical = $('#artical_no').val();
        const color = $('#product_color').val();
        const size = $('#product_size').val();
        const price = $('#sell_price').val();
        const quantity = $('#purchase_quantity').val();
        const discount = $('#discount').val();
        const total = $('#sell_price_final').val();


        if (barCode && total !== '--') {

          // Remove ' ₹' and parse to float, ensuring it's a valid number
          const numericTotal = parseFloat(total.replace(' ₹', '').trim());

          if (isNaN(numericTotal)) {
            alert('Invalid total price.');
            return;
          }

          // Append the product row to the table
          $('#product_table tbody').append(`
                <tr>
                    <td>${barCode}</td>
                    <td>${category}</td>
                    <td>${brand}</td>
                    <td>${artical}</td>
                    <td>${color}</td>
                    <td>${size}</td>
                    <td>${price}</td>
                    <td>${quantity}</td>
                    <td>${discount}%</td>
                    <td>${total}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove_product">Remove</button></td>
                </tr>
            `);

          // Update grand total
          grandTotal += numericTotal;
          $('#grand_total').text(grandTotal.toFixed(2) + ' ₹');
        } else {
          alert('Please select a product and calculate the total price.');
        }
      });

      // Remove product from table
      $('#product_table').on('click', '.remove_product', function() {
        const rowTotal = parseFloat($(this).closest('tr').find('td:nth-child(10)').text().replace(' ₹', ''));
        grandTotal -= rowTotal;
        $('#grand_total').text(grandTotal.toFixed(2) + ' ₹');
        $(this).closest('tr').remove();
      });

      // Recalculate total price on input change
      $('#purchase_quantity, #discount').on('input change', calculateTotalPrice);
    });
  </script>
</body>

</html>