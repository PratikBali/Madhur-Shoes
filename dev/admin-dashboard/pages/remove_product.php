<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if bar_code_no and product_bill_no are set in the POST request
if (isset($_POST['bar_code_no']) && isset($_POST['product_bill_no'])) {
    $bar_code_no = $_POST['bar_code_no'];
    $product_bill_no = $_POST['product_bill_no'];

    // Prepare the delete query
    $delete_query = "DELETE FROM product_sales WHERE bar_code_no = ? AND product_bill_no = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ss", $bar_code_no, $product_bill_no);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    // If required parameters are not set, return an error
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
}

// Close the database connection
$conn->close();
?>