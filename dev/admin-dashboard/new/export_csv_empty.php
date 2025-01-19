<?php
session_start();
require '../../conf/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit();
}

// Fetch customer and related product data
$stmt = $conn->prepare("
    SELECT * FROM main_shoes WHERE quantity = 0
");

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write BOM for UTF-8
fwrite($output, "\xEF\xBB\xBF");

// Write CSV header
fputcsv($output, ['Bar Code No', 'Category', 'Brand', 'Article No', 'Color', 'Size', 'Price', 'Quantity']);

// Write data to CSV
foreach ($results as $row) {
    fputcsv($output, [
        $row['bar_code_no'],   // Assuming these are the correct column names
        $row['category'],
        $row['brand_name'],
        $row['artical_no'],
        $row['product_color'],
        $row['product_size'],
        $row['original_price'],
        $row['quantity']
    ]);
}

// Close the output stream
fclose($output);
exit();
?>