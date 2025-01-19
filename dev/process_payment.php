<?php
session_start();
require 'conf/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Here, you would integrate with a payment gateway API to process the payment

    // Assuming payment is successful
    $sql = "UPDATE main_shoes SET stock = stock - 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_id]);

    echo "Payment successful! Thank you for your purchase.";
} else {
    echo "Invalid request.";
}
?>
