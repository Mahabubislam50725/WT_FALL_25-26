<?php
$username = $email = $age = $password = $confirm_password = "";
$username_err = $email_err = $age_err = $password_err = $confirm_password_err = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $username_err = "Username cannot be empty";
    } else {
        $username = trim($_POST["username"]);
        if (strlen($username) < 3) $username_err = "Username must be at least 3 characters";
    }

    if (empty($_POST["email"])) {
        $email_err = "Email cannot be empty";
    } else {
        $email = trim($_POST["email"]);
        if (strpos($email, '@') === false || strpos($email, '.') === false)
            $email_err = "Invalid email format";
    }

    if (empty($_POST["age"])) {
        $age_err = "Age cannot be empty";
    } else {
        $age = trim($_POST["age"]);
        if (!is_numeric($age) || $age < 18 || $age > 60)
            $age_err = "Age must be a number between 18 and 60";
    }

    if (empty($_POST["password"])) {
        $password_err = "Password cannot be empty";
    } else {
        $password = trim($_POST["password"]);
        if (strlen($password) < 6)
            $password_err = "Password must be at least 6 characters";
    }

    if (empty($_POST["confirm_password"])) {
        $confirm_password_err = "Confirm Password cannot be empty";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password)
            $confirm_password_err = "Passwords do not match";
    }

    if (empty($username_err) && empty($email_err) && empty($age_err) && empty($password_err) && empty($confirm_password_err)) {
        $success_msg = "Registration Successful ✅";
        $username = $email = $age = $password = $confirm_password = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
   <link rel="stylesheet" href="../CSS/register.css">


</head>
<body>

<form method="post" action="">
    <h1>Registration Page</h1>

    <?php if(!empty($success_msg)) echo "<p class='success'>$success_msg</p>"; ?>

    <div>
        Username:
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <?php if(!empty($username_err)) echo "<div class='error'>$username_err</div>"; ?>
    </div>

    <div>
        Email:
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <?php if(!empty($email_err)) echo "<div class='error'>$email_err</div>"; ?>
    </div>

    <div>
        Age:
        <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>">
        <?php if(!empty($age_err)) echo "<div class='error'>$age_err</div>"; ?>
    </div>

    <div>
        Password:
        <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
        <?php if(!empty($password_err)) echo "<div class='error'>$password_err</div>"; ?>
    </div>

    <div>
        Confirm Password:
        <input type="password" name="confirm_password" value="<?php echo htmlspecialchars($confirm_password); ?>">
        <?php if(!empty($confirm_password_err)) echo "<div class='error'>$confirm_password_err</div>"; ?>
    </div>

    <div id="button">
        <button type="submit">Register</button>
    </div>

    <div class="register-link">
        Already have an account? 
        <a href="login.php">Login here</a>
    </div>
</form>

</body>
</html>
