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
      
        die();
    }
}

// Verify connection to the carapp database
if (!$mysqli->select_db("carapp")) {
    echo "<p class='message'>Failed to connect to carapp</p>";
    die();
}


// **************************************************************************************************
// Create 'inventory' table
$query = "
    CREATE TABLE IF NOT EXISTS INVENTORY (
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
 
} else {
    echo "<p class='message'>Error creating table 'IMAGES': " . $mysqli->error . "</p><br>";
}
// **************************************************************************************************


$insertQuery = "INSERT IGNORE INTO INVENTORY 
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
    ['1FAFP404XFK123456', 1997, 'Ford', 'Taurus', 'GL', 'Green', 'Tan', 3700, NULL, 2800, 175000, 'Automatic', '2015-06-07', NULL],
    ['1HGCM82633A004352', 2010, 'Toyota', 'Corolla', 'LE', 'Black', 'Gray', 7800, NULL, 6100, 122500, 'Automatic', '2015-07-15', NULL],
    ['2T1BURHE0GC504321', 2016, 'Toyota', 'Corolla', 'S', 'Silver', 'Black', 12500, NULL, 9700, 80000, 'CVT', '2016-03-12', NULL],
    ['1N4AL3AP5FC456789', 2015, 'Nissan', 'Altima', 'SV', 'White', 'Tan', 11000, NULL, 8500, 90500, 'Automatic', '2016-08-22', NULL],
    ['1FA6P8TH2G5321987', 2016, 'Ford', 'Mustang', 'EcoBoost', 'Red', 'Black', 18950, NULL, 15000, 45000, 'Manual', '2017-01-03', NULL],
    ['WAUDF78E88A123987', 2008, 'Audi', 'A4', '2.0T', 'Gray', 'Beige', 8900, NULL, 6700, 115000, 'Automatic', '2017-06-09', NULL],
    ['KMHD74LF6JU123456', 2018, 'Hyundai', 'Elantra', 'SE', 'Blue', 'Gray', 13400, NULL, 10500, 70000, '6-Speed Auto', '2018-03-21', NULL],
    ['WBA4J1C59JBL12345', 2018, 'BMW', '430i', 'Gran Coupe', 'White', 'Black', 28900, NULL, 22500, 40000, 'Automatic', '2018-07-19', NULL],
    ['1GCVKREC5EZ123456', 2014, 'Chevrolet', 'Silverado', 'LT', 'Red', 'Gray', 21700, NULL, 17200, 65000, 'Automatic', '2019-01-08', NULL],
    ['2HGFB2F59CH123456', 2012, 'Honda', 'Civic', 'EX', 'Silver', 'Black', 9200, NULL, 7000, 105000, 'Automatic', '2019-06-05', NULL],
    ['3FA6P0H75ER123456', 2014, 'Ford', 'Fusion', 'SE', 'Gray', 'Black', 10900, NULL, 8400, 95000, 'Automatic', '2019-08-11', NULL],
    ['JN8AS5MT9CW123456', 2012, 'Nissan', 'Rogue', 'SV', 'White', 'Beige', 9800, NULL, 7500, 112000, 'CVT', '2020-02-17', NULL],
    ['5XYZTDLB6DG123456', 2013, 'Hyundai', 'Santa Fe', 'Sport', 'Black', 'Gray', 10800, NULL, 8300, 88000, 'Automatic', '2020-05-21', NULL],
    ['1FTFW1EG2JFA12345', 2018, 'Ford', 'F-150', 'Lariat', 'Blue', 'Black', 33800, NULL, 27800, 39000, 'Automatic', '2020-08-03', NULL],
    ['3GNAXSEV6LS123456', 2020, 'Chevrolet', 'Equinox', 'LT', 'Silver', 'Black', 24500, NULL, 19800, 30000, 'Automatic', '2021-01-18', NULL],
    ['KNAGM4AD5F5123456', 2015, 'Kia', 'Optima', 'LX', 'Gray', 'Black', 10200, NULL, 7900, 91000, 'Automatic', '2021-04-10', NULL],
    ['1G1ZD5ST5KF123456', 2019, 'Chevrolet', 'Malibu', 'LT', 'White', 'Beige', 17800, NULL, 14100, 47000, 'Automatic', '2021-07-29', NULL],
    ['5NPD84LF8KH123456', 2019, 'Hyundai', 'Elantra', 'SEL', 'Blue', 'Gray', 15300, NULL, 12000, 56000, 'CVT', '2021-11-15', NULL],
    ['1FA6P8CF1J1234567', 2018, 'Ford', 'Mustang', 'GT', 'Orange', 'Black', 30500, NULL, 25000, 32000, 'Manual', '2022-01-23', NULL],
    ['3VW2B7AJ5HM123456', 2017, 'Volkswagen', 'Jetta', 'S', 'Black', 'Gray', 11400, NULL, 8700, 78000, 'Automatic', '2022-05-03', NULL],
    ['WDDZF4KB5JA123456', 2018, 'Mercedes-Benz', 'E-Class', 'E300', 'Silver', 'Black', 34900, NULL, 28500, 42000, 'Automatic', '2022-09-14', NULL],
    ['JN8AT2MV0KW123456', 2019, 'Nissan', 'Rogue', 'SL', 'White', 'Beige', 22400, NULL, 17900, 48000, 'CVT', '2022-11-22', NULL],
    ['KNDPMCAC3J7401234', 2018, 'Kia', 'Sportage', 'EX', 'Gray', 'Black', 16900, NULL, 13300, 59000, 'Automatic', '2023-02-12', NULL],
    ['JM3KFBDY0J0456789', 2018, 'Mazda', 'CX-5', 'Grand Touring', 'Red', 'Black', 20900, NULL, 16500, 53000, 'Automatic', '2023-05-19', NULL],
    ['1C4RJFBG3FC123456', 2015, 'Jeep', 'Grand Cherokee', 'Limited', 'Blue', 'Tan', 19700, NULL, 15400, 77000, 'Automatic', '2023-07-30', NULL],
    ['3KPF24AD0LE123456', 2020, 'Kia', 'Forte', 'LXS', 'Silver', 'Black', 16500, NULL, 13500, 34000, 'CVT', '2023-09-25', NULL],
    ['1HGCR2F3XHA123456', 2017, 'Honda', 'Accord', 'Sport', 'Black', 'Gray', 18500, NULL, 14900, 68000, 'CVT', '2023-11-10', NULL],
    ['1FTEX1EP3JFC12345', 2018, 'Ford', 'F-150', 'XLT', 'White', 'Black', 32700, NULL, 27000, 36000, 'Automatic', '2024-01-07', NULL],
    ['5YJ3E1EA7JF123456', 2018, 'Tesla', 'Model 3', 'Long Range', 'Red', 'Black', 38900, NULL, 32200, 42000, 'Automatic', '2024-03-12', NULL],
    ['SALVP2BG3GH123456', 2016, 'Land Rover', 'Range Rover Evoque', 'SE', 'Silver', 'Beige', 29900, NULL, 23800, 51000, 'Automatic', '2024-05-08', NULL],
    ['WA1BNAFY6J2123456', 2018, 'Audi', 'Q5', 'Premium Plus', 'Blue', 'Black', 35900, NULL, 28900, 47000, 'Automatic', '2024-06-11', NULL],
    ['1GNSCBKC2JR123456', 2018, 'Chevrolet', 'Tahoe', 'LT', 'Black', 'Gray', 40900, NULL, 33000, 52000, 'Automatic', '2024-07-14', NULL],
    ['JTMZFREV5JJ123456', 2018, 'Toyota', 'RAV4', 'LE', 'Gray', 'Black', 21400, NULL, 17000, 61000, 'Automatic', '2024-08-19', NULL],
    ['1C4PJLCB1KD123456', 2019, 'Jeep', 'Cherokee', 'Latitude', 'White', 'Beige', 21500, NULL, 17200, 53000, 'Automatic', '2024-09-25', NULL],
    ['2T3W1RFV5KW123456', 2019, 'Toyota', 'RAV4', 'XLE', 'Silver', 'Gray', 26500, NULL, 21500, 44000, 'Automatic', '2024-10-31', NULL],
    ['WBA8D9G58JNU12345', 2018, 'BMW', '3 Series', '330i xDrive', 'Black', 'Black', 29800, NULL, 24000, 48000, 'Automatic', '2024-11-15', NULL],
    ['3FA6P0K92KR123456', 2019, 'Ford', 'Fusion', 'Titanium', 'Blue', 'Gray', 19800, NULL, 15800, 51000, 'Automatic', '2024-12-05', NULL],
    ['1N6AD0CW5KN123456', 2019, 'Nissan', 'Frontier', 'SV', 'Red', 'Gray', 24500, NULL, 19700, 48000, 'Automatic', '2025-01-20', NULL],
    ['1GNERGKWXKJ123456', 2019, 'Chevrolet', 'Traverse', 'LS', 'White', 'Black', 27300, NULL, 21900, 46000, 'Automatic', '2025-02-14', NULL],
    ['5XXGT4L38KG123456', 2019, 'Kia', 'Optima', 'EX', 'Silver', 'Beige', 18300, NULL, 14700, 49000, 'Automatic', '2025-03-22', NULL],
    ['JM3KFBCM6K1234567', 2019, 'Mazda', 'CX-5', 'Touring', 'Red', 'Black', 22900, NULL, 18500, 44000, 'Automatic', '2025-04-25', NULL],
    ['1C6RR7FT1KS123456', 2019, 'Ram', '1500', 'Tradesman', 'Gray', 'Gray', 28800, NULL, 23000, 47000, 'Automatic', '2025-05-08', NULL],
    ['1HGCV1F32JA123456', 2018, 'Honda', 'Accord', 'Sport', 'Blue', 'Black', 21500, NULL, 17200, 52000, 'CVT', '2025-06-01', NULL],
    ['5TDJZ3DC8JS123456', 2018, 'Toyota', 'Sienna', 'XLE', 'White', 'Gray', 29800, NULL, 24000, 48000, 'Automatic', '2025-07-13', NULL],
    ['WBAJA7C58JG123456', 2018, 'BMW', '5 Series', '540i xDrive', 'Black', 'Beige', 39900, NULL, 31800, 45000, 'Automatic', '2025-08-23', NULL],
    ['JN1BJ1CR9JW123456', 2018, 'Nissan', 'Rogue Sport', 'SV', 'Silver', 'Black', 19500, NULL, 15500, 55000, 'CVT', '2025-09-18', NULL],
    ['1G1ZE5ST5LF123456', 2020, 'Chevrolet', 'Malibu', 'RS', 'Gray', 'Black', 20700, NULL, 16700, 37000, 'Automatic', '2025-10-12', NULL],
    ['2HGFC2F69KH123456', 2019, 'Honda', 'Civic', 'LX', 'White', 'Gray', 18500, NULL, 14500, 46000, 'CVT', '2025-11-02', NULL],
    ['1FMCU9GD1KUB12345', 2019, 'Ford', 'Escape', 'SE', 'Blue', 'Black', 21900, NULL, 17800, 42000, 'Automatic', '2025-11-27', NULL],
    ['3N1AB7AP6KY123456', 2019, 'Nissan', 'Sentra', 'SV', 'Red', 'Gray', 16900, NULL, 13500, 47000, 'CVT', '2025-12-21', NULL],
    ['1C4PJMLB6LD123456', 2020, 'Jeep', 'Cherokee', 'Latitude Plus', 'Black', 'Beige', 23900, NULL, 19500, 40000, 'Automatic', '2026-01-18', NULL],
    ['3FADP4BJ3JM123456', 2018, 'Ford', 'Fiesta', 'SE', 'Red', 'Black', 9500, NULL, 7400, 46000, 'Automatic', '2026-02-14', NULL],
    ['1FA6P8TH2K5146543', 2019, 'Ford', 'Mustang', 'EcoBoost', 'Blue', 'Gray', 23400, NULL, 19000, 39000, 'Manual', '2026-03-01', NULL],
    ['2T3BFREV6GW123456', 2016, 'Toyota', 'RAV4', 'XLE', 'Silver', 'Gray', 17900, NULL, 14400, 66000, 'Automatic', '2026-03-27', NULL],
    ['5XYZT3LB9KG123456', 2019, 'Hyundai', 'Santa Fe', 'SEL', 'White', 'Gray', 25900, NULL, 21200, 53000, 'Automatic', '2026-04-09', NULL],
    ['1FMCU9GD0KUB12345', 2019, 'Ford', 'Escape', 'Titanium', 'Gray', 'Black', 29900, NULL, 24500, 46000, 'Automatic', '2026-04-28', NULL],
    ['4S3BNAF64H3601234', 2017, 'Subaru', 'Outback', '2.5i Premium', 'Blue', 'Gray', 21800, NULL, 17400, 55000, 'CVT', '2026-05-17', NULL],
    ['WA1BNAFY3F2134567', 2015, 'Audi', 'Q7', 'Premium Plus', 'Black', 'Tan', 34900, NULL, 29000, 67000, 'Automatic', '2026-06-02', NULL],
    ['5N1AT2MT4JC123456', 2018, 'Nissan', 'Rogue', 'SV', 'White', 'Beige', 22900, NULL, 18400, 58000, 'Automatic', '2026-06-19', NULL],
    ['1FMCU9GD2LUB12345', 2020, 'Ford', 'Escape', 'SE', 'Silver', 'Black', 22900, NULL, 18400, 45000, 'Automatic', '2026-07-02', NULL],
    ['3LN6L5F94JR123456', 2018, 'Lincoln', 'MKZ', 'Reserve', 'Blue', 'Gray', 27900, NULL, 22900, 52000, 'Automatic', '2026-08-15', NULL],
    ['1C4RJEAG1LC123456', 2020, 'Jeep', 'Cherokee', 'Overland', 'Black', 'Beige', 29900, NULL, 24500, 42000, 'Automatic', '2026-09-23', NULL],
    ['5J6YH3H43KL123456', 2019, 'Honda', 'CR-V', 'EX-L', 'Silver', 'Black', 24900, NULL, 19800, 47000, 'CVT', '2026-10-10', NULL],
    ['1C6RR7TT8LS123456', 2020, 'Ram', '1500', 'Laramie', 'Red', 'Gray', 38900, NULL, 31500, 38000, 'Automatic', '2026-11-18', NULL],
    ['1N4AL3AP7HC123456', 2017, 'Nissan', 'Altima', 'SR', 'White', 'Black', 13900, NULL, 11100, 67000, 'Automatic', '2026-12-02', NULL],
    ['3VW1B7AT5FM123456', 2015, 'Volkswagen', 'Jetta', 'S', 'Gray', 'Black', 8900, NULL, 6800, 92000, 'Manual', '2027-01-03', NULL],
    ['1FMCU0GD0KUB12345', 2019, 'Ford', 'Escape', 'SE', 'Red', 'Black', 19900, NULL, 16000, 53000, 'Automatic', '2027-01-15', NULL],
    ['1FA6P8TH9J5146789', 2018, 'Ford', 'Mustang', 'GT', 'Green', 'Black', 34900, NULL, 28700, 42000, 'Manual', '2027-02-08', NULL],
    ['1C4RJFAG5FC123456', 2015, 'Jeep', 'Cherokee', 'Limited', 'Blue', 'Tan', 15900, NULL, 12400, 75000, 'Automatic', '2027-02-25', NULL],
    ['3FA6P0K94LR123456', 2020, 'Ford', 'Fusion', 'Titanium', 'Blue', 'Black', 24900, NULL, 19900, 39000, 'Automatic', '2027-03-12', NULL],
    ['2T3DFREV3AW123456', 2015, 'Toyota', 'RAV4', 'XLE', 'Silver', 'Black', 17900, NULL, 14500, 81000, 'Automatic', '2027-04-06', NULL],
    ['2C4RC1BG9KR123456', 2019, 'Chrysler', 'Pacifica', 'Touring L', 'Red', 'Gray', 33900, NULL, 27900, 54000, 'Automatic', '2027-05-01', NULL],
    ['1G6AW1R36H0123456', 2017, 'Cadillac', 'CTS', 'Luxury', 'Black', 'Tan', 23900, NULL, 19100, 65000, 'Automatic', '2027-06-10', NULL],
    ['5J6YH2H40KL123456', 2019, 'Honda', 'CR-V', 'EX', 'Blue', 'Beige', 25900, NULL, 21000, 43000, 'CVT', '2027-07-22', NULL],
    ['3GNCJKSB7HL123456', 2017, 'Chevrolet', 'Trax', 'LT', 'Red', 'Black', 11900, NULL, 9500, 72000, 'Automatic', '2027-08-13', NULL],
    ['1FMCU9GD5LUB12345', 2020, 'Ford', 'Escape', 'Titanium', 'White', 'Gray', 25900, NULL, 21200, 47000, 'Automatic', '2027-09-07', NULL],
    ['2FMPK3J88KBB12345', 2019, 'Ford', 'Edge', 'Titanium', 'Gray', 'Black', 31900, NULL, 26000, 43000, 'Automatic', '2027-10-15', NULL],
    ['3N1AB7AP6EY123456', 2014, 'Nissan', 'Sentra', 'SV', 'Blue', 'Gray', 9500, NULL, 7500, 88000, 'CVT', '2027-11-22', NULL],
    ['5XYZT3LB0JG123456', 2019, 'Hyundai', 'Santa Fe', 'SE', 'Red', 'Black', 23900, NULL, 19100, 53000, 'Automatic', '2027-12-04', NULL],
    ['1C4PJLBG4KD123456', 2019, 'Jeep', 'Cherokee', 'Latitude', 'White', 'Gray', 20900, NULL, 17000, 57000, 'Automatic', '2028-01-06', NULL],
    ['3GTU2UECXJG123456', 2020, 'GMC', 'Sierra', 'SLT', 'Blue', 'Black', 37900, NULL, 31000, 45000, 'Automatic', '2028-02-15', NULL]
];


