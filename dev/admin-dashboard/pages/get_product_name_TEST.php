<?php
if (isset($_POST['product_name'])) {
    echo "Received: " . htmlspecialchars($_POST['product_name']);
} else {
    echo "No product_name received.";
}
?>
