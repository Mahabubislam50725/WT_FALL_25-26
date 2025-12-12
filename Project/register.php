<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Multi-Vendor E-Commerce Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Multi-Vendor E-Commerce Management System</h1>
    <form action="register.php" method="post">
        <h2>Register</h2>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <label for="usertype">User Type:</label>
        <select id="usertype" name="usertype" required>
            <option value="">Select Type</option>
            <option value="admin">Admin</option>
            <option value="seller">Seller (Vendor)</option>
            <option value="customer">Customer</option>
        </select><br><br>
        
        <button type="submit">Register</button><br><br>

        <p class="register-text">Already have an account? 
            <a href="login.php">Login</a>
        </p>
    </form>
</body>
</html>
