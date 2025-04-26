<?php 

// Query to fetch all records from the INVENTORY table
$result = $mysqli->query('SELECT * FROM INVENTORY');

// Check if the query was successful
if ($result) {
    // Fetch all rows as an associative array
    $inventory = $result->fetch_all(MYSQLI_ASSOC);
    
    // Check if there are records
    if (empty($inventory)) {
        echo "<p>No records found in the inventory table.</p>";
    } else {
        // Start HTML table
        echo "<table >";
        echo "<tr>
                <th>Make</th>
                <th>Model</th>
                <th>Asking Price</th>
                <th>Action</th>
              </tr>";

        // Loop through each record and print data in table rows
        foreach ($inventory as $record) {
            echo "<tr>";
            echo "<td>" . $record['Make'] . "</td>";
            echo "<td>" . $record['Model'] . "</td>";
            echo "<td>" . $record['ASKING_PRICE'] . "</td>";
            echo "<td>" . "Edit&nbsp;&nbsp;" . "&nbsp;Delete" . "</td>" ;
            echo "</tr>";
        }

        // End HTML table
        echo "</table>";
    }
} else {
    echo "<p>Error fetching data: " . $mysqli->error . "</p>";
}
?>
 
 <style>
    table {
        width: 100%;                
        border-collapse: collapse;  
        margin: 20px 0;             
        font-family: Arial, sans-serif; 
    }

    th {
        background-color: rgb(39, 171, 233);  
        color: white;               
        padding: 12px 15px;        
        text-align: left;           
    }

    td {
        padding: 8px 15px;        
        border: 1px solid #ddd;     
        text-align: left;          
    }

    th, td {
        border: 1px solid black;
    }

    tr:nth-child(even) {
        background-color: #A2ECDB;  
        color: black;
    }

    tr:hover {
        background-color: red;    
        cursor: pointer;
        color: black;
    }
</style>
