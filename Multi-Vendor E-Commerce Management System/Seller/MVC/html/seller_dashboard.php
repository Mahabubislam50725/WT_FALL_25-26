
<?php
session_start();

// Database connection
include '../db/db.php';

$success = $error = "";
$seller_id = 1; // Default seller_id
$show_add_form = isset($_GET['add_product']);
$show_edit_form = isset($_GET['edit_id']);
$show_profile_form = isset($_GET['profile']);
$edit_product = null;

// Get seller_id from session or fetch from database
if (!isset($_SESSION['user_id'])) {
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user_result = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
            $_SESSION['user_id'] = $user_data['id'];
            $seller_id = $user_data['id'];
        }
    }
} else {
    $seller_id = $_SESSION['user_id'];
}

// Delete Product
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id='$delete_id' AND seller_id='$seller_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Product deleted successfully!";
    } else {
        $error = "Error deleting product!";
    }
    header("Location: seller_dashboard.php");
    exit();
}

// Get product for editing
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_result = mysqli_query($conn, "SELECT * FROM products WHERE id='$edit_id' AND seller_id='$seller_id'");
    if ($edit_result && mysqli_num_rows($edit_result) > 0) {
        $edit_product = mysqli_fetch_assoc($edit_result);
    }
}

// Update Product
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    
    if (empty($product_name) || empty($category) || empty($price)) {
        $error = "All fields are required!";
    } else {
        $sql = "UPDATE products SET product_name='$product_name', category='$category', price='$price' 
                WHERE id='$product_id' AND seller_id='$seller_id'";
        if (mysqli_query($conn, $sql)) {
            $success = "Product updated successfully!";
            header("Location: seller_dashboard.php");
            exit();
        } else {
            $error = mysqli_error($conn);
        }
    }
}

// Update Profile
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (!empty($password)) {
        $sql = "UPDATE users SET username='$username', password='$password' WHERE id='$seller_id'";
    } else {
        $sql = "UPDATE users SET username='$username' WHERE id='$seller_id'";
    }
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $username;
        $success = "Profile updated successfully!";
        header("Location: seller_dashboard.php");
        exit();
    } else {
        $error = mysqli_error($conn);
    }
}

// Add Product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    
    if (empty($product_name) || empty($category) || empty($price)) {
        $error = "All fields are required!";
    } else {
        $sql = "INSERT INTO products (product_name, category, price, seller_id, status) 
                VALUES ('$product_name', '$category', '$price', '$seller_id', 'Active')";
        if (mysqli_query($conn, $sql)) {
            $success = "Product added successfully!";
            header("Location: seller_dashboard.php");
            exit();
        } else {
            $error = mysqli_error($conn);
        }
    }
}

// Fetch Products
$result = mysqli_query($conn, "SELECT * FROM products WHERE seller_id='$seller_id'");
$profile_result = mysqli_query($conn, "SELECT * FROM users WHERE id='$seller_id'");
$profile = $profile_result ? mysqli_fetch_assoc($profile_result) : [];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/seller_dashboard.css">
    <title>Seller Dashboard</title>
