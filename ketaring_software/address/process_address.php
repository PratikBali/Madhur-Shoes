<?php
session_start();

// Store the address details in the session
$_SESSION['address'] = $_POST['address'];
$_SESSION['city'] = $_POST['city'];
$_SESSION['country'] = $_POST['country'];
$_SESSION['zip'] = $_POST['zip'];
$_SESSION['product_color'] = $_POST['product_color'];
$_SESSION['product_name'] = $_POST['product_name']; 
$_SESSION['size'] = $_POST['size']; 
$_SESSION['category'] = $_POST['category']; 

// Redirect to the next page
header("Location: ../payment2.php");
exit();
?>
