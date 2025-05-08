<?php


$valid_username = "web250user";
$valid_password = "LetMeIn!";


$logged_in = false;

if (isset($_GET['logout'])) {
    $logged_in = false; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $valid_username && $password === $valid_password) {
        $logged_in = true; 
    } else {
        $error_message = "Invalid username or password.";
    }
}

?>

<?php if ($logged_in): ?>
   
    <a href="?logout=1">Return to Log in</a>

    <?php
    
    require_once('contents/add-cars.php');
    require_once('contents/show_inventory.php');
    ?>

<?php else: ?>
    
    <h2>Login Form</h2>

    <?php 
    
    if (isset($error_message)) {
        echo "<p class='message'>{$error_message}</p>";
    }
    ?>

    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <?php require_once('contents/show_inventory-default.php'); ?>

<?php endif; ?>
