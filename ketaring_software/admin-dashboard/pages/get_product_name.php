<?php 
require '../../conf/db.php';
require '../../conf/db2.php';

if (isset($_POST['product_name'])) {
    $productName = $_POST['product_name'];
    $sql = "SELECT * FROM main_shoes WHERE product_name = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<option value=''>Select Product Color</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['product_color'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['product_color'], ENT_QUOTES, 'UTF-8') . "</option>";
        }
    } else {
        echo "<option value=''>No Colors Found</option>";
    }
}
?>
