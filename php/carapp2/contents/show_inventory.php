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
                <th>Action</th>
              </tr>";

      
        foreach ($inventory as $record) {
            echo "<tr data-original-vin='" . $record['VIN'] . "'>";

            echo "<td>
                    <span class='text' name='VIN'>" . $record['VIN'] . "</span>
                    <input class='edit-input' type='text' name='VIN' value='" . $record['VIN'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='YEAR'>" . $record['YEAR'] . "</span>
                    <input class='edit-input' type='number' name='YEAR' value='" . $record['YEAR'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='Make'>" . $record['Make'] . "</span>
                    <input class='edit-input' type='text' name='Make' value='" . $record['Make'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='Model'>" . $record['Model'] . "</span>
                    <input class='edit-input' type='text' name='Model' value='" . $record['Model'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='TRIM'>" . $record['TRIM'] . "</span>
                    <input class='edit-input' type='text' name='TRIM' value='" . $record['TRIM'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='EXT_COLOR'>" . $record['EXT_COLOR'] . "</span>
                    <input class='edit-input' type='text' name='EXT_COLOR' value='" . $record['EXT_COLOR'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='INT_COLOR'>" . $record['INT_COLOR'] . "</span>
                    <input class='edit-input' type='text' name='INT_COLOR' value='" . $record['INT_COLOR'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='ASKING_PRICE'>" . $record['ASKING_PRICE'] . "</span>
                    <input class='edit-input' type='number' name='ASKING_PRICE' value='" . $record['ASKING_PRICE'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='SALE_PRICE'>" . $record['SALE_PRICE'] . "</span>
                    <input class='edit-input' type='number' name='SALE_PRICE' value='" . $record['SALE_PRICE'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='PURCHASE_PRICE'>" . $record['PURCHASE_PRICE'] . "</span>
                    <input class='edit-input' type='number' name='PURCHASE_PRICE' value='" . $record['PURCHASE_PRICE'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='MILEAGE'>" . $record['MILEAGE'] . "</span>
                    <input class='edit-input' type='number' name='MILEAGE' value='" . $record['MILEAGE'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='TRANSMISSION'>" . $record['TRANSMISSION'] . "</span>
                    <input class='edit-input' type='text' name='TRANSMISSION' value='" . $record['TRANSMISSION'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='PURCHASE_DATE'>" . $record['PURCHASE_DATE'] . "</span>
                    <input class='edit-input' type='date' name='PURCHASE_DATE' value='" . $record['PURCHASE_DATE'] . "' hidden>
                  </td>";

            echo "<td>
                    <span class='text' name='SALE_DATE'>" . $record['SALE_DATE'] . "</span>
                    <input class='edit-input' type='date' name='SALE_DATE' value='" . $record['SALE_DATE'] . "' hidden>
                  </td>";

            echo "<td>
                    <button class='edit-btn'>Edit</button>
                    <button class='save-btn' hidden>Save</button>
                    <button class='cancel-btn' hidden>Cancel</button>
                    <button class='delete' data-vin='" . $record['VIN'] . "'>Delete</button>
                  </td>";

            echo "</tr>";
        }

        echo "</table>";
        echo "<form method='POST' action='contents/reset_database.php' onsubmit=\"return confirm('Are you sure you want to reset the tables? This action cannot be undone.')\">
        <button type='submit' name='reset_database' class='reset-button'>
            Reset Database
        </button>
      </form>";

    }
} else {
    echo "<p>Error fetching data: " . $mysqli->error . "</p>";
}
?>

<script> // EDIT BUTTON SCRIPT **************************************************************************************************************
function toggleEditMode(row, editing) {
    row.querySelectorAll('.text').forEach((el) => (el.hidden = editing));
    row.querySelectorAll('.edit-input').forEach((el) => (el.hidden = !editing));
    row.querySelector('.edit-btn').hidden = editing;
    row.querySelector('.save-btn').hidden = !editing;
    row.querySelector('.cancel-btn').hidden = !editing;
    const deleteButton = row.querySelector('.delete');
    if (deleteButton) deleteButton.hidden = editing;
}

// Edit Button
document.querySelectorAll('.edit-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');

        // Store original values for cancellation
        row.querySelectorAll('.edit-input').forEach((input) => {
            row.dataset[`original_${input.name}`] = input.value;
        });

        toggleEditMode(row, true);
    });
});

// Cancel Button
document.querySelectorAll('.cancel-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');

        
        row.querySelectorAll('.edit-input').forEach((input) => {
            input.value = row.dataset[`original_${input.name}`];
        });

        toggleEditMode(row, false);
    });
});

// Save Button
document.querySelectorAll('.save-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const vin = row.getAttribute('data-vin');
        const data = {};

        row.querySelectorAll('.edit-input').forEach((input) => {
            data[input.name] = input.value;
        });

        if (!data.VIN) {
            alert('VIN cannot be empty.');
            return;
        }

     
        fetch('contents/update.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data).toString()
        })
            .then((response) => {
                if (!response.ok) {
                    
                }
                return response.text();
            })
            .then((message) => {
                console.log(message);

            
                row.querySelectorAll('.text').forEach((span) => {
                    const fieldName = span.getAttribute('name');
                    span.textContent = data[fieldName];
                });

                toggleEditMode(row, false);
                alert('Record updated successfully.');
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Failed to update record.');
            });
    });
});

 // ************************************************************************************************************************************* END OF EDIT BUTTON SCRIPT
</script>



<script>
    //DELETE BUTTON SCRIPT ******************************************************************************************************************************************************
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
 //****************************************************************************************************************************************************** END OF DELETE BUTTON SCRIPT 
</script>
                    




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
.reset-button {
    background-color: red; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;
    position: relative;
    top: -50px;
   
    
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

