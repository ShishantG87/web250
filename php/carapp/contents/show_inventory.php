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
            echo "<tr data-vin='" . $record['VIN'] . "'>";
            echo "<td><span class='text'>" . $record['Make'] . "</span>
                      <input class='edit-input' type='text' name='make' value='" . $record['Make'] . "' hidden></td>";
            echo "<td><span class='text'>" . $record['Model'] . "</span>
                      <input class='edit-input' type='text' name='model' value='" . $record['Model'] . "' hidden></td>";
            echo "<td><span class='text'>" . $record['ASKING_PRICE'] . "</span>
                      <input class='edit-input' type='number' name='price' value='" . $record['ASKING_PRICE'] . "' hidden></td>";

            echo "<td>
                    <button class='edit-btn'>Edit</button>
                    <button class='save-btn' hidden>Save</button>
                    <button class='cancel-btn' hidden>Cancel</button>
                    <button class='delete' data-vin='" . $record['VIN'] . "'>Delete</button>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    }
} else {
    echo "<p>Error fetching data: " . $mysqli->error . "</p>";
}

// *********************************************************************************** END OF PHP SCRIPT 
?>

<script> // EDIT BUTTON SCRIPT **************************************************************************************************************
function toggleEditMode(row, editing) {
    row.querySelectorAll('.text').forEach((el) => el.hidden = editing);
    row.querySelectorAll('.edit-input').forEach((el) => el.hidden = !editing);
    row.querySelector('.edit-btn').hidden = editing;
    row.querySelector('.save-btn').hidden = !editing;
    row.querySelector('.cancel-btn').hidden = !editing;
    const deleteButton = row.querySelector('.delete');
    deleteButton.hidden = editing;
}
document.querySelectorAll('.edit-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        
      
        row.dataset.originalMake = row.querySelector("input[name='make']").value;
        row.dataset.originalModel = row.querySelector("input[name='model']").value;
        row.dataset.originalPrice = row.querySelector("input[name='price']").value;

      
        toggleEditMode(row, true);
    });
});

document.querySelectorAll('.cancel-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        
        
        row.querySelector("input[name='make']").value = row.dataset.originalMake;
        row.querySelector("input[name='model']").value = row.dataset.originalModel;
        row.querySelector("input[name='price']").value = row.dataset.originalPrice;

       
        toggleEditMode(row, false);
    });
});

document.querySelectorAll('.save-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const vin = row.getAttribute('data-vin');
        const make = row.querySelector("input[name='make']").value;
        const model = row.querySelector("input[name='model']").value;
        const price = row.querySelector("input[name='price']").value;

        fetch('contents/update.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `vin=${vin}&make=${make}&model=${model}&price=${price}`
        })
        .then((response) => response.text())
        .then(() => {
            
            row.querySelectorAll('.text')[0].textContent = make;
            row.querySelectorAll('.text')[1].textContent = model;
            row.querySelectorAll('.text')[2].textContent = price;

            toggleEditMode(row, false);
            alert("Record updated.");
        })
        .catch((error) => {
            console.error(error);
            alert("Update failed.");
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
    overflow-x: hidden;
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

