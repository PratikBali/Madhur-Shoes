<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'catering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if bar_code_no is passed
if (isset($_POST['bar_code_no'])) {
    $bar_code_no = $conn->real_escape_string($_POST['bar_code_no']);

    // Fetch product details
    $query = "SELECT * FROM main_shoes WHERE bar_code_no = '$bar_code_no'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
