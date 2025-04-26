<?php
/**
 * Joy of PHP sample code
 * Demonstrates how to create a database, create a table, and insert records.
 */

// Connect to the MySQL server
$mysqli = new mysqli('localhost', 'root', '', '');

// Check connection
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
echo 'Connected successfully to MySQL.<br>';

// Create the database
if ($mysqli->query("CREATE DATABASE IF NOT EXISTS Cars") === TRUE) {
    echo "<p>Database 'Cars' created successfully.</p>";
} else {
    echo "Error creating database 'Cars': " . $mysqli->error . "<br>";
}

// Select the database
if ($mysqli->select_db("Cars")) {
    echo "Selected the 'Cars' database.<br>";
} else {
    die("Error selecting database: " . $mysqli->error);
}

// Create the 'INVENTORY' table
$query = "CREATE TABLE INVENTORY (
    VIN VARCHAR(17) PRIMARY KEY, 
    YEAR INT, 
    Make VARCHAR(50), 
    Model VARCHAR(100), 
    TRIM VARCHAR(50), 
    EXT_COLOR VARCHAR(50), 
    INT_COLOR VARCHAR(50), 
    ASKING_PRICE DECIMAL(10,2), 
    SALE_PRICE DECIMAL(10,2), 
    PURCHASE_PRICE DECIMAL(10,2), 
    MILEAGE INT, 
    TRANSMISSION VARCHAR(50), 
    PURCHASE_DATE DATE, 
    SALE_DATE DATE
)";
if ($mysqli->query($query) === TRUE) {
    echo "Table 'INVENTORY' created successfully.<br>";
} else {
    echo "Error creating table 'INVENTORY': " . $mysqli->error . "<br>";
}

// Insert the first record (Honda Pilot) using a prepared statement
$stmt = $mysqli->prepare("INSERT INTO INVENTORY 
    (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, SALE_PRICE, PURCHASE_PRICE, MILEAGE, TRANSMISSION, PURCHASE_DATE, SALE_DATE) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param(
        "sisssssddidsss", 
        $vin, $year, $make, $model, $trim, $ext_color, $int_color, 
        $asking_price, $sale_price, $purchase_price, $mileage, $transmission, 
        $purchase_date, $sale_date
    );

    // Honda Pilot data
    $vin = '5FNYF4H91CB054036';
    $year = 2012;
    $make = 'Honda';
    $model = 'Pilot';
    $trim = 'Touring';
    $ext_color = 'White Diamond Pearl';
    $int_color = 'Leather';
    $asking_price = 37807;
    $sale_price = NULL;
    $purchase_price = 34250;
    $mileage = 7076;
    $transmission = 'Automatic';
    $purchase_date = '2012-11-08';
    $sale_date = NULL;

    if ($stmt->execute()) {
        echo "<p>Honda Pilot inserted into 'INVENTORY' table.</p>";
    } else {
        echo "<p>Error inserting Honda Pilot: " . $stmt->error . "</p>";
    }
} else {
    echo "Error preparing statement: " . $mysqli->error;
}

// Insert the second record (Dodge Durango) using the same prepared statement
if ($stmt) {
    // Dodge Durango data
    $vin = 'LAKSDFJ234LASKRF2';
    $year = 2009;
    $make = 'Dodge';
    $model = 'Durango';
    $trim = 'SLT';
    $ext_color = 'Silver';
    $int_color = 'Black';
    $asking_price = 2700;
    $sale_price = NULL;
    $purchase_price = 2000;
    $mileage = 144000;
    $transmission = '4WD Automatic';
    $purchase_date = '2012-12-05';
    $sale_date = NULL;

    if ($stmt->execute()) {
        echo "<p>Dodge Durango inserted into 'INVENTORY' table.</p>";
    } else {
        echo "<p>Error inserting Dodge Durango: " . $stmt->error . "</p>";
    }
}

// Close the statement and connection
$stmt->close();
$mysqli->close();

// Include the footer
include 'footer.php';
?>