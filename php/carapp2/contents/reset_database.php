<?php
include_once('../db.php'); // Include your database connection


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_database'])) {
    try {
        // Disable foreign key checks to avoid constraint issues
        $mysqli->query("SET FOREIGN_KEY_CHECKS = 0");

        // Truncate the INVENTORY table
        if ($mysqli->query("TRUNCATE TABLE INVENTORY") === FALSE) {
            throw new Exception("Failed to truncate INVENTORY table: " . $mysqli->error);
        }

        // Truncate the images table
        if ($mysqli->query("TRUNCATE TABLE images") === FALSE) {
            throw new Exception("Failed to truncate images table: " . $mysqli->error);
        }

        // Re-enable foreign key checks
        $mysqli->query("SET FOREIGN_KEY_CHECKS = 1");

        // Success message
        echo "The INVENTORY and images tables have been reset successfully.";
    } catch (Exception $e) {
        // Handle errors
        echo "Error resetting tables: " . $e->getMessage();
    } finally {
        // Close the database connection
        $mysqli->close();
    }
} else {
    // Handle unauthorized access
    echo "Unauthorized access.";
}
?>