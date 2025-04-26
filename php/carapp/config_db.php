<?php
// Database connection settings
if ($_SERVER["HTTP_HOST"] === "localhost") {
    // Localhost database credentials
    $hostName = "localhost";
    $userName = "root";
    $password = "";

    // Create connection
    $mysqli = new mysqli($hostName, $userName, $password);

    // Check connection
    if ($mysqli->connect_error) {
        echo "<p class='message'>NOT CONNECTED</p>";
        die();
    }

    // Create database if not exists
    if ($mysqli->query("CREATE DATABASE IF NOT EXISTS carapp") === true) {
        echo "<p class='message'>Database 'Cars' created successfully.</p>";
    } else {
        echo "<p class='message'>Error creating database 'Cars': " . $mysqli->error . "</p>";
    }

    // Select the carapp database
    $mysqli->select_db("carapp");
} else {
    // Production server database credentials
    $hostName = "sql301.infinityfree.com";
    $userName = "if0_38344523";
    $password = "JtYVhknon3DP88";
    $databaseName = "if0_38344523_carapp";

    // Create connection
    $mysqli = new mysqli($hostName, $userName, $password, $databaseName);

    // Check connection
    if ($mysqli->connect_error) {
        echo "<p class='message'>NOT CONNECTED</p>";
        die();
    }
}

// Verify connection to the carapp database
if (!$mysqli->select_db("carapp")) {
    echo "<p class='message'>Failed to connect to carapp</p>";
    die();
}
echo "<p class='message'>NICE CONNECTED</p><br>";

// **************************************************************************************************
// Create 'inventory' table
$query = "
    CREATE TABLE IF NOT EXISTS inventory (
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
    )
";

if ($mysqli->query($query) === true) {
    echo "<p class='message'>Table 'inventory' created successfully.</p><br>";
} else {
    echo "<p class='message'>Error creating table 'inventory': " . $mysqli->error . "</p><br>";
}

// **************************************************************************************************
// Create 'IMAGES' table
$query = "
    CREATE TABLE IF NOT EXISTS IMAGES (
        ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
        VIN VARCHAR(17), 
        ImageFile VARCHAR(250)
    )
";

if ($mysqli->query($query) === true) {
    echo "<p class='message'>Database table 'Images' created successfully.</p><br>";
} else {
    echo "<p class='message'>Error creating table 'IMAGES': " . $mysqli->error . "</p><br>";
}
// **************************************************************************************************


$insertQuery = "INSERT IGNORE INTO inventory 
    (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, SALE_PRICE, PURCHASE_PRICE, MILEAGE, TRANSMISSION, PURCHASE_DATE, SALE_DATE) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($insertQuery);
if (!$stmt) {
    die("Error preparing statement: " . $mysqli->error);
}


$records = [
    ['5FNYF4H91CB054036', 2012, 'Honda', 'Pilot', 'Touring', 'White Diamond Pearl', 'Leather', 37807, NULL, 34250, 7076, 'Automatic', '2012-11-08', NULL],
    ['LAKSDFJ234LASKRF2', 2009, 'Dodge', 'Durango', 'SLT', 'Silver', 'Black', 2700, NULL, 2000, 144000, '4WD Automatic', '2012-12-05', NULL],
    ['1FAFP44423F44657', 2003, 'Ford', 'Mustang', 'Base', 'Silver / Black', 'Gray', 8995, NULL, 6746, 75820, 'Automatic', '2013-01-14', NULL],
    ['2G1WD58C47917903', 2007, 'Chevrolet', 'Impala', 'SS', 'Gray', 'Gray', 9995.00, NULL, 7496, 129108, '4-Speed Automatic', '2013-01-14', NULL],
    ['19UUA56682A036203', 2002, 'Acura', 'TL', 'Base', 'Blue', 'Tan', 7995.00, NULL, 5996, 77442, '5-Speed Automatic', '2013-01-14', NULL],
    ['YV4SZ592561219696', 2006, 'Volvo', 'XC70', 'AWD', 'Willow Green Metallic', 'Taupe Leather', 14996, NULL, 11247, 83664, '5-Speed Automatic w/ Geartronic', '2013-01-14', NULL],
];

foreach ($records as $record) {
    $stmt->bind_param(
        "sisssssddidsss",
        $record[0], $record[1], $record[2], $record[3], $record[4], $record[5],
        $record[6], $record[7], $record[8], $record[9], $record[10], $record[11],
        $record[12], $record[13]
    );
    if ($stmt->execute()) {
        echo "<p class='message'>Record for VIN {$record[0]} inserted successfully.</p>";
    } else {
        echo "<p class='message'>Error inserting record for VIN {$record[0]}: " . $stmt->error . "</p>";
    }
}

// Close the prepared statement
$stmt->close();



?>

<style>
    .message {
        opacity: 1;
        visibility: visible;
        transition: opacity 3s ease-in-out;
    }

   
    .fade-out {
        opacity: 0;
        display: none;
    }
</style>


<script>
    setTimeout(() => {
        const messages = document.querySelectorAll('.message');
        messages.forEach((message) => {
            message.classList.add('fade-out');
        });
    }, 3000);
</script>

