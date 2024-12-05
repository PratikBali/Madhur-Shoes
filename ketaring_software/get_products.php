<?php
session_start();
require 'conf/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['side'])) {
    $side = $_POST['side'];

    $sql = "SELECT * FROM main_shoes WHERE side = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $side, PDO::PARAM_STR);  // Bind the parameter correctly
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
}
?>
