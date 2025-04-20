


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" >

    <title>Shishant Bohora - Sneaky Bear - WEB250 - </title>
    <link href="styles/fonts.css" rel="stylesheet" >
    <link href="styles/default.css" rel="stylesheet">
    <script
      src="https://lint.page/kit/67ff88.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    
    <?php require_once('components/header.php') ?>
   
    <main>

    <?php 
      if(isset($_GET['p'])) {
          $page = $_GET['p']. ".php";
      } 
      else {
          $page = 'contents/home.php';
      } 
      include_once($page); 
      ?>
          
    </main>

    <?php require_once('components/footer.php') ?>
    <script src="scripts/game.js"></script>
    
  </body>
</html>
