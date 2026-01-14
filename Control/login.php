


<?php
session_start();
include "../Model/logindb.php";

$username = $password = "";
$username_err = $password_err = "";

// If already logged in, go straight to Dashboard
if (isset($_SESSION['username'])) {
    header("Location: Dashboard.php");
    exit();
}

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

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT username, password, role FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Login successful, set session
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];

                // Redirect to Dashboard
                header("Location: Dashboard.php");
                exit();
            } else {
                $password_err = "Invalid password";
            }
        } else {
            $username_err = "User not found";
        }
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
        <input type="text" name="username" Placeholder="Enter Your Username" value="<?php echo htmlspecialchars($username); ?>">
        <?php if(!empty($username_err)) echo "<div class='error'>$username_err</div>"; ?>
    </div>

    <div>
        Password:
        <input type="password" name="password" Placeholder="Enter Your Password" value="<?php echo htmlspecialchars($password); ?>">
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
