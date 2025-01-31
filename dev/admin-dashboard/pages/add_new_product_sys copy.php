<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "catering";
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_bill_no = 'BILL_' . time() . rand(1000, 9999);
  $customer_name = $_POST['customer_name'];
  $phone_number = $_POST['phone_number'];
  $grand_total = $_POST['grand_total']; // Assuming grand_total is passed from the form

  // Insert customer details
  $sql = "INSERT INTO customer_details (product_bill_no, customer_name, phone_number, grand_total) 
            VALUES ('$product_bill_no', '$customer_name', '$phone_number', '$grand_total')";

  if (mysqli_query($conn, $sql)) {
    // Insert product sales
    foreach ($_POST['bar_code_no'] as $index => $barcode) {
      $category = $_POST['category'][$index];
      $brand_name = $_POST['brand_name'][$index];
      $artical_no = $_POST['artical_no'][$index];
      $product_color = $_POST['product_color'][$index];
      $product_size = $_POST['product_size'][$index];
      $original_price = $_POST['original_price'][$index];
      $aval_quantity = $_POST['aval_quantity'][$index];
      $quantity = $_POST['quantity'][$index];
      $discount = $_POST['discount'][$index];
      $sell_price = $_POST['sell_price'][$index];

      $sql = "INSERT INTO product_sales (product_bill_no, bar_code_no, category, brand_name, artical_no, product_color, product_size, original_price, aval_quantity, quantity, discount, sell_price) 
                    VALUES ('$product_bill_no', '$barcode', '$category', '$brand_name', '$artical_no', '$product_color', '$product_size', '$original_price', '$aval_quantity', '$quantity', '$discount', '$sell_price')";

      mysqli_query($conn, $sql);

      // Update inventory
      $update_inventory = "UPDATE main_shoes SET quantity = quantity - $quantity WHERE bar_code_no = '$barcode'";
      mysqli_query($conn, $update_inventory);
    }
    echo "<script>alert('Order saved successfully!');</script>";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

$product_query = "SELECT bar_code_no FROM main_shoes_original";
$product_result = $conn->query($product_query);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoes</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

<body>
  <div class="card-header pb-0 p-3">
    <div class="row">
      <div class="col-6">
        <h6 class="mb-0" style="color: black;"><u><i>Product Details</i></u></h6>
      </div>
    </div>
  </div>
  <div class="card-body p-3">
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="col-md-3">
        <button type="button" id="reset_form" class="btn btn-danger mt-4">Reset Form Data</button>
      </div>
      <div class="row">
        <input type="hidden" id="product_bill_no" class="form-control" name="product_bill_no" readonly>
        <script>
          function generateBillNumber() {
            const timestamp = Date.now();
            const randomNum = Math.floor(Math.random() * 9000) + 1000;
            const billNumber = `BILL_${timestamp}_${randomNum}`;
            document.getElementById('product_bill_no').value = billNumber;
          }
          window.onload = generateBillNumber;
        </script>
        <div class="col-md-3">
          <label for="bar_code_no">Search Bar Code Number</label>
          <input type="text" id="bar_code_search" class="form-control" placeholder="Search by last 4 digits" onkeyup="filterBarcodes()">
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
        <input type="hidden" class="form-control" id="product_id" name="product_id" readonly>
        <div class="col-md-3">
          <label for="category">Person Category:</label>
          <input type="text" class="form-control" id="category" name="category" readonly>
        </div>
        <div id="additional_fields" class="col-md-3"></div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <label for="brand_name">Product Brand:</label>
          <input type="text" class="form-control" id="brand_name" name="brand_name[]" readonly>
        </div>
        <div class="col-md-3">
          <label for="artical_no">Artical Number:</label>
          <input type="text" class="form-control" id="artical_no" name="artical_no[]" readonly>
        </div>
        <div class="col-md-3">
          <label for="product_color">Product Color:</label>
          <input type="text" class="form-control" id="product_color" name="product_color[]" readonly>
        </div>
        <div class="col-md-3">
          <label for="product_size">Product Size:</label>
          <input type="text" class="form-control" id="product_size" name="product_size[]" readonly>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <label for="original_price">Product Price:</label>
          <input type="text" class="form-control" id="original_price" name="original_price[]" readonly>
        </div>
        <div class="col-md-3">
          <label for="aval_quantity">Available Quantity:</label>
          <input type="text" class="form-control" id="aval_quantity" name="aval_quantity[]" readonly>
        </div>
        <div class="col-md-3">
          <label>Purchase Quantity:</label>
          <input type="number" id="quantity" class="form-control" name="quantity[]" value="0" min="1">
        </div>
        <div class="col-md-3">
          <label>Total Price</label>
          <input name="total_price[]" id="total_price" class="form-control" type="text" required readonly>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <label for="discount">Enter Discount</label>
          <input type="number" id="discount" class="form-control" name="discount[]" value="0" min="0" max="100">
        </div>
        <div class="col-md-3">
          <label>Sell Price</label>
          <input name="sell_price[]" id="sell_price" class="form-control" type="text" required readonly>
        </div>
        <div class="col-md-3">
          <button type="submit" id="add_product" name="update_bank_account_info" class="btn btn-primary mt-4">Add Product</button>
        </div>
      </div>
    </form>
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="mt-4">
        <table class="table-bordered" id="product_table">
          <thead style="color: #FF0080;">
            <tr>
              <th>Bar Code No</th>
              <!--th>Category</th-->
              <!--th>Brand</th-->
              <th>Article No</th>
              <!--th>Color</th-->
              <th>Size</th>
              <th>Price</th>
              <!--th>aval Quantity</th-->
              <th>Quantity</th>
              <th>Discount</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody style="color: black;">
          </tbody>
          <tfoot>
            <tr>
              <td colspan="6" class="text-right"><strong>Grand Total:</strong></td>
              <td>
                <input type="hidden" name="grand_total" id="grand_total" readonly>
                <span id="grand_total_display"></span>
              </td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="row d-flex justify-content-center text-center" style="margin-top: 20px;">
        <div class="col-md-3">
          <label>Customer Name</label>
          <input name="customer_name" class="form-control" type="text" oninput="validateLetters(this)" required>
        </div>
        <div class="col-md-3">
          <label>Customer Mobile No</label>
          <input name="phone_number" class="form-control" type="text" oninput="validateNumbers(this)" required>
        </div>
      </div>
      <div class="text-center" style="margin-top: 2%;">
        <button class="btn bg-gradient-primary mb-0" name="update_customer_info" type="submit">
          Sale
        </button>
      </div>
    </form>
  </div>

  <script>
    // Function to allow only letters
    function validateLetters(input) {
      input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }

    // Function to allow only numbers
    function validateNumbers(input) {
      var numericValue = input.value.replace(/[^0-9]/g, '');
      if (numericValue.length <= 10) {
        // Update the input value with the cleaned numeric value
        input.value = numericValue;
      } else {
        input.value = numericValue.slice(0, 10);
      }
    }

    $('#reset_form').click(function() {
      $('#bar_code_no').val('');
      $('#bar_code_search').val('');
      $('#category').val('');
      $('#brand_name').val('');
      $('#artical_no').val('');
      $('#product_color').val('');
      $('#product_size').val('');
      $('#original_price').val('');
      $('#aval_quantity').val('');
      $('#quantity').val(0);
      $('#discount').val(0);
      $('#total_price').val(0);
      $('#sell_price').val('');
    });

    function filterBarcodes() {
      const input = document.getElementById('bar_code_search');
      const filter = input.value.slice(-4).toLowerCase();
      const select = document.getElementById('bar_code_no');
      const options = select.getElementsByTagName('option');

      for (let i = 1; i < options.length; i++) {
        const txtValue = options[i].textContent || options[i].innerText;
        options[i].style.display = txtValue.endsWith(filter) ? '' : 'none';
      }
    }

    $(document).ready(function() {
      function calculateTotalPrice() {
        const price = parseFloat($('#original_price').val());
        const availableQty = parseInt($('#aval_quantity').val());
        const purchaseQty = parseInt($('#quantity').val());
        const discountPercentage = parseFloat($('#discount').val());
        if (!isNaN(price) && purchaseQty > 0 && purchaseQty <= availableQty) {
          const totalPrice = price * purchaseQty;
          let discountedPrice = totalPrice;
          if (!isNaN(discountPercentage) && discountPercentage > 0) {
            const discountAmount = (totalPrice * discountPercentage) / 100;
            discountedPrice = totalPrice - discountAmount;
          }
          $('#total_price').val(totalPrice.toFixed(2) + ' ₹');
          $('#sell_price').val(discountedPrice.toFixed(2) + ' ₹');
        } else {
          $('#total_price').val('--');
          $('#sell_price').val('--');
        }
      }

      $('#quantity, #discount').on('input change', function() {
        calculateTotalPrice();
      });

      $('#bar_code_no').change(function() {
        var barCodeNo = $(this).val();
        if (barCodeNo) {
          $.ajax({
            url: 'fetch_product_details.php',
            type: 'POST',
            data: {
              bar_code_no: barCodeNo
            },
            dataType: 'json',
            success: function(response) {
              if (response) {
                $('#product_id').val(response.product_id);
                $('#category').val(response.category);
                $('#brand_name').val(response.brand_name);
                $('#artical_no').val(response.artical_no);
                $('#product_color').val(response.product_color);
                $('#product_size').val(response.product_size);
                $('#original_price').val(response.sell_price);
                $('#aval_quantity').val(response.quantity);
                let additionalFields = '';
                if (response.category === 'male') {
                  additionalFields += '<label>Male Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="male_category" value="' + (response.male_category || '') + '" readonly>';
                }
                if (response.category === 'female') {
                  additionalFields += '<label>Female Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="female_category" value="' + (response.female_category || '') + '" readonly>';
                }
                if (response.category === 'child male') {
                  additionalFields += '<label>Child Male Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="child_male_category" value="' + (response.child_male_category || '') + '" readonly>';
                }
                if (response.category === 'child female') {
                  additionalFields += '<label>Child Female Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="child_female_category" value="' + (response.child_female_category || '') + '" readonly>';
                }
                if (response.category === 'other') {
                  additionalFields += '<label>Other Category:</label>';
                  additionalFields += '<input type="text" class="form-control" name="other_category" value="' + (response.other_category || '') + '" readonly>';
                }
                $('#additional_fields').html(additionalFields);
              } else {
                alert('No details found for the selected Bar Code Number.');
              }
            },
          });
        } else {
          $('#product_id').val('');
          $('#category').val('');
          $('#brand_name').val('');
          $('#artical_no').val('');
          $('#product_color').val('');
          $('#additional_fields').html('');
        }
      });

      let grandTotal = 0;
      $('#add_product').click(function(event) {
        event.preventDefault();
        const barCode = $('#bar_code_no').val();
        const productBillNo = $('#product_bill_no').val();
        const category = $('#category').val();
        const brand = $('#brand_name').val();
        const artical = $('#artical_no').val();
        const color = $('#product_color').val();
        const size = $('#product_size').val();
        const price = $('#original_price').val();
        const aval_quantity = $('#aval_quantity').val();
        const quantity = $('#quantity').val();
        const discount = $('#discount').val();
        const total = $('#sell_price').val();
        if (barCode && total !== '--') {
          if (!total || isNaN(parseFloat(total))) {
            alert('Invalid total price.');
            return;
          }
          const numericTotal = parseFloat(total.replace(' ₹', '').trim()); // Parse the total to a number
          if (isNaN(numericTotal)) {
            alert('Invalid total price.');
            return;
          }
          $('#product_table tbody').append(`
                        <tr>
                            
                            <input type="hidden" name="category[]" value="${category}" required readonly>
                            <input type="hidden" name="brand_name[]" value="${brand}" required readonly>
                            <input type="hidden" name="product_color[]" value="${color}" required readonly>
                            <input type="hidden" name="aval_quantity[]" value="${aval_quantity}" required readonly>

                            <td>${barCode}<input type="hidden" name="bar_code_no[]" value="${barCode}" required readonly></td>
                            <td>${artical}<input type="hidden" name="artical_no[]" value="${artical}" required readonly></td>
                            <td>${size}<input type="hidden" name="product_size[]" value="${size}" required readonly></td>
                            <td>${price}<input type="hidden" name="original_price[]" value="${price}" required readonly></td>
                            <td>${quantity}<input type="hidden" name="quantity[]" value="${quantity}" required readonly></td>
                            <td>${discount}%<input type="hidden" name="discount[]" value="${discount}%" required readonly></td>
                            <td>${total}<input type="hidden" name="sell_price[]" value="${total}" required readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove_product">Remove</button></td>
                        </tr>
                    `);
          grandTotal += numericTotal;
          $('#grand_total_display').text(grandTotal.toFixed(2));
          $('#grand_total').val(grandTotal.toFixed(2));
          $('#reset_form').click();

        } else {
          alert('Please select a product and calculate the total price.');
        }
      });

      $('#product_table').on('click', '.remove_product', function() {
        const row = $(this).closest('tr');
        const rowTotal = parseFloat(row.find('td:nth-child(10)').text().replace(' ₹', ''));
        grandTotal -= rowTotal;
        $('#grand_total').text(grandTotal.toFixed(2) + ' ₹');
        row.remove();
      });
    });
  </script>
</body>

</html>