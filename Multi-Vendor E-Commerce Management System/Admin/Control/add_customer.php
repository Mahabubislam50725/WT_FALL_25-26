<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../View/login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "multi-vendor e-commerce";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success = $error = "";

/* ADD CUSTOMER */
if (isset($_POST['add'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $role = 'Customer';

    if (empty($username) || empty($password) || empty($email)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email='$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, email, role) 
                    VALUES ('$username', '$hashedPassword', '$email', '$role')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "Customer added successfully!";
                header("Location: Dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = mysqli_error($conn);
                header("Location: Dashboard.php");
                exit();
            }
        }
    }
    
    if ($error) {
        $_SESSION['error'] = $error;
        header("Location: Dashboard.php");
        exit();
    }
}

/* UPDATE CUSTOMER */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($email)) {
        $_SESSION['error'] = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
    } else {
        // Check if email already exists for other users
        $check_sql = "SELECT id FROM users WHERE email='$email' AND id != $id";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error'] = "Email already exists!";
        } else {
            $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id AND role='Customer'";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "Customer updated successfully!";
            } else {
                $_SESSION['error'] = mysqli_error($conn);
            }
        }
    }
    header("Location: Dashboard.php");
    exit();
}

/* DELETE CUSTOMER */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id AND role='Customer'");
    $_SESSION['success'] = "Customer deleted successfully!";
    header("Location: Dashboard.php");
    exit();
}

mysqli_close($conn);
?>