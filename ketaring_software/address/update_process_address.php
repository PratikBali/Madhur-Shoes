<?php
session_start();
require '../conf/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_color = $_POST['product_color'];
    $size_6 = $_POST['size_6'];
    $size_7 = $_POST['size_7'];
    $size_8 = $_POST['size_8'];
    $size_9 = $_POST['size_9'];
    $size_10 = $_POST['size_10'];
    $quantity = $_POST['quantity'];

    // Handling image uploads
    $side = $_FILES['side']['name'];
    $up = $_FILES['up']['name'];
    $bottom = $_FILES['bottom']['name']; 
    $back = $_FILES['back']['name'];

    $target_dir = "../uploads/";
    $side_target_file = $target_dir . basename($side);
    $up_target_file = $target_dir . basename($up);
    $bottom_target_file = $target_dir . basename($bottom);
    $back_target_file = $target_dir . basename($back);

    // Move uploaded files
    move_uploaded_file($_FILES['side']['tmp_name'], $side_target_file);
    move_uploaded_file($_FILES['up']['tmp_name'], $up_target_file);
    move_uploaded_file($_FILES['bottom']['tmp_name'], $bottom_target_file);
    move_uploaded_file($_FILES['back']['tmp_name'], $back_target_file);

    // Prepare the SQL query to update data
    $sql = "UPDATE main_shoes SET product_name = :product_name, product_price = :product_price,
                                  product_color = :product_color, size_6 = :size_6, size_7 = :size_7, 
                                  size_8 = :size_8, size_9 = :size_9, size_10 = :size_10, quantity = :quantity, 
                                  side = :side, up = :up, bottom = :bottom, back = :back WHERE id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':product_price', $product_price);
    $stmt->bindParam(':product_color', $product_color);
    $stmt->bindParam(':size_6', $size_6);
    $stmt->bindParam(':size_7', $size_7);
    $stmt->bindParam(':size_8', $size_8);
    $stmt->bindParam(':size_9', $size_9);
    $stmt->bindParam(':size_10', $size_10);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':side', $side);
    $stmt->bindParam(':up', $up);
    $stmt->bindParam(':bottom', $bottom);
    $stmt->bindParam(':back', $back);
    $stmt->bindParam(':id', $id);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href='admin-dashboard/pages/update_product_all.php';</script>";
    } else {
        echo "<script>alert('Failed to update product.');</script>";
    }
}
?>
