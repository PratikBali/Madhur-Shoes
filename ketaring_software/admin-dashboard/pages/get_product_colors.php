<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product colors and price based on selected product
if (isset($_POST['category']) && isset($_POST['product_name']) ) {
    $category = $conn->real_escape_string($_POST['category']);
    $product_name = $conn->real_escape_string($_POST['product_name']);

    // Query to fetch colors and product price
    $color_query = "
        SELECT product_color, product_id 
        FROM main_shoes 
        WHERE product_name = '$product_name' 
        AND category = '$category'";
    
    $color_result = $conn->query($color_query);

    // Output the options for the second dropdown and product price
    echo '<option value="">-- Select Color --</option>';
    if ($color_result->num_rows > 0) {
        while ($row = $color_result->fetch_assoc()) {
            echo '<option value="' . $row['product_color'] . '" product_id="' . $row['product_id'] . '">' . $row['product_color'] . '</option>';
        }
    } else {
        echo '<option value="">No colors available</option>';
    }
}
?>

