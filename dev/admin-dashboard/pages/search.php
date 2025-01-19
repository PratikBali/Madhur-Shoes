<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'catering';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get query from the request
$query = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($query)) {
    // Fetch data matching the last 4 digits
    $stmt = $conn->prepare("SELECT * FROM main_shoes WHERE RIGHT(bar_code_no, 4) = ?");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['bar_code_no'];
    }

    echo json_encode($data);
    $stmt->close();
}

$conn->close();
?>
