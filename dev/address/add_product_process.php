<?php
session_start();
require 'db.php';
require '../conf/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
 
error_reporting(E_ALL);
ini_set('display_errors', 1); 

// Function to generate a unique numerical barcode
function generateUniqueBarcode($conn) {
    do {
        // Generate a random 13-digit numerical barcode
        $bar_code_no = str_pad(rand(0, 9999999999999), 13, '0', STR_PAD_LEFT); // Ensures it's 13 digits

        // Check if the barcode exists in the database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM main_shoes WHERE bar_code_no = ?");
        $stmt->execute([$bar_code_no]);
        $count = $stmt->fetchColumn();

    } while ($count > 0); // Repeat if barcode already exists

    return $bar_code_no;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the barcode from the form
    $bar_code_no = $_POST['bar_code_no'] ?? '';

    // If no barcode is entered, generate one dynamically
    if (empty($bar_code_no)) {
        $bar_code_no = generateUniqueBarcode($conn);
    } else {
        // Check if manually entered barcode already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM main_shoes_original WHERE bar_code_no = ?");
        $stmt->execute([$bar_code_no]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            die("Error: The entered barcode already exists in the database.");
        }
    }

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
$product_seller_email_id = $_POST['product_seller_email_id'] ?? '';
$brand_name = $_POST['brand_name'] ?? '';
$product_color = $_POST['product_color'] ?? '';
$category = $_POST['category'] ?? '';

$male_category = !empty($_POST['male_category']) ? $_POST['male_category'] : null;
$female_category = !empty($_POST['female_category']) ? $_POST['female_category'] : null;
$child_male_category = !empty($_POST['child_male_category']) ? $_POST['child_male_category'] : null;
$child_female_category = !empty($_POST['child_female_category']) ? $_POST['child_female_category'] : null;
$other_category = !empty($_POST['other_category']) ? $_POST['other_category'] : null;

$artical_no = $_POST['artical_no'] ?? '';

$product_size = $_POST['product_size'] ?? 0;
$quantity = $_POST['quantity'] ?? 0;
$original_price = $_POST['original_price'] ?? 0;
$sell_price = $_POST['sell_price'] ?? 0;

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

        // Insert into main_shoes_original _original product_seller_email_id
        $stmt = $pdo->prepare("INSERT INTO main_shoes_original (bar_code_no, brand_name, product_id, product_seller_email_id, 
                                category, male_category, female_category, child_male_category, child_female_category, 
                                other_category, artical_no, product_color, product_size, quantity, original_price,
                                sell_price, side) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $bar_code_no,
            $brand_name,
            $product_id,
            $product_seller_email_id,
            $category,
            $male_category,
            $female_category,
            $child_male_category,
            $child_female_category,
            $other_category,
            $artical_no,
            $product_color,
            $product_size,
            $quantity,
            $original_price,
            $sell_price,
            $uploaded_images['side'] ?? null
        ]);

        // Insert into main_shoes
        $stmt = $pdo->prepare("INSERT INTO main_shoes (bar_code_no, brand_name, product_id, product_seller_email_id, 
                                category, male_category, female_category, child_male_category, child_female_category, 
                                other_category, artical_no, product_color, product_size, quantity, original_price,
                                sell_price, side) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $bar_code_no,
            $brand_name,
            $product_id,
            $product_seller_email_id,
            $category,
            $male_category,
            $female_category,
            $child_male_category,
            $child_female_category,
            $other_category,
            $artical_no,
            $product_color,
            $product_size,
            $quantity,
            $original_price,
            $sell_price,
            $uploaded_images['side'] ?? null
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
