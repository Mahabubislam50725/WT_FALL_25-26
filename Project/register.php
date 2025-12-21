<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Multi-Vendor E-Commerce Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Multi-Vendor E-Commerce Management System</h1>

    <?php

    $username="";
    $email="";
    $Password="";
    $confirm_password="";
    $usertype="";

    $usererror="";
    $emailerror="";
    $passworderror="";
    $confirm_passworderror="";
    $usertypeerror="";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["username"])) {
        $usererror = "Username cannot be empty";
    } else {
        $username = trim($_POST["username"]);
        if (str_word_count($username) < 2) {
            $usererror = "Username must contain at least two words";
        } elseif (!preg_match("/^[a-zA-Z][a-zA-Z0-9 .-]*$/", $username)) {
            $usererror = "Invalid username format";
        }
    }

 
    if (empty($_POST["email"])) {
        $emailerror = "Email cannot be empty";
    } else {
        $email = trim($_POST["email"]);
        if (strpos($email, '@') === false || strpos($email, '.com') === false) {
            $emailerror = "Email must contain @ and .com";
        }
    }

   
    if (empty($_POST["password"])) {
        $passworderror = "Password cannot be empty";
    } else {
        $Password = trim($_POST["password"]);
        if (strlen($Password) < 6) {
            $passworderror = "Password must be at least 6 characters";
        }
    }


    if (empty($_POST["confirm_password"])) {
        $confirm_passworderror = "Confirm Password cannot be empty";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (!empty($Password) && $Password !== $confirm_password) {
            $confirm_passworderror = "Passwords do not match";
        }
    }

    
    if (empty($_POST["usertype"])) {
        $usertypeerror = "Select user type";
    } else {
        $usertype = trim($_POST["usertype"]);
    }

}


function text_input($data)
{
    return trim($data);
}
?>
    <form class="register-form" action="register.php" method="post">
         <h2>Register</h2>

    <div class="form-row">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>">
        <span class="error"><?php echo $usererror; ?></span>
    </div>

    <div class="form-row">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
        <span class="error"><?php echo $emailerror; ?></span>
    </div>

    <div class="form-row">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span class="error"><?php echo $passworderror; ?></span>
    </div>

    <div class="form-row">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password">
        <span class="error"><?php echo $confirm_passworderror; ?></span>
    </div>

    <div class="form-row">
        <label for="usertype">User Type:</label>
        <select name="usertype" id="usertype">
            <option value="">Select Type</option>
            <option value="admin" <?php if($usertype=="admin") echo "selected"; ?>>Admin</option>
            <option value="seller" <?php if($usertype=="seller") echo "selected"; ?>>Seller (Vendor)</option>
            <option value="customer" <?php if($usertype=="customer") echo "selected"; ?>>Customer</option>
        </select>
        <span class="error"><?php echo $usertypeerror; ?></span>
    </div>

    <button type="submit">Register</button>

    <p class="register-text">Already have an account?
        <a href="index.php">Login</a>
    </p>
    </form>
</body>
</html>
 