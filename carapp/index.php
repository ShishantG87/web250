<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles/default.css" rel="stylesheet">
    <link href="../styles/fonts.css" rel="stylesheet">
    <script
      src="https://lint.page/kit/67ff88.js"
      crossorigin="anonymous"
    ></script>
    <title>Sneaky Bears Used Cars</title>
  </head>
  <body>
  <main>
    
    <?php
     require_once('../components/header.php');
     require_once('config_db.php');
     echo'<h1 class="car-header">Sneaky Bears Used Cars</h1>';
     require_once('contents/add-cars.php');
     require_once('contents/show_inventory.php');
     $mysqli->close();
    ?>
    
    </main>
    <?php require_once('contents/footer.php'); ?>
  </body>
</html>

<style>
  .car-header {
    position:relative;
    top: -54px;
  }
</style>