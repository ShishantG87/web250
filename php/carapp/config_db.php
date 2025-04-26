
<?php
 if ($_SERVER['HTTP_HOST'] === 'localhost') { 
 

    $hostName = 'localhost';
    $userName = 'root';
    $password = '';
    $mysqli = new mysqli($hostName, $userName, $password);

    if ($mysqli->connect_error) {
       die('NOT CONNECTED');
    } 

    if ($mysqli->query("CREATE DATABASE IF NOT EXISTS carapp") === TRUE) {
        echo "<p>Database 'Cars' created successfully.</p>";
    } else {
        echo "Error creating database 'Cars': " . $mysqli->error . "<br>";
    }
    $mysqli->select_db('carapp');
 }
 else {
 $hostName = '';
 $userName = '';
 $password = '';
 $databaseName = '';

 $mysqli = new mysqli($hostName, $userName , $password, $databaseName);

 if ($mysqli->connect_error) {
    die('NOT CONNECTED');
    } 
 }



 if (!$mysqli->select_db('carapp')) {
    die('Failed to connect to carapp');
 } 
 echo 'NICE CONNECTED<br>';
 
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

 ?>