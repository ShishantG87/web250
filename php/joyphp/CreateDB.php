<?php
/**
 * Joy of PHP sample code
 * Demonstrates how to create a database, create a table, and insert records.
 */

// Connect to the MySQL server
$mysqli = new mysqli('localhost', 'root', '');

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
$query = "CREATE TABLE IF NOT EXISTS inventory (
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
    echo "Table 'inventory' created successfully.<br>";
} else {
    echo "Error creating table 'inventory': " . $mysqli->error . "<br>";
}

// Insert records into the table
$insertQuery = "INSERT IGNORE INTO inventory 
    (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, SALE_PRICE, PURCHASE_PRICE, MILEAGE, TRANSMISSION, PURCHASE_DATE, SALE_DATE) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($insertQuery);
if (!$stmt) {
    die("Error preparing statement: " . $mysqli->error);
}

// Add records (Honda Pilot and Dodge Durango)
$records = [
    ['5FNYF4H91CB054036', 2012, 'Honda', 'Pilot', 'Touring', 'White Diamond Pearl', 'Leather', 37807, NULL, 34250, 7076, 'Automatic', '2012-11-08', NULL],
    ['LAKSDFJ234LASKRF2', 2009, 'Dodge', 'Durango', 'SLT', 'Silver', 'Black', 2700, NULL, 2000, 144000, '4WD Automatic', '2012-12-05', NULL],
];

// Bind parameters and execute
foreach ($records as $record) {
    $stmt->bind_param(
        "sisssssddidsss",
        $record[0], $record[1], $record[2], $record[3], $record[4], $record[5],
        $record[6], $record[7], $record[8], $record[9], $record[10], $record[11],
        $record[12], $record[13]
    );
    if ($stmt->execute()) {
        echo "<p>Record for VIN {$record[0]} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting record for VIN {$record[0]}: " . $stmt->error . "</p>";
    }
}

// Insert bulk records (27 cars)
$bulkQuery = "INSERT IGNORE INTO inventory 
    (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, SALE_PRICE, PURCHASE_PRICE, MILEAGE, TRANSMISSION, PURCHASE_DATE, SALE_DATE)
    VALUES 
    ('1FAFP44423F44657', 2003, 'Ford', 'Mustang', 'Base', 'Silver / Black', 'Gray', 8995, NULL, 6746, 75820, 'Automatic', '2013-01-14', NULL),
    ('2G1WD58C47917903', 2007, 'Chevrolet', 'Impala', 'SS', 'Gray', 'Gray', 9995.00, NULL, 7496, 129108, '4-Speed Automatic', '2013-01-14', NULL),
    ('19UUA56682A036203', 2002, 'Acura', 'TL', 'Base', 'Blue', 'Tan', 7995.00, NULL, 5996, 77442, '5-Speed Automatic', '2013-01-14', NULL),
  
    ('YV4SZ592561219696', 2006, 'Volvo', 'XC70', 'AWD', 'Willow Green Metallic', 'Taupe Leather', 14996, NULL, 11247, 83664, '5-Speed Automatic w/ Geartronic', '2013-01-14', NULL)";
if ($mysqli->query($bulkQuery) === TRUE) {
    echo "<p>27 cars inserted into inventory table.</p>";
} else {
    echo "<p>Error inserting bulk records: </p>" . $mysqli->error . "<br>";
}

// Close the connection
$stmt->close();
$mysqli->close();

// Include the footer
include 'footer.php';
?>