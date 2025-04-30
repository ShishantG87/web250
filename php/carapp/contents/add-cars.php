<?php

echo '<form id="carForm">
    <label for="VIN">VIN:</label>
    <input type="text" id="VIN" name="VIN" placeholder="ex: 123AD31" required><br><br>
  
    <label for="Make">Make:</label>
    <input type="text" id="Make" name="Make" required><br><br>
  
    <label for="Model">Model:</label>
    <input type="text" id="Model" name="Model" required><br><br>
  
    <label for="Price">Price:</label>
    <input type="number" id="Price" name="Price" required><br><br>
  
    <button type="submit">Submit</button>
  </form>';
  

  ?>

  <script>
    document.getElementById("carForm").addEventListener("submit", function (event) {

      event.preventDefault();

      const formData = new FormData(this);
      fetch("contents/submit.php" , {
        method: "POST",
        body: formData
      })

      .then((response) => response.text())
      .then((message) => {
        alert(message);
        this.reset();
      })
      .catch((error) => {
        alert(error);
      })
    })
  </script>
