<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Multi-Vendor E-Commerce Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Multi-Vendor E-Commerce Management System</h1>

    <?php
$username = "";
$email = "";
$password = "";
$confirm_password = "";
$usertype = "";

$usernameErr = "";
$emailErr = "";
$passwordErr = "";
$confirmErr = "";
$usertypeErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Username validation
    if (empty($_POST["username"])) {
        $usernameErr = "Username cannot be empty";
    } else {
        $username = trim($_POST["username"]);
        if (str_word_count($username) < 1) {
            $usernameErr = "Username must contain at least 1 word";
        }
    }

    // Email validation
    if (empty($_POST["email"])) {
        $emailErr = "Email cannot be empty";
    } else {
        $email = trim($_POST["email"]);
        if (strpos($email, '@') === false || strpos($email, '.com') === false) {
            $emailErr = "Email must contain @ and .com";
        }
    }

    // Password validation
    if (empty($_POST["password"])) {
        $passwordErr = "Password cannot be empty";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        }
    }

    // Confirm password validation
    if (empty($_POST["confirm_password"])) {
        $confirmErr = "Confirm password required";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmErr = "Passwords do not match";
        }
    }

    // User type validation
    if (empty($_POST["usertype"])) {
        $usertypeErr = "Select user type";
    } else {
        $usertype = $_POST["usertype"];
    }
}
?>
    <form action="register.php" method="post">
        <h2>Register</h2>
 
            Username:
            <input type="text" name="username" value="<?php echo $username; ?>">
            <?php echo $usernameErr; ?>
            <br><br>

            Email:
            <input type="text" name="email" value="<?php echo $email; ?>">
            <?php echo $emailErr; ?>
            <br><br>

            Password:
            <input type="password" name="password">
            <?php echo $passwordErr; ?>
            <br><br>

            Confirm Password:
            <input type="password" name="confirm_password">
            <?php echo $confirmErr; ?>
            <br><br>

            User Type:
            <select name="usertype">
                <option value="">Select Type</option>
                <option value="Admin">Admin</option>
                <option value="Seller">Seller (Vendor)</option>
                <option value="Customer">Customer</option>
            </select>
            <?php echo $usertypeErr; ?>
            <br><br>

            <input type="submit" value="Register">
 
        <p class="register-text">Already have an account?
            <a href="index.php">Login</a>
        </p>
        
    </form>
</body>
</html>