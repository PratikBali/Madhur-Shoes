<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catering";


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to the database.";
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
