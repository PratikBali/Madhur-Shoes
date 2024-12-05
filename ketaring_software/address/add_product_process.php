<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Auto-generate product_id
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT product_id FROM main_shoes_original ORDER BY product_id DESC LIMIT 1");
        $last_product_id = $stmt->fetchColumn();

        if ($last_product_id) {
            // Extract the numeric part and increment it
            $last_number = (int)substr($last_product_id, 3);
            $new_number = $last_number + 1;
        } else {
            // Start with 1 if no records exist
            $new_number = 1;
        }

        // Format with leading zeros (e.g., PID01, PID02, ...)
        $product_id = 'PID' . str_pad($new_number, 2, '0', STR_PAD_LEFT);
    } catch (PDOException $e) {
        die("Error generating product_id: " . $e->getMessage());
    }
} else {
    die("Database connection failed. Please check your connection settings.");
}

// Retrieve form data
$product_seller_name = $_POST['product_seller_name'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$product_color = $_POST['product_color'] ?? '';
$category = $_POST['category'] ?? '';
$sizes = [
    1 => $_POST['1'] ?? 0,
    2 => $_POST['2'] ?? 0,
    3 => $_POST['3'] ?? 0,
    4 => $_POST['4'] ?? 0,
    5 => $_POST['5'] ?? 0,
    6 => $_POST['6'] ?? 0,
    7 => $_POST['7'] ?? 0,
    8 => $_POST['8'] ?? 0,
    9 => $_POST['9'] ?? 0,
    10 => $_POST['10'] ?? 0,
];

$size_1_original_price = $_POST['size_1_original_price'] ?? '';
$size_2_original_price = $_POST['size_2_original_price'] ?? '';
$size_3_original_price = $_POST['size_3_original_price'] ?? '';
$size_4_original_price = $_POST['size_4_original_price'] ?? '';
$size_5_original_price = $_POST['size_5_original_price'] ?? '';
$size_6_original_price = $_POST['size_6_original_price'] ?? '';
$size_7_original_price = $_POST['size_7_original_price'] ?? '';
$size_8_original_price = $_POST['size_8_original_price'] ?? '';
$size_9_original_price = $_POST['size_9_original_price'] ?? '';
$size_10_original_price = $_POST['size_10_original_price'] ?? '';

$size_1_price = $_POST['size_1_price'] ?? '';
$size_2_price = $_POST['size_2_price'] ?? '';
$size_3_price = $_POST['size_3_price'] ?? '';
$size_4_price = $_POST['size_4_price'] ?? '';
$size_5_price = $_POST['size_5_price'] ?? '';
$size_6_price = $_POST['size_6_price'] ?? '';
$size_7_price = $_POST['size_7_price'] ?? '';
$size_8_price = $_POST['size_8_price'] ?? '';
$size_9_price = $_POST['size_9_price'] ?? '';
$size_10_price = $_POST['size_10_price'] ?? '';

$quantity = $_POST['quantity'] ?? 0;

// Handle file uploads
$images = ['side', 'back', 'up', 'bottom'];
$uploaded_images = [];

// Directory paths
$upload_dir_main = '../shoes/';
$upload_dir_side = '../shoes/shoes/';

// Create directories if they don't exist
if (!is_dir($upload_dir_main)) {
    mkdir($upload_dir_main, 0755, true);
}
if (!is_dir($upload_dir_side)) {
    mkdir($upload_dir_side, 0755, true);
}

foreach ($images as $image) {
    if (isset($_FILES[$image]) && $_FILES[$image]['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES[$image]['tmp_name'];
        $name = basename($_FILES[$image]['name']);
        $upload_file_main = $upload_dir_main . $name;

        if (move_uploaded_file($tmp_name, $upload_file_main)) {
            // Save the relative path for all images
            $uploaded_images[$image] = 'shoes/' . $name;

            // If the image is 'side', also copy it to the side directory
            if ($image === 'side') {
                $upload_file_side = $upload_dir_side . $name;
                if (!copy($upload_file_main, $upload_file_side)) {
                    die("Error copying side image to the secondary directory. Please try again.");
                }
            }
        } else {
            die("Error uploading $image image. Please try again.");
        }
    }
}

// Insert data into both tables
if (isset($pdo)) {
    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Insert into main_shoes_original _original
        $stmt = $pdo->prepare("INSERT INTO main_shoes_original (product_id, product_seller_name, 
                                product_name, product_color, category,
                                size_1, size_2, size_3, size_4, size_5, size_6, size_7, size_8, size_9, size_10,
                                size_1_original_price, size_2_original_price, size_3_original_price, size_4_original_price, 
                                size_5_original_price, size_6_original_price, size_7_original_price, size_8_original_price, 
                                size_9_original_price, size_10_original_price,
                                size_1_price, size_2_price, size_3_price, size_4_price, size_5_price, size_6_price,
                                size_7_price, size_8_price, size_9_price, size_10_price,
                                quantity, side, back, up, bottom) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $product_id,
            $product_seller_name,
            $product_name,
            $product_color,
            $category,
            $sizes[1],
            $sizes[2],
            $sizes[3],
            $sizes[4],
            $sizes[5],
            $sizes[6],
            $sizes[7],
            $sizes[8],
            $sizes[9],
            $sizes[10],
            $size_1_original_price,
            $size_2_original_price,
            $size_3_original_price,
            $size_4_original_price,
            $size_5_original_price,
            $size_6_original_price,
            $size_7_original_price,
            $size_8_original_price,
            $size_9_original_price,
            $size_10_original_price,
            $size_1_price,
            $size_2_price,
            $size_3_price,
            $size_4_price,
            $size_5_price,
            $size_6_price,
            $size_7_price,
            $size_8_price,
            $size_9_price,
            $size_10_price,
            $quantity,
            $uploaded_images['side'] ?? null,
            $uploaded_images['back'] ?? null,
            $uploaded_images['up'] ?? null,
            $uploaded_images['bottom'] ?? null
        ]);

        // Insert into main_shoes
        $stmt = $pdo->prepare("INSERT INTO main_shoes (product_id, product_seller_name, 
                                product_name, product_color, category,
                                size_1, size_2, size_3, size_4, size_5, size_6, size_7, size_8, size_9, size_10,
                                size_1_original_price, size_2_original_price, size_3_original_price, size_4_original_price, 
                                size_5_original_price, size_6_original_price, size_7_original_price, size_8_original_price, 
                                size_9_original_price, size_10_original_price,
                                size_1_price, size_2_price, size_3_price, size_4_price, size_5_price, size_6_price,
                                size_7_price, size_8_price, size_9_price, size_10_price,
                                quantity, side, back, up, bottom) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $product_id,
            $product_seller_name,
            $product_name,
            $product_color,
            $category,
            $sizes[1],
            $sizes[2],
            $sizes[3],
            $sizes[4],
            $sizes[5],
            $sizes[6],
            $sizes[7],
            $sizes[8],
            $sizes[9],
            $sizes[10],
            $size_1_original_price,
            $size_2_original_price,
            $size_3_original_price,
            $size_4_original_price,
            $size_5_original_price,
            $size_6_original_price,
            $size_7_original_price,
            $size_8_original_price,
            $size_9_original_price,
            $size_10_original_price,
            $size_1_price,
            $size_2_price,
            $size_3_price,
            $size_4_price,
            $size_5_price,
            $size_6_price,
            $size_7_price,
            $size_8_price,
            $size_9_price,
            $size_10_price,
            $quantity,
            $uploaded_images['side'] ?? null,
            $uploaded_images['back'] ?? null,
            $uploaded_images['up'] ?? null,
            $uploaded_images['bottom'] ?? null
        ]);

        // Commit the transaction
        $pdo->commit();

        // Display success message and redirect
        echo "<script>
                alert('Product added successfully to both tables!');
                window.location.href = 'add_product.php';
              </script>";
        exit();
    } catch (PDOException $e) {
        // Rollback on error
        $pdo->rollBack();
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Database connection failed. Please check your connection settings.");
}
?>
