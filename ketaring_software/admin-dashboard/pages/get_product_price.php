<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['product_size']) && isset($_POST['product_name']) && isset($_POST['product_color'])) {
    $product_size = $_POST['product_size']; // E.g., "1", "2", "3"
    $product_name = $_POST['product_name'];
    $product_color = $_POST['product_color'];

    // Construct the size and price column names dynamically
    $size_column = $product_size;         // For stock quantity
    $price_column = $product_size . '_price'; // For price
    $original_price_column = $product_size . '_original_price'; // For price

    // Check if the columns exist (optional but good practice)
    $columns_result = $conn->query("SHOW COLUMNS FROM main_shoes LIKE '$size_column'");
    $price_columns_result = $conn->query("SHOW COLUMNS FROM main_shoes LIKE '$price_column'");
    $original_price_columns_result = $conn->query("SHOW COLUMNS FROM main_shoes LIKE '$original_price_column'");

    if ($columns_result->num_rows === 0 || $price_columns_result->num_rows === 0 || $original_price_columns_result->num_rows === 0) {
        echo "Error: Invalid size selected.";
        exit;
    }

    // Query the price and available quantity
    $stmt = $conn->prepare("SELECT $original_price_column AS original_price, $price_column AS price, $size_column AS available_quantity FROM main_shoes WHERE product_name = ? AND product_color = ?");
    $stmt->bind_param('ss', $product_name, $product_color);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['available_quantity'] > 0) {
                // Return the price and stock to the AJAX call
                echo json_encode(['price' => $row['price'], 'available_quantity' => $row['available_quantity'], 'original_price' => $row['original_price']]);
            } else {
                echo "Out of stock for the selected size.";
            }
        } else {
            echo "No product found.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
