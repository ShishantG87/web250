<?php
include_once('../db.php');


if (isset($_POST['VIN']) && !empty($_POST['VIN'])) {
    $VIN = $_POST['VIN'];
    $Make = isset($_POST['Make']) ? $_POST['Make'] : '';
    $Model = isset($_POST['Model']) ? $_POST['Model'] : '';
    $Price = isset($_POST['Price']) && $_POST['Price'] !== '' ? $_POST['Price'] : null;

 
    $query = "INSERT IGNORE INTO INVENTORY (VIN, Make, Model, ASKING_PRICE) 
              VALUES ('$VIN', '$Make', '$Model', $Price)";

 
    if ($mysqli->query($query)) {
       
        if ($mysqli->affected_rows > 0) {
            echo "Car added successfully!, It will only appear when you refresh though!";
        } else {
            echo "This VIN already exists";
        }
    } else {
        echo "Error: " . $mysqli->error . "";
    }
} 
$mysqli->close();
?>
