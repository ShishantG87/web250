<?php 
$result = $mysqli->query('SELECT * FROM INVENTORY');

if ($result) {
    $inventory = $result->fetch_all(MYSQLI_ASSOC);
    
    if (empty($inventory)) {
        echo "<p>No records found in the inventory table.</p>";
    } else {
        echo "<table>";
        echo "<tr>
                <th>Make</th>
                <th>Model</th>
                <th>Asking Price</th>
                <th>Action</th>
              </tr>";

        foreach ($inventory as $record) {
            echo "<tr>";
            echo "<td>" . $record['Make'] . "</td>";
            echo "<td>" . $record['Model'] . "</td>";
            echo "<td>" . $record['ASKING_PRICE'] . "</td>";
            echo "<td>" . "Edit&nbsp;&nbsp;" . "<button class='delete' data-vin='" . $record['VIN'] . "'>&nbsp;Delete</button>" . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
} else {
    echo "<p>Error fetching data: " . $mysqli->error . "</p>";
}
?>

<script>
const deleteInfo = document.querySelectorAll('.delete');

deleteInfo.forEach((button) => {
    button.addEventListener('click', function () {
        let vin = this.getAttribute('data-vin');

        if (confirm(`Are you sure you want to delete VIN ${vin}?`)) {
            fetch(`contents/delete.php?vin=${vin}`, { method: 'GET' })
                .then((response) => response.text())
                .then((message) => {
                    alert(message);
                    this.closest('tr').remove();
                })
                .catch((error) => {
                    console.error(error);
                    alert('Could not delete record');
                });
        }
    });
});
</script>

<style>
.delete {
    background-color: #ff5722; /* Lively orange-red */
    color: white;
    padding: 3px 12px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.delete:hover {
    background-color: #e64a19; /* Slightly darker red for hover */
}

.delete:active {
    transform: scale(1.1); 
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
    table-layout: fixed;
}

th {
    background-color: #2c7dbf; /* Soft blue that contrasts well with #535388 */
    color: white;
    padding: 12px 15px;
    min-width: 10vw;
    text-align: left;
}

td {
    padding: 8px 15px;
    border: 1px solid #bbb; /* Softer gray for borders */
    text-align: left;
}

tbody {
    display: block;
    max-height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
    width: 100%;
    border-top: 1px solid #bbb; /* Soft gray for the border */
}

thead {
    display: table;
    width: 100%;
    table-layout: fixed;
}

th, td {
    border: 1px solid #bbb; /* Matching the border color for consistency */
}

tr:nth-child(even) {
    background-color: #f0f8ff; /* Very light blue for even rows */
    color: #333; /* Dark text for readability */
}

tr:nth-child(odd) {
    background-color: #e0f7fa; /* Light cyan for odd rows */
    color: #333; /* Dark text for readability */
}

tr:hover {
    background-color: #ffeb3b; /* Soft yellow when hovering */
    cursor: pointer;
    color: #333; /* Dark text on hover for readability */
    transition: background-color 0.3s ease-in-out;
}
</style>