</head>
<body>
    <div class="maindiv">
        <div class="adminNav">
            <h1>🛒 Multi-Vendor E-Commerce</h1>
            <ul class="nav">
                <li class="navlist">Home</li>
                <li class="navlist">My Products</li>
                <li class="navlist">Orders</li>
                <li class="navlist"><a href="?profile=1">Profile</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>

        <div class="adminBody">
            <h1 style="text-align:center;">Seller Dashboard</h1>
            
            <?php 
            if ($success) {
                echo '<div class="alert alert-success">' . $success . '</div>';
            }
            if ($error) {
                echo '<div class="alert alert-error">' . $error . '</div>';
            }
            ?>
    <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Products</h3>
                    <p class="stat-number">24</p>
                </div>
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <p class="stat-number">156</p>
                </div>
                <div class="stat-card">
                    <h3>Pending Orders</h3>
                    <p class="stat-number">8</p>
                </div>
                <div class="stat-card">
                    <h3>Total Revenue</h3>
                    <p class="stat-number">$12,450</p>
                </div>
            </div>

            <h2 style="margin-top: 40px;">My Products</h2>
            <a href="?add_product=1" class="btn btn-primary" style="margin-bottom: 20px; text-decoration: none; display: inline-block;">Add New Product</a>
            

    <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { 
                                $formatted_id = str_pad($row['id'], 3, '0', STR_PAD_LEFT);
                                echo '<tr>';
                                echo '<td>#' . $formatted_id . '</td>';
                                echo '<td>' . $row['product_name'] . '</td>';
                                echo '<td>' . $row['category'] . '</td>';
                                echo '<td>$' . $row['price'] . '</td>';
                                echo '<td><span class="status-badge status-active">' . $row['status'] . '</span></td>';
                                echo '<td>';
                                echo '<a href="?edit_id=' . $row['id'] . '" class="action-btn edit-btn" style="text-decoration: none;">Edit</a>';
                                echo '<a href="?delete_id=' . $row['id'] . '" class="action-btn delete-btn" style="text-decoration: none;" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } 
                        
                        else {
                            echo '<tr><td colspan="6" style="text-align: center; padding: 30px;">No products added yet</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
            </div>
                   <h2 style="margin-top: 40px;">Recent Orders</h2>
                       <div class="table-container">

                    <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>#ORD-001</td>
                            <td>John Doe</td>
                            <td>Wireless Headphones</td>
                            <td>2</td>
                            <td>$179.98</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn view-btn">View</button>
                                <button class="action-btn edit-btn">Update</button>
                        </td>
                        </tr>

                        <tr>
                            <td>#ORD-002</td>
                            <td>Jane Smith</td>
                            <td>Smart Watch</td>
                            <td>1</td>
                            <td>$199.99</td>
                            <td><span class="status-badge status-shipped">Shipped</span></td>
                            <td>
                                <button class="action-btn view-btn">View</button>
                                <button class="action-btn edit-btn">Update</button>
                            </td>
                        </tr>

                        <tr>
                            <td>#ORD-003</td>
                            <td>Mike Johnson</td>
                            <td>Laptop Stand</td>
                            <td>3</td>
                            <td>$104.97</td>
                            <td><span class="status-badge status-delivered">Delivered</span></td>
                            <td>
                                 <button class="action-btn view-btn">View</button>
                                <button class="action-btn edit-btn">Update</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>

    <?php if ($show_profile_form): ?>
    <!-- Profile Form -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; width: 400px;">
            <h2>My Profile</h2>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label>Seller Name:</label><br>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($profile['username'] ?? ''); ?>" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Password:</label><br>
                    <input type="password" name="password" placeholder="Leave blank to keep current password" style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                <div style="text-align: right;">
                    <a href="seller_dashboard.php" style="margin-right: 10px; text-decoration: none; color: #666;">Cancel</a>
                    <button type="submit" name="update_profile" style="background: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px;">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <?php endif; ?>
    <?php if ($show_edit_form && $edit_product): ?>
    <!-- Edit Product Form -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; width: 400px;">
            <h2>Edit Product</h2>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $edit_product['id']; ?>">
                <div style="margin-bottom: 15px;">
                    <label>Product Name:</label><br>
                    <input type="text" name="product_name" value="<?php echo htmlspecialchars($edit_product['product_name']); ?>" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Category:</label><br>
                    <input type="text" name="category" value="<?php echo htmlspecialchars($edit_product['category']); ?>" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                 <div style="margin-bottom: 15px;">
                    <label>Price:</label><br>
                    <input type="number" name="price" value="<?php echo $edit_product['price']; ?>" step="0.01" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                <div style="text-align: right;">
                    <a href="seller_dashboard.php" style="margin-right: 10px; text-decoration: none; color: #666;">Cancel</a>
                    <button type="submit" name="update_product" style="background: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px;">Update Product</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($show_add_form): ?>
    <!-- Add Product Form -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; width: 400px;">
            <h2>Add New Product</h2>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label>Product Name:</label><br>
                    <input type="text" name="product_name" placeholder="Enter product name" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Category:</label><br>
                    <input type="text" name="category" placeholder="Enter category" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                    
                <div style="margin-bottom: 15px;">
                    <label>Price:</label><br>
                    <input type="number" name="price" placeholder="Enter price" step="0.01" required style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                    
                <div style="text-align: right;">
                    <a href="seller_dashboard.php" style="margin-right: 10px; text-decoration: none; color: #666;">Cancel</a>
                    <button type="submit" name="add_product" style="background: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px;">Add Product</button>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>
</body>
</html>

<?php
mysqli_close($conn);
?>



