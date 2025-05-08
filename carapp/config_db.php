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
    ['1HGCD563XWA017503', 1998, 'Honda', 'Accord', 'EX', 'Green', 'Gray', 5000, NULL, 4000, 158000, 'Automatic', '2013-05-10', NULL],
    ['3VWFE21C7XM088616', 1999, 'Volkswagen', 'Jetta', 'GLS', 'Silver', 'Gray', 5500, NULL, 4300, 122000, '5-Speed Manual', '2013-06-14', NULL],
    ['1FMYU02168KA39607', 1998, 'Ford', 'Escape', 'XLS', 'Red', 'Gray', 4500, NULL, 3600, 180000, 'Automatic', '2013-07-20', NULL],
    ['4T1BF3EK1CU123456', 2002, 'Toyota', 'Camry', 'LE', 'Black', 'Tan', 6500, NULL, 5000, 110000, 'Automatic', '2014-01-22', NULL],
    ['1G1JC5248Y7300653', 2000, 'Chevrolet', 'Cavalier', 'LS', 'White', 'Gray', 3900, NULL, 2900, 130000, 'Automatic', '2014-03-10', NULL],
    ['1J4FY19S5YP540689', 2000, 'Jeep', 'Cherokee', 'Sport', 'Yellow', 'Gray', 5500, NULL, 4500, 156000, 'Automatic', '2014-04-18', NULL],
    ['WBAAZ9347XJC65556', 1996, 'BMW', '3 Series', '318i', 'Blue', 'Tan', 5995, NULL, 4900, 210000, 'Automatic', '2014-05-05', NULL],
    ['2B3LA43R56H105875', 2006, 'Chrysler', '300C', 'Limited', 'Silver', 'Black', 12000, NULL, 9500, 90000, 'Automatic', '2014-06-19', NULL],
    ['1FAFP4040XK123456', 1997, 'Ford', 'Taurus', 'GL', 'Red', 'Tan', 3800, NULL, 2900, 145000, 'Automatic', '2014-07-21', NULL],
    ['1G2NF52F22M344566', 2002, 'Pontiac', 'Grand Am', 'SE', 'White', 'Black', 4200, NULL, 3200, 170000, 'Automatic', '2014-08-02', NULL],
    ['4S3BE645X37234856', 2004, 'Subaru', 'Impreza', 'WRX', 'Blue', 'Gray', 9800, NULL, 7400, 130000, 'Manual', '2014-09-09', NULL],
    ['2A4GP44R58R581838', 2008, 'Chrysler', 'Town & Country', 'Touring', 'Silver', 'Tan', 10450, NULL, 8350, 120000, 'Automatic', '2014-10-13', NULL],
    ['1FMYU04168KC12345', 2008, 'Ford', 'Escape', 'Hybrid', 'Green', 'Gray', 11500, NULL, 9100, 160000, 'Automatic', '2014-11-17', NULL],
    ['1D4HB48N88F123456', 2008, 'Dodge', 'Durango', 'SXT', 'Blue', 'Gray', 11900, NULL, 9500, 135000, 'Automatic', '2014-12-02', NULL],
    ['WAUZC98EX8A123456', 2008, 'Audi', 'A4', 'Premium', 'Silver', 'Black', 16500, NULL, 13000, 89000, 'Manual', '2015-01-22', NULL],
    ['4M2CU57146KJ12345', 2006, 'Mercury', 'Mountaineer', 'Premier', 'White', 'Beige', 8500, NULL, 6700, 125000, 'Automatic', '2015-02-11', NULL],
    ['1G1ZY5E09CF123456', 2012, 'Chevrolet', 'Malibu', 'LT', 'Silver', 'Gray', 15500, NULL, 12000, 85000, 'Automatic', '2015-03-15', NULL],
    ['3GNDA23D46S123456', 2006, 'Chevrolet', 'HHR', 'LT', 'Red', 'Black', 8500, NULL, 6700, 130000, 'Automatic', '2015-04-03', NULL],
    ['2B3CJ56K77H123456', 2007, 'Chrysler', '300', 'C', 'Black', 'Gray', 12500, NULL, 9500, 95000, 'Automatic', '2015-05-06', NULL],
    ['1FAFP404XFK123456', 1997, 'Ford', 'Taurus', 'GL', 'Green', 'Tan', 3700, NULL, 2800, 175000, 'Automatic', '2015-06-07', NULL]
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

