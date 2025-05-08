<?php
include_once('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vin'])) {
    $vin = $_GET['vin'];

    // Use prepared statements to prevent SQL injection
    $stmt = $mysqli->prepare("DELETE FROM INVENTORY WHERE VIN = ?");
    $stmt->bind_param("s", $vin);

    if ($stmt->execute()) {
        echo "Deleted VIN $vin.";
    } else {
        echo "Error: " . $mysqli->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
$mysqli->close();
?>