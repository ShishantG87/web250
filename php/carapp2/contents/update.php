<?php
include_once '../db.php'; 

// Collect all POST data
$data = $_POST;

// Required key to identify the record
$vin = $data['VIN'] ?? '';

if ($vin) {
    // Build the SQL dynamically
    $fields = [];
    $values = [];

    foreach ($data as $key => $value) {
       
            $fields[] = "$key = ?";
            $values[] = $value;
       
    }

    if (!empty($fields)) {
        // Add VIN to the values for the WHERE clause
        $values[] = $vin;

        // Prepare the SQL query
        $sql = "UPDATE INVENTORY SET " . implode(", ", $fields) . " WHERE VIN = ?";
        $stmt = $mysqli->prepare($sql);

        // Dynamically bind parameters
        $types = str_repeat('s', count($values) - 1) . 's'; // Assume all fields are strings except VIN
        $stmt->bind_param($types, ...$values);

        // Execute the query
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Update failed: " . $mysqli->error;
        }

        $stmt->close();
    } else {
        echo "No fields to update.";
    }
} else {
    echo "VIN is required.";
}

$mysqli->close();
?>