
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
      <h2>Home</h2>
      <section id="game">
        <h3>Play with Bob!</h3>
        <div id="img-cont">
          <img id="robot-img" src="images/robot.png" alt="robot"/>
          <p id="hover-text">Pick rock, paper, or scissors!</p>
        </div>

        <div id ='rps-cont'>
        <button class="rps-options" id="rock"><span class="b-top">Rock</span></button>
        <button class="rps-options" id="paper"> <span class="b-top">Paper</span></button>
        <button class="rps-options" id="scissors"><span class="b-top">Scissors</span></button>
      </div>
        
    </section>
    </main>

    <?php require_once('components/footer.php') ?>
    <script src="scripts/game.js"></script>
    
  </body>
</html>
