<?php
$result = $mysqli->query('SELECT * FROM INVENTORY');

if ($result) {
    $inventory = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($inventory)) {
        echo "<p>No records found in the inventory table.</p>";
    } else {
        echo "<table>";
        echo "<tr>
                <th>VIN</th>
                <th>Year</th>
                <th>Make</th>
                <th>Model</th>
                <th>Trim</th>
                <th>Exterior Color</th>
                <th>Interior Color</th>
                <th>Asking Price</th>
                <th>Sale Price</th>
                <th>Purchase Price</th>
                <th>Mileage</th>
                <th>Transmission</th>
                <th>Purchase Date</th>
                <th>Sale Date</th>
              </tr>";

        foreach ($inventory as $record) {
            echo "<tr>";
            echo "<td>{$record['VIN']}</td>";
            echo "<td>{$record['YEAR']}</td>";
            echo "<td>{$record['Make']}</td>";
            echo "<td>{$record['Model']}</td>";
            echo "<td>{$record['TRIM']}</td>";
            echo "<td>{$record['EXT_COLOR']}</td>";
            echo "<td>{$record['INT_COLOR']}</td>";
            echo "<td>{$record['ASKING_PRICE']}</td>";
            echo "<td>{$record['SALE_PRICE']}</td>";
            echo "<td>{$record['PURCHASE_PRICE']}</td>";
            echo "<td>{$record['MILEAGE']}</td>";
            echo "<td>{$record['TRANSMISSION']}</td>";
            echo "<td>{$record['PURCHASE_DATE']}</td>";
            echo "<td>{$record['SALE_DATE']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
} else {
    echo "<p>Error fetching data: " . $mysqli->error . "</p>";
}
?>






<style>  
/*STYLES *********************************************************************************************************************************************************************************************************************** */
.delete, .edit-btn, .save-btn, .cancel-btn {
    background-color: #ff5722; 
    color: white;
    padding: 3px 12px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 0 0 4px;
}

.delete:hover {
    background-color: #e64a19; 
}

.delete:active {
    transform: scale(1.1); 
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0 70px 0;
    font-family: Arial, sans-serif;
    table-layout: fixed;
}

th {
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: #2c7dbf; 
    color: white;
    padding: 12px 15px;
    min-width: 10vw;
    text-align: left;
}

td {
    padding: 8px 15px;
    border: 1px solid #bbb; 
    text-align: left;
}

tbody {
    display: block;
    max-height: 600px;
    overflow-y: auto;
    overflow-x: auto;
    width: 100%;
    border-top: 1px solid #bbb; 
}

thead {
    display: table;
    width: 100%;
    table-layout: fixed;
}

th, td {
    border: 1px solid #bbb; 
}

tr:nth-child(even) {
    background-color: #f0f8ff;
    color: #333; 
}

tr:nth-child(odd) {
    background-color: #e0f7fa; 
    color: #333; 
}

tr:hover {
    background-color: #ffeb3b; 
    cursor: pointer;
    color: #333; 
    transition: background-color 0.3s ease-in-out;
}
</style>