foreach ($records as $record) {
    $stmt->bind_param(
        "sisssssddidsss",
        $record[0], $record[1], $record[2], $record[3], $record[4], $record[5],
        $record[6], $record[7], $record[8], $record[9], $record[10], $record[11],
        $record[12], $record[13]
    );
    if ($stmt->execute()) {
        
    } else {
        echo "<p class='message'>Error inserting record for VIN {$record[0]}: " . $stmt->error . "</p>";
    }
}
 



$createTableSQL = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL
)";

// Execute the query
if ($mysqli->query($createTableSQL) === TRUE) {
   
} else {
    echo "Error creating table: " . $mysqli->error . "\n";
}

$users = [
    ['web250user', 'LetMeIn!', 'Web', 'User'],
    ['jdoe', 'password123', 'John', 'Doe'],
    ['asmith', 'MySecretPass', 'Alice', 'Smith']
];


$stmt = $mysqli->prepare("INSERT IGNORE INTO users (username, password, first_name, last_name) VALUES (?, ?, ?, ?)");


foreach ($users as $user) {
    $username = $user[0];
    $password = $user[1];
    $first_name = $user[2];
    $last_name = $user[3];

    $stmt->bind_param("ssss", $username, $password, $first_name, $last_name);
    $stmt->execute();
}

// Close the prepared statement
$stmt->close();



?>

<style>
    .message {
        opacity: 1;
        visibility: visible;
        transition: opacity 3s ease-in-out;
        color:red;
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

