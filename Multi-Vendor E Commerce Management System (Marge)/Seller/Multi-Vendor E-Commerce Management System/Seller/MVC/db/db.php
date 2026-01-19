<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "seller";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create users table if not exists
$create_users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_users_table);

// Create products table if not exists
$create_products_table = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id INT NOT NULL,
    status VARCHAR(50) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_products_table);

// Create categories table if not exists
$create_categories_table = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL,
    products VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_categories_table);

// Insert default user if users table is empty
$check_users = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
$user_count = mysqli_fetch_assoc($check_users)['count'];
if ($user_count == 0) {
    $default_user = "INSERT INTO users (username, password) VALUES ('seller1', 'password123')";
    mysqli_query($conn, $default_user);
}
?>
