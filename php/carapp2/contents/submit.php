<?php
include_once('../db.php');


if (isset($_POST['VIN']) && !empty($_POST['VIN'])) {

    
    $VIN = $_POST['VIN'];
    $YEAR = isset($_POST['YEAR']) ? $_POST['YEAR'] : null;
    $Make = isset($_POST['Make']) ? $_POST['Make'] : '';
    $Model = isset($_POST['Model']) ? $_POST['Model'] : '';
    $TRIM = isset($_POST['TRIM']) ? $_POST['TRIM'] : '';
    $EXT_COLOR = isset($_POST['EXT_COLOR']) ? $_POST['EXT_COLOR'] : '';
    $INT_COLOR = isset($_POST['INT_COLOR']) ? $_POST['INT_COLOR'] : '';
    $ASKING_PRICE = isset($_POST['ASKING_PRICE']) && $_POST['ASKING_PRICE'] !== '' ? $_POST['ASKING_PRICE'] : null;
    $SALE_PRICE = isset($_POST['SALE_PRICE']) && $_POST['SALE_PRICE'] !== '' ? $_POST['SALE_PRICE'] : null;
    $PURCHASE_PRICE = isset($_POST['PURCHASE_PRICE']) && $_POST['PURCHASE_PRICE'] !== '' ? $_POST['PURCHASE_PRICE'] : null;
    $MILEAGE = isset($_POST['MILEAGE']) && $_POST['MILEAGE'] !== '' ? $_POST['MILEAGE'] : null;
    $TRANSMISSION = isset($_POST['TRANSMISSION']) ? $_POST['TRANSMISSION'] : '';
    $PURCHASE_DATE = isset($_POST['PURCHASE_DATE']) && $_POST['PURCHASE_DATE'] !== '' ? $_POST['PURCHASE_DATE'] : null;
    $SALE_DATE = isset($_POST['SALE_DATE']) && $_POST['SALE_DATE'] !== '' ? $_POST['SALE_DATE'] : null;

  
    $query = "INSERT IGNORE INTO INVENTORY (
                VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, 
                SALE_PRICE, PURCHASE_PRICE, MILEAGE, TRANSMISSION, PURCHASE_DATE, SALE_DATE
              ) 
              VALUES (
                '$VIN', $YEAR, '$Make', '$Model', '$TRIM', '$EXT_COLOR', '$INT_COLOR', 
                $ASKING_PRICE, $SALE_PRICE, $PURCHASE_PRICE, $MILEAGE, '$TRANSMISSION', 
                " . ($PURCHASE_DATE ? "'$PURCHASE_DATE'" : "NULL") . ", 
                " . ($SALE_DATE ? "'$SALE_DATE'" : "NULL") . "
              )";

   
    if ($mysqli->query($query)) {
        if ($mysqli->affected_rows > 0) {
            echo "Car added successfully! It will only appear when you refresh though!";
        } else {
            echo "This VIN already exists";
        }
    } else {
        echo "Error: " . $mysqli->error . "";
    }
} else {
    echo "VIN is required!";
}

// Close the database connection
$mysqli->close();
?>