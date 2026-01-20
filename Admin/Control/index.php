<?php
session_start();

if (isset($_SESSION['username']) && !isset($_COOKIE['remember_user'])) {
    header("Location: Dashboard.php");
    exit();
}

if (isset($_COOKIE['remember_user']) && isset($_SESSION['username'])) {
    session_destroy();
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="icon" href="../Image/home.avif">
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Website</h1>
        <p>Please <a href="login.php">Login</a></p>
    </div>
</body>
</html>

