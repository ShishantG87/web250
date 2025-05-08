<?php

echo '
<form id="carForm">
  <div class="form-row">
    <div class="form-group">
      <label for="VIN">VIN:</label>
      <input type="text" id="VIN" name="VIN" placeholder="ex: 123AD31" required>
    </div>
    <div class="form-group">
      <label for="YEAR">Year:</label>
      <input type="number" id="YEAR" name="YEAR" min="1900" max="2099" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="Make">Make:</label>
      <input type="text" id="Make" name="Make" required>
    </div>
    <div class="form-group">
      <label for="Model">Model:</label>
      <input type="text" id="Model" name="Model" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="TRIM">Trim:</label>
      <input type="text" id="TRIM" name="TRIM">
    </div>
    <div class="form-group">
      <label for="EXT_COLOR">Exterior Color:</label>
      <input type="text" id="EXT_COLOR" name="EXT_COLOR">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="INT_COLOR">Interior Color:</label>
      <input type="text" id="INT_COLOR" name="INT_COLOR">
    </div>
    <div class="form-group">
      <label for="ASKING_PRICE">Asking Price:</label>
      <input type="number" id="ASKING_PRICE" name="ASKING_PRICE" step="0.01">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="SALE_PRICE">Sale Price:</label>
      <input type="number" id="SALE_PRICE" name="SALE_PRICE" step="0.01">
    </div>
    <div class="form-group">
      <label for="PURCHASE_PRICE">Purchase Price:</label>
      <input type="number" id="PURCHASE_PRICE" name="PURCHASE_PRICE" step="0.01">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="MILEAGE">Mileage:</label>
      <input type="number" id="MILEAGE" name="MILEAGE" step="1">
    </div>
    <div class="form-group">
      <label for="TRANSMISSION">Transmission:</label>
      <input type="text" id="TRANSMISSION" name="TRANSMISSION">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="PURCHASE_DATE">Purchase Date:</label>
      <input type="date" id="PURCHASE_DATE" name="PURCHASE_DATE">
    </div>
    <div class="form-group">
      <label for="SALE_DATE">Sale Date:</label>
      <input type="date" id="SALE_DATE" name="SALE_DATE">
    </div>
  </div>

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
      });
    });
  </script>

<style>

#carForm {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 8px;
  width: 500px;
  margin: 40px auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  font-family: Arial, sans-serif;
  color: #000000;
  box-sizing: border-box;
}


#carForm .form-row {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 20px;
}


#carForm .form-group {
  flex: 1;
}


#carForm label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #222222;
}


#carForm input {
  width: 100%;
  padding: 8px;
  border: 1px solid #cccccc;
  border-radius: 4px;
  box-sizing: border-box;
}


#carForm button {
  min-width: 10vw;
  padding: 10px;
  background-color: #39396d;
  color: #ffffff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

#carForm button:hover {
  background-color: #2e2e5a;
}

</style>