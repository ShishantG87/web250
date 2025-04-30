<?php 
// Database connection settings
if ($_SERVER["HTTP_HOST"] === "localhost") { 
    // Localhost database credentials
    $hostName = "localhost"; 
    $userName = "root"; 
    $password = ""; 
    $databaseName = "carapp"; 
} else { 
    // Remote server database credentials
    $hostName = "sql301.infinityfree.com"; 
    $userName = "if0_38344523"; 
    $password = "JtYVhknon3DP88"; 
    $databaseName = "if0_38344523_carapp"; 
}

// Create connection
$mysqli = new mysqli($hostName, $userName, $password, $databaseName);

// Check connection
if ($mysqli->connect_error) { 
    die("Connection failed: " . $mysqli->connect_error); 
} 

// Optionally, check if the database exists (though already specified above)
if (!$mysqli->select_db($databaseName)) { 
    die("Failed to select the database: " . $mysqli->error); 
}
?>
