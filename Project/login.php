<!DOCTYPE html>
<html lang="en">
<head>
    <title>Multi-Vendor E-Commerce Management System </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Multi-Vendor E-Commerce Management System</h1>
    <form action="login.php" method="post">
        <h2>Login</h2>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button><br><br>

        <p class="register-text">Don't have an account? 
            <a href="register.php">Register</a>
        </p>
    </form>
</body>
</html>
