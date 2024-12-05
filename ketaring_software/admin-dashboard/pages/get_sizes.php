<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Fetch available sizes based on selected color
if (isset($_POST['product_color'])) {
    $product_color = $conn->real_escape_string($_POST['product_color']);
    
    // Query to fetch size columns where value > 0
    $size_query = "SELECT size_1, size_2, size_3, size_4, size_5,size_6, size_7, size_8, size_9, size_10 FROM main_shoes WHERE product_color = '$product_color'";
    $size_result = $conn->query($size_query);

    echo '<option value="">-- Select Size --</option>';
    if ($size_result->num_rows > 0) {
        $row = $size_result->fetch_assoc();
        foreach ($row as $size => $value) {
            if ($value > 0) {
                echo '<option value="' . $size . '">' . str_replace('size_', 'Size ', $size) . '</option>';
            }
        }
    } else {
        echo '<option value="">No sizes available</option>';
    }
}
?>
