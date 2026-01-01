<?php
session_start();
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $username_err = "Username cannot be empty";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $password_err = "Password cannot be empty";
    } else {
        $password = trim($_POST["password"]);
    }

    // Temporary validation (replace with DB check)
    if (empty($username_err) && empty($password_err)) {
        // For demo purpose, login is always successful
        $_SESSION["username"] = $username;
        header("Location: admin_dashboard.php"); // Change this to your dashboard
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
  <link rel="stylesheet" href="../CSS/login.css">
  <link rel="icon" href="../Image/login.jpg" >


</head>
<body>

<form method="post" action="">
    <h1>Login Page</h1>

    <div>
        Username:
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <?php if(!empty($username_err)) echo "<div class='error'>$username_err</div>"; ?>
    </div>

    <div>
        Password:
        <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
        <?php if(!empty($password_err)) echo "<div class='error'>$password_err</div>"; ?>
    </div>

    <div id="button">
        <button type="submit">Login</button>
    </div>

    <div class="register-link">
        Don't have an account? <a href="register.php">Register</a>
    </div>
</form>

</body>
</html>
