<?php
include_once '../db.php'; 

$vin = $_POST['vin'] ?? '';
$make = $_POST['make'] ?? '';
$model = $_POST['model'] ?? '';
$price = $_POST['price'] ?? '';

if ($vin && $make && $model && is_numeric($price)) {
    $stmt = $mysqli->prepare("UPDATE INVENTORY SET Make = ?, Model = ?, ASKING_PRICE = ? WHERE VIN = ?");
    $stmt->bind_param("ssds", $make, $model, $price, $vin);

    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Update failed: " . $mysqli->error;
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo "Invalid input.";
}
$mysqli->close();
?>
