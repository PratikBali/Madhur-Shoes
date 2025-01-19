<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['update_bank_account_info'])) {
  
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product'];
  $category = $_POST['category'];
  $product_color = $_POST['color'];
  $size = $_POST['size'];
  $original_price = $_POST['original_price'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $total_price = $_POST['total'];
  $discount = $_POST['discount'];
  $sell_price = $_POST['sell_price'];
  $customer_name = $_POST['customer_name'];
  $phone_number = $_POST['phone_number'];

  // Begin transaction
  $conn->begin_transaction();

  try {
    // Insert the sale record into product_sales
    $stmt = $conn->prepare("INSERT INTO product_sales (product_id, product_name, category, color, size, original_price, price, quantity, total_price, discount, sell_price, customer_name, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $product_id, $product_name, $category, $product_color, $size, $original_price, $price, $quantity, $total_price, $discount, $sell_price, $customer_name, $phone_number);

    if (!$stmt->execute()) {
      throw new Exception("Error inserting sale record: " . $stmt->error);
    }

    // Determine the size column dynamically
    $size_column = $size;

    // Update the main_shoes table
    $update_query = "UPDATE main_shoes SET quantity = quantity - ?, $size_column = $size_column - ? WHERE product_name = ? AND category = ? AND product_color = ? ";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("iisss", $quantity, $quantity, $product_name, $category, $product_color);

    if (!$update_stmt->execute()) {
      throw new Exception("Error updating inventory: " . $update_stmt->error);
    }

    // Commit transaction
    $conn->commit();
    echo "<script>alert('Record added and inventory updated successfully!');</script>";
  } catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
  } finally {
    // Close statements
    $stmt->close();
    $update_stmt->close();
  }
}

// Fetch product names
$product_query = "SELECT product_name FROM main_shoes_original";
$product_result = $conn->query($product_query);

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shoes</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
      <div class="row">
        <div class="col-md-4">
          <label for="product">Select Product Name</label>
          <select id="product" class="form-control" name="product">
            <option value="">-- Select Product Name --</option>
            <?php while ($row = $product_result->fetch_assoc()): ?>
              <option value="<?= $row['product_name'] ?>"><?= $row['product_name'] ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label for="category">Select Product Category:</label>
          <select id="category" class="form-control" name="category">
            <option value="">-- Select Product Category --</option>
          </select>
        </div>

        <div class="col-md-3">
          <label for="color">Select Product Color:</label>
          <select id="color" class="form-control" name="color">
            <option value="">-- Select Product Color --</option>
          </select>
        </div>

        <div class="col-md-2">
          <label for="size">Select Size:</label>
          <select id="size" class="form-control" name="size">
            <option value="">-- Select Size --</option>
          </select>
        </div>

        <div class="col-md-2">
          <div id="product-price">
            <label for="price">Price:</label>
            <input type="text" id="price-display" class="form-control" name="price" value="--" readonly>
            <input type="hidden" id="original_price-display" class="form-control" name="original_price" value="--" readonly>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <label for="available-quantity">Available Quantity</label>
            <input type="number" id="available-quantity" class="form-control" name="available_quantity" value="--" readonly>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <label for="quantity">Enter Quantity:</label>
            <input type="number" id="quantity" class="form-control" name="quantity" value="1" min="1">
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <label for="total">Total Price:</label>
            <input type="text" id="total-price" class="form-control" name="total" value="--" readonly>
          </div>
        </div>

        <div class="col-md-2">
          <div style="position: relative;">
            <label for="discount">Enter Discount</label>
            <input type="number" id="discount" class="form-control" name="discount" value="0" min="0" max="100" style="padding-right: 30px;">
            <span style="position: absolute; right: 10px; top: 70%; transform: translateY(-50%);">%</span>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <label>Sell Product Price</label>
            <input name="sell_price" id="sell-price" class="form-control" type="text" required>
          </div>
        </div>
           
        <div class="col-md-3">
          <div>
          <!--label for="product_id">Product Id</label-->
            <input type="hidden" id="product_id" class="form-control" name="product_id" readonly>
          </div>
        </div>

      </div>
    </div>

    <div class="card-body p-3">
      <div class="row mt-3">
        <div class="card-header pb-0 p-3">
          <div class="row">
            <div class="col-6">
              <h6 class="mb-0" style="color: black;"><u><i>Personal Details</i></u></h6>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <label>Customer Name</label>
          <input name="customer_name" class="form-control" oninput="validateLetters(this)" type="text" required>
        </div>
        <div class="col-md-3">
          <label>Customer Mobile No</label>
          <input name="phone_number" class="form-control" oninput="validateNumbers(this)" type="text" required>
        </div>
      </div>

      <div class="text-center" style="margin-top: 5%;">
        <button class="btn bg-gradient-primary mb-0" name="update_bank_account_info" type="submit">
          Sale
        </button>
      </div>
    </div>
  </form>

  <script>
    // Function to allow only letters
    function validateLetters(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }

    // Function to allow only numbers
    function validateNumbers(input) {
      input.value = input.value.replace(/[^0-9]/g, '').substring(0, 10);
    }
  </script>

  <script>
    $(document).ready(function() {
      // Function to calculate the total price
      function calculateTotalPrice() {
        const price = parseFloat($('#price-display').val().replace('₹', '')); // Remove the ₹ sign and parse to float
        const quantity = parseInt($('#quantity').val()); // Get quantity as an integer
        const discountPercentage = parseFloat($('#discount').val());
        
        if (!isNaN(price) && quantity > 0) {
          const totalPrice = price * quantity;
          let discountedPrice = totalPrice; 

            if (!isNaN(discountPercentage) && discountPercentage > 0) {
              const discountAmount = (totalPrice * discountPercentage) / 100; // Calculate discount amount
              discountedPrice = totalPrice - discountAmount;
            }

          $('#total-price').val(totalPrice.toFixed(2) + '₹'); // Update the total price field
          $('#sell-price').val(discountedPrice.toFixed(2) + '₹'); // Update the sell product price field
        } else {
          $('#total-price').val('--'); // Reset total price if inputs are invalid
          $('#sell-price').val('--'); // Reset sell product price if inputs are invalid
        }
      }

      // Event handler for quantity change
      $('#quantity, #discount').on('input change', function() {
        calculateTotalPrice(); // Recalculate the total price when quantity changes
      });

      // Load category based on product selection
      $('#product').change(function() {
        const productName = $(this).val();
        if (productName) {
          $.ajax({
            url: 'get_product_category.php',
            type: 'POST',
            data: {
              product_name: productName
            },
            success: function(data) {
              $('#category').html(data);
            }
          });
        } else {
          $('#category').html('<option value="">-- Select Category --</option>');
        }
      });


      // Load colors based on product selection
      $('#category').change(function() {
        const category = $(this).val();
        const productName = $('#product').val();
        if (category && productName) {
          $.ajax({
            url: 'get_product_colors.php',
            type: 'POST',
            data: {
              category: category,
              product_name: productName
            },
            success: function(data) {
              $('#color').html(data); 
            }
          });
        } else {
          $('#color').html('<option value="">-- Select Color --</option>'); 
        }
      });


      // Load sizes based on color selection
      $('#color').change(function() {

        const selectedOption = $('#color option:selected');
        const productId = selectedOption.attr('product_id'); // Extract product_id attribute
        $('#product_id').val(productId || '--');

        const productColor = $(this).val();
        if (productColor) {
          $.ajax({
            url: 'get_sizes.php',
            type: 'POST',
            data: {
              product_color: productColor
            },
            success: function(data) {
              $('#size').html(data);
            }
          });
        } else {
          $('#size').html('<option value="">-- Select Size --</option>');
        }
      });

      // Load price and stock based on size selection
      $('#size').change(function() {
        const productSize = $(this).val();
        const productName = $('#product').val();
        const productColor = $('#color').val();

        if (productSize && productName && productColor) {
          $.ajax({
            url: 'get_product_price.php',
            type: 'POST',
            data: {
              product_size: productSize,
              product_name: productName,
              product_color: productColor
            },
            success: function(response) {
              try {
                const data = JSON.parse(response);
                if (data.price) {
                  $('#original_price-display').val(data.original_price + '₹');
                  $('#price-display').val(data.price + '₹'); // Update price field 
                  $('#available-quantity').val(data.available_quantity);
                  $('#quantity').attr('max', data.available_quantity); // Set max quantity
                  calculateTotalPrice(); // Recalculate total price
                } else {
                  alert(response); // Show error message
                  $('#price-display').val('--');
                }
              } catch (error) {
                console.error('Invalid response:', response);
              }
            }
          });
        }
      });

      // Recalculate total price when quantity changes or other fields update
      $('#product, #color, #size').change(function() {
        calculateTotalPrice();
      });
    });


    $(document).ready(function() {
      // Validate the quantity field
      $('#quantity').on('input', function() {
        const availableQuantity = parseInt($('#available-quantity').val());
        const enteredQuantity = parseInt($(this).val());

        if (enteredQuantity > availableQuantity) {
          alert('The entered quantity exceeds the available quantity.');
          $(this).val(availableQuantity); // Reset to available quantity
        } else if (enteredQuantity < 1) {
          alert('Quantity cannot be less than 1.');
          $(this).val(1); // Reset to minimum allowed value
        }
      });
    });
  </script>
</body>

</html>