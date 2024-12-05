<?php
session_start();
require 'conf/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin details from the database
$email_id = $_SESSION['user']; // Assuming admin ID is stored in the session
$admin_query = "SELECT full_name, email_id, phone_number FROM users WHERE email_id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bindParam(1, $email_id, PDO::PARAM_INT);
$stmt->execute();
$admin_details = $stmt->fetch(PDO::FETCH_OBJ);

// Check if admin details were found
if ($admin_details) {
    $full_name = $admin_details->full_name;
    $email_id = $admin_details->email_id;
    $phone_number = $admin_details->phone_number;
} else {
    echo "user details not found.";
    exit();
}

$address = $_SESSION['address'];
$city = $_SESSION['city'];
$country = $_SESSION['country'];
$zip = $_SESSION['zip'];

$product_color = $_SESSION['product_color'];
$product_name = $_SESSION['product_name'];
$size = $_SESSION['size'];
$category = $_SESSION['category'];


$ret = "SELECT * FROM main_shoes WHERE product_color = ? AND product_name = ? AND category = ?";
$stmt = $conn->prepare($ret);
$stmt->bindParam(1, $product_color, PDO::PARAM_STR);
$stmt->bindParam(2, $product_name, PDO::PARAM_STR);
$stmt->bindParam(3, $category, PDO::PARAM_STR);
$stmt->execute();
$main_shoes = $stmt->fetch(PDO::FETCH_OBJ);

