<?php
include_once('../db.php');


if (isset($_POST['VIN']) && !empty($_POST['VIN'])) {
    $VIN = $_POST['VIN'];
    $Make = isset($_POST['Make']) ? $_POST['Make'] : '';
    $Model = isset($_POST['Model']) ? $_POST['Model'] : '';
    $Price = isset($_POST['Price']) && $_POST['Price'] !== '' ? $_POST['Price'] : null;

 
    $query = "INSERT IGNORE INTO INVENTORY (VIN, Make, Model, Price) 
              VALUES ('$VIN', '$Make', '$Model', $Price)";

 
    if ($mysqli->query($query)) {
       
        if ($mysqli->affected_rows > 0) {
            echo "<p class='message'>Car added successfully!</p>";
        } else {
            echo "<p class='message'>This VIN already exists.</p>";
        }
    } else {
        echo "<p class='message'>Error: " . $mysqli->error . "</p>";
    }
} 
?>
