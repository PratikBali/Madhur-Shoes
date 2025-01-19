<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product category and price based on selected product
if (isset($_POST['product_name'])) {
    $product_name = $conn->real_escape_string($_POST['product_name']);

    // Query to fetch category and product price
    $color_query = "
        SELECT category 
        FROM main_shoes_original 
        WHERE product_name = '$product_name'";
    
    $color_result = $conn->query($color_query);

    // Output the options for the second dropdown and product price
    echo '<option value="">-- Select Category --</option>';
    if ($color_result->num_rows > 0) {
        while ($row = $color_result->fetch_assoc()) {
            echo '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
        }
    } else {
        echo '<option value="">No category available</option>';
    }
}
?>