if ($main_shoes && isset($main_shoes->side)) {

  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $card_type = $_POST['card_type'];
      $card_number = $_POST['card_number'];
      $card_holder = $_POST['card_holder'];
      $card_expires = $_POST['card_expires'];
      $card_cvc = $_POST['card_cvc'];
      
      $product_seller_email_id = $_POST['product_seller_email_id'];
      $side = $_POST['side'];
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_color = $_POST['product_color']; 
      $size = $_POST['size']; 
      $category = $_POST['category'];

      $delivery_charge = $_POST['delivery_charge'];
      $total_amount = $_POST['total_amount'];

      $address = $_POST['address'];
      $city = $_POST['city'];
      $country = $_POST['country'];
      $zip = $_POST['zip'];

      $insert_query = "INSERT INTO credit_card (full_name, email_id, phone_number, card_type, 
      card_number, card_holder, card_expires, card_cvc, product_seller_email_id, side, product_name, product_price, product_color, 
      size, category, delivery_charge, total_amount, address, city, country, zip)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_query);
      $stmt->bindParam(1, $full_name, PDO::PARAM_STR);
      $stmt->bindParam(2, $email_id, PDO::PARAM_STR);
      $stmt->bindParam(3, $phone_number, PDO::PARAM_STR);
      $stmt->bindParam(4, $card_type, PDO::PARAM_STR);
      $stmt->bindParam(5, $card_number, PDO::PARAM_STR);
      $stmt->bindParam(6, $card_holder, PDO::PARAM_STR);
      $stmt->bindParam(7, $card_expires, PDO::PARAM_STR);
      $stmt->bindParam(8, $card_cvc, PDO::PARAM_STR);
      
      $stmt->bindParam(9, $product_seller_email_id, PDO::PARAM_STR);
      $stmt->bindParam(10, $side, PDO::PARAM_STR);
      $stmt->bindParam(11, $product_name, PDO::PARAM_STR);
      $stmt->bindParam(12, $product_price, PDO::PARAM_STR);
      $stmt->bindParam(13, $product_color, PDO::PARAM_STR);
      $stmt->bindParam(14, $size, PDO::PARAM_STR);
      $stmt->bindParam(15, $category, PDO::PARAM_STR);

      $stmt->bindParam(16, $delivery_charge, PDO::PARAM_STR);
      $stmt->bindParam(17, $total_amount, PDO::PARAM_STR);

      $stmt->bindParam(18, $address, PDO::PARAM_STR);
      $stmt->bindParam(19, $city, PDO::PARAM_STR);
      $stmt->bindParam(20, $country, PDO::PARAM_STR);
      $stmt->bindParam(21, $zip, PDO::PARAM_STR);

      if ($stmt->execute()) {
          echo "<script>
              alert('Card details saved successfully.');
              window.location.href='show_men_shoes.php?product_color={$product_color}&product_name={$product_name}&category={$category}';
          </script>";
      } else {
          echo "Failed to save card details.";
      }
  }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <style>
      @import url(https://fonts.googleapis.com/css?family=Lato:400,300,700);
      body,
      html {
        height: 100%;
        margin: 0;
        font-family: lato;
      }

      h2 {
        margin-bottom: 0px;
        margin-top: 25px;
        text-align: center;
        font-weight: 200;
        font-size: 19px;
        font-size: 1.2rem;
      }
      .container {
        height: 100%;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        background: -webkit-linear-gradient(#c5e5e5, #ccddf9);
        background: linear-gradient(#c9e5e9, #ccddf9);
      }
      .dropdown-select.visible {
        display: block;
      }
      .dropdown {
        position: relative;
      }
      ul {
        margin: 0;
        padding: 0;
      }
      ul li {
        list-style: none;
        padding-left: 10px;
        cursor: pointer;
      }
      ul li:hover {
        background: rgba(255, 255, 255, 0.1);
      }
      .dropdown-select {
        position: absolute;
        background: white;
        color: #000;
        text-align: left;
        box-shadow: 0px 3px 5px 0px rgba(0, 0, 0, 0.1);
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        width: 90%;
        left: 2px;
        line-height: 2em;
        margin-top: 2px;
        box-sizing: border-box;
      }
      .thin {
        font-weight: 400;
      }
      .small {
        font-size: 12px;
        font-size: 0.8rem;
      }
      .half-input-table {
        border-collapse: collapse;
        width: 100%;
      }
      .half-input-table td:first-of-type {
        border-right: 10px solid #ff007a;
        width: 50%;
      }
      .window {
        height: 540px;
        width: 800px;
        background: black;
        color: white;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        box-shadow: 0px 15px 50px 10px rgba(0, 0, 0, 0.2);
        border-radius: 30px;
        z-index: 10;
      }
      .order-info {
        height: 100%;
        width: 50%;
        padding-left: 25px;
        padding-right: 25px;
        box-sizing: border-box;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        position: relative;
      }
      .price {
        bottom: 0px;
        position: absolute;
        right: 0px;
        color: white;
      }
      .order-table td:first-of-type {
        width: 25%;
      }
      .order-table {
        position: relative;
      }
      .line {
        height: 1px;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
        background: #ddd;
      }
      .order-table td:last-of-type {
        vertical-align: top;
        padding-left: 25px;
      }
      .order-info-content {
        table-layout: fixed;
      }

      .full-width {
        width: 100%;
        background-color: white;
        display: block;
        box-shadow: 1px 1px 20px white;
      }
      .pay-btn {
        border: none;
        background: #000000;
        line-height: 2em;
        border-radius: 10px;
        font-size: 19px;
        font-size: 1.2rem;
        color: #fff;
        cursor: pointer;
        position: absolute;
        bottom: 25px;
        width: calc(100% - 50px);
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
      }
      .pay-btn:hover {
        background: #fff;
        color: #000000;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
      }

      .total {
        margin-top: 25px;
        font-size: 20px;
        font-size: 1.3rem;
        position: absolute;
        bottom: 30px;
        right: 27px;
        left: 35px;
      }
      .dense {
        line-height: 1.2em;
        font-size: 16px;
        font-size: 1rem;
      }
      .input-field {
        background: white;
        margin-bottom: 10px;
        margin-top: 3px;
        line-height: 1.5em;
        font-size: 20px;
        font-size: 1.3rem;
        border: none;
        padding: 5px 10px 5px 10px;
        color: #000000;
        box-sizing: border-box;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
      }
      .credit-info {
        background: #ff007a;
        height: 100%;
        width: 50%;
        color: #eee;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        font-size: 14px;
        font-size: 0.9rem;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        box-sizing: border-box;
        padding-left: 25px;
        padding-right: 25px;
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
        position: relative;
      }
      .dropdown-btn {
        background: white;
        color: black;
        width: 100%;
        border-radius: 5px;
        text-align: center;
        line-height: 1.5em;
        cursor: pointer;
        position: relative;
        -webkit-transition: background 0.2s ease;
        transition: background 0.2s ease;
      }
      .dropdown-btn:after {
        content: "\25BE";
        right: 8px;
        position: absolute;
      }
      .dropdown-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: black;
        -webkit-transition: background 0.2s ease;
        transition: background 0.2s ease;
      }
      .dropdown-select {
        display: none;
      }
      .credit-card-image {
        display: block;
        max-height: 80px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 35px;
        margin-bottom: 15px;
      }
      .credit-info-content {
        margin-top: 25px;
        -webkit-flex-flow: column;
        -ms-flex-flow: column;
        flex-flow: column;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
      }
      @media (max-width: 600px) {
        .window {
          width: 100%;
          height: 100%;
          display: block;
          border-radius: 0px;
        }
        .order-info {
          width: 100%;
          height: auto;
          padding-bottom: 100px;
          border-radius: 0px;
        }
        .credit-info {
          width: 100%;
          height: auto;
          padding-bottom: 100px;
          border-radius: 0px;
        } 
        .pay-btn {
          border-radius: 0px;
        }
      }

      .dropdown-btn1 {
        float: left; 
        margin-right: -15%;
      }
      .dropdown-btn1:after {
       
        position: absolute;
      }
      .dropdown-btn1:hover {
        border-color: #ddd;
        background: black;
        color: white;
        -webkit-transition: background 0.2s ease;
        transition: background 0.2s ease;
      }
      
    </style>
</head>
<body>

  <div class='container'>
    <div class='window'>
      <div class='order-info'>
        <div class='order-info-content'>
          <h2>
            <button class="dropdown-btn1" onclick="window.history.back();">
              Go Back
            </button>
            <b>Order Summary</b>
          </h2>
          <div class='line'></div>
          <table class='order-table'>
            <tbody>
              <tr> 
                <td><img src='<?php echo $main_shoes->side; ?>' class='full-width'></img>
                </td>
                <td>
                  <br> <span class='thin'><?php echo $main_shoes->product_name; ?></span>
                  <br><br> <span class='thin small'> Color &nbsp; :- &nbsp; <?php echo $main_shoes->product_color; ?>
                  &nbsp; ;  &nbsp; Size &nbsp; : &nbsp; <?php echo $size;?>
                  &nbsp; category&nbsp; : &nbsp;<?php echo $category;?><br></span>
                </td>
              </tr>
              <tr>
                <td>
                  <div class='price'><?php echo $main_shoes->product_price;?> ₹</div>
                </td> 
              </tr>
            </tbody>
          </table>
          <div class='line'></div>
          <table class='order-table'>
            <tbody>
              <tr>
                <td>
                  <a href="upi://pay?pa=akashsshinde0707@okicici&pn=akash shivasharan shinde&mc=Your%20Merchant%20Code&tid=TransactionID&am=500&tn=shoes" target="_blank">
                    <img src='shoes/pay/gpay.png' alt='Google Pay' style='max-width: 25%; margin-right: 10px;'>
                  </a>
                  <a href="upi://pay?pa=your_upi_id@bank&pn=Your%20Name&mc=Your%20Merchant%20Code&tid=TransactionID&am=Amount&tn=TransactionNote" target="_blank">
                    <img src='shoes/pay/ppay.png' alt='PhonePe' style='max-width: 15%; margin-right: 10px;'>
                  </a>
                  <a href="upi://pay?pa=your_upi_id@bank&pn=Your%20Name&mc=Your%20Merchant%20Code&tid=TransactionID&am=Amount&tn=TransactionNote" target="_blank">
                    <img src='shoes/pay/apay.png' alt='Amazon Pay' style='max-width: 15%; margin-right: 10px;'>
                  </a>
                  <a href="upi://pay?pa=your_upi_id@bank&pn=Your%20Name&mc=Your%20Merchant%20Code&tid=TransactionID&am=Amount&tn=TransactionNote" target="_blank">
                    <img src='shoes/pay/bpay.png' alt='BHIM UPI' style='max-width: 15%; margin-right: 10px;'>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>

          <div class='line'></div>
          <table class='order-table'>
            <div class='thin dense'>Product Deliver To :- </div>
            <tbody>
              <tr>
                <!--td><img src='https://dl.dropboxusercontent.com/s/nbr4koso8dpoggs/6136C1p5FjL._SL1500_.jpg' class='full-width'></img>
                </td-->
                <td>
                  <br> <span class='thin'><?php echo $full_name ?></span>
                  <br><?php echo $email_id ?><br> 
                  <span class='thin small'><?php echo $phone_number ?></span><br>
                  <span class='thin small'><?php echo $address ?></span><br>
                  <span class='thin small'>
                    <?php echo $city ?>
                    <?php echo $country ?>
                    <?php echo $zip ?>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
          <div class='line'></div>
          <div class='total'>
            <span style='float:left;'>
              <div class='thin dense'>Product Price</div>
              <div class='thin dense'>Delivery Charge</div>
              TOTAL PRICE
            </span>
            <span style='float:right; text-align:right;'>
              <div class='thin dense'><?php echo $main_shoes->product_price;?> ₹</div>
              <div class='thin dense'><?php echo $main_shoes->delivery_charge;?> ₹</div>
              <?php echo $total_amount =  $main_shoes->product_price+$main_shoes->delivery_charge;?> ₹
            </span>
          </div>
        </div>
      </div>
      <div class='credit-info'>
        <div class='credit-info-content'>

          <form method="POST" action="">

            <table class='half-input-table'>
              <tr>
                <td>Please select your card: </td>
                <td>
                  <div class='dropdown' id='card-dropdown'>
                    <select name="card_type" class="dropdown-btn" id="card_type">
                        <option value="">Select your card</option>
                        <option value="visa">Visa</option>
                        <option value="master_card">Master Card</option>
                        <option value="rupay" selected>RuPay</option>
                    </select>
                  </div>
                </td>
              </tr>
            </table>
            <img src='https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png' height='80' class='credit-card-image' id='credit-card-image'></img>
            
            <input class='input-field' name="product_seller_email_id" value="<?php echo $main_shoes->product_seller_email_id;?>" type="hidden"></input>
            <input class='input-field' name="side" value="<?php echo $main_shoes->side; ?>" type="hidden"></input>   
            <input class='input-field' name="product_name" value="<?php echo $main_shoes->product_name; ?>" type="hidden"></input>   
            <input class='input-field' name="product_price" value="<?php echo $main_shoes->product_price;?>" type="hidden"></input> 
            <input class='input-field' name="product_color" value="<?php echo $main_shoes->product_color;?>" type="hidden"></input>
            <input class='input-field' name="size" value="<?php echo $size;?>" type="hidden"></input>
            <input class='input-field' name="category" value="<?php echo $main_shoes->category;?>" type="hidden"></input>
            
            <input class='input-field' name="delivery_charge" value="<?php echo $main_shoes->delivery_charge;?>" type="hidden"></input>
            <input class='input-field' name="total_amount" value="<?php echo $total_amount =  $main_shoes->product_price+$main_shoes->delivery_charge;?>" type="hidden"></input>
            
            <input class='input-field' name="full_name" value="<?php echo $full_name ?>" type="hidden"></input>   
            <input class='input-field' name="email_id" value="<?php echo $email_id ?>" type="hidden"></input>   
            <input class='input-field' name="phone_number" value="<?php echo $phone_number ?>" type="hidden"></input>

            <input class='input-field' name="address" value="<?php echo $address ?>" type="hidden"></input>   
            <input class='input-field' name="city" value="<?php echo $city ?>" type="hidden"></input>   
            <input class='input-field' name="country" value="<?php echo $country ?>" type="hidden"></input>
            <input class='input-field' name="zip" value="<?php echo $zip ?>" type="hidden"></input>
            Card Number
            <input onkeypress="return isNumberKey(event)" class='input-field' name="card_number"></input>
            Card Holder
            <input oninput="allowLettersOnly(this)" class='input-field' name="card_holder"></input>
            <table class='half-input-table'>
              <tr>
                <td> Expires
                  <input class='input-field' name="card_expires" id="card_expires" 
                        placeholder="MM/YY" maxlength="5" required>
                </td>
                <td>CVC
                  <input maxlength="3" onkeypress="return isNumberKey(event)" class='input-field' name="card_cvc"></input>
                </td>
              </tr>
            </table>

            <button class='pay-btn' type="submit">Checkout</button>
            
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    function allowLettersOnly(input) {
      var regex = /[^A-Za-z\s]/g;
      input.value = input.value.replace(regex, '');
    }

    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      // Allow only numbers (0-9) and prevent other key events
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
    }
  </script>

  <script>
    document.getElementById("card_expires").addEventListener("input", function(e) {
      let input = e.target.value.replace(/\D/g, "");  // Remove all non-numeric characters
      if (input.length >= 2) {
        input = input.slice(0, 2) + '/' + input.slice(2);  // Insert the slash after MM
      }
      e.target.value = input;
    });
  </script>

  <script>
    document.getElementById("card_type").addEventListener("change", function () {
      var selectedCard = this.value;
      var cardImage = document.getElementById("credit-card-image");
      
      if (selectedCard === "master_card") {
          cardImage.src = "https://dl.dropboxusercontent.com/s/2vbqk5lcpi7hjoc/MasterCard_Logo.svg.png";
      } else if (selectedCard === "rupay") {
          cardImage.src = "shoes/pay/rupay.png";
      } else if (selectedCard === "visa") {
          cardImage.src = "https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png";
      } else {
          // Fallback image if needed
          cardImage.src = ""; // You can leave this blank or set a default image URL
      }
    });

    // Trigger change event on page load to set the initial image
    window.addEventListener('load', function() {
      document.getElementById("card_type").dispatchEvent(new Event('change'));
    });

  </script>

</body>
</html>

<?php
} else {
    echo "Product details not found.";
}
?>