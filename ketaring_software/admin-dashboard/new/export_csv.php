<?php
session_start();
require '../../conf/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit();
}

// Fetch customer and related product data
$stmt = $conn->prepare("
    SELECT 
        cd.product_bill_no AS cd_product_bill_no,
        cd.customer_name AS cd_customer_name,
        cd.phone_number AS cd_phone_number,
        cd.grand_total AS cd_grand_total,
        ps.bar_code_no AS ps_bar_code_no,
        ps.category AS ps_category,
        ps.brand_name AS ps_brand_name,
        ps.artical_no AS ps_artical_no,
        ps.product_color AS ps_product_color,
        ps.product_size AS ps_product_size,
        ps.original_price AS ps_original_price,
        ps.quantity AS ps_quantity,
        ps.discount AS ps_discount,
        ps.sell_price AS ps_sell_price
    FROM customer_details cd
    INNER JOIN product_sales ps 
    ON cd.product_bill_no = ps.product_bill_no 
    ORDER BY cd.product_bill_no
");

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group data by product_bill_no
$groupedData = [];
foreach ($results as $row) {
    $billNo = $row['cd_product_bill_no'];
    if (!isset($groupedData[$billNo])) {
        $groupedData[$billNo] = [
            'customer_details' => [
                'customer_name' => $row['cd_customer_name'],
                'phone_number' => $row['cd_phone_number'],
                'grand_total' => $row['cd_grand_total'],
            ],
            'products' => []
        ];
    }
    $groupedData[$billNo]['products'][] = [
        'bar_code_no' => $row['ps_bar_code_no'],
        'category' => $row['ps_category'],
        'brand_name' => $row['ps_brand_name'],
        'artical_no' => $row['ps_artical_no'],
        'product_color' => $row['ps_product_color'],
        'product_size' => $row['ps_product_size'],
        'original_price' => $row['ps_original_price'],
        'quantity' => $row['ps_quantity'],
        'discount' => $row['ps_discount'],
        'sell_price' => $row['ps_sell_price'],
    ];
}

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write BOM for UTF-8
fwrite($output, "\xEF\xBB\xBF");

// Write CSV header
fputcsv($output, ['Bill No', 'Customer Name', 'Phone No', 'Grand Total', 'Bar Code No', 'Category', 'Brand', 'Article No', 'Color', 'Size', 'Price', 'Quantity', 'Discount (%)', 'Total']);

// Write data to CSV
foreach ($groupedData as $billNo => $data) {
    foreach ($data['products'] as $product) {
        fputcsv($output, [
            $billNo,
            $data['customer_details']['customer_name'],
            $data['customer_details']['phone_number'],
            $data['customer_details']['grand_total'],
            $product['bar_code_no'],
            $product['category'],
            $product['brand_name'],
            $product['artical_no'],
            $product['product_color'],
            $product['product_size'],
            $product['original_price'],
            $product['quantity'],
            $product['discount'],
            $product['sell_price'],
        ]);
    }
}

fclose($output);
exit();

?>