<?php

echo '
<form id="carForm">
  <div class="form-row">
    <div class="form-group">
      <label for="VIN">VIN:</label>
      <input type="text" id="VIN" name="VIN" placeholder="ex: 123AD31" required>
    </div>
    <div class="form-group">
      <label for="Make">Make:</label>
      <input type="text" id="Make" name="Make" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="Model">Model:</label>
      <input type="text" id="Model" name="Model" required>
    </div>
    <div class="form-group">
      <label for="Price">Price:</label>
      <input type="number" id="Price" name="Price" step="0.01" required>
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