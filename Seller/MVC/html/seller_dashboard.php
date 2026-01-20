
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

// Get seller_id from session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Seller') {
    header("Location: ../../../Admin/Control/login.php");
    exit();
}
$seller_id = $_SESSION['user_id'];

// Delete Product
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM categories WHERE id='$delete_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Category deleted successfully!";
    } else {
        $error = "Error deleting category!";
    }
    header("Location: seller_dashboard.php");
    exit();
}

// Get product for editing
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_result = mysqli_query($conn, "SELECT * FROM categories WHERE id='$edit_id'");
    if ($edit_result && mysqli_num_rows($edit_result) > 0) {
        $edit_product = mysqli_fetch_assoc($edit_result);
    }
}

// Update Product
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $category_name = $_POST['product_name'];
    $products = $_POST['category'];
    $price = $_POST['price'];
    
    if (empty($category_name) || empty($products) || empty($price)) {
        $error = "All fields are required!";
    } else {
        $sql = "UPDATE categories SET category_name='$category_name', products='$products', price='$price' WHERE id='$product_id'";
        if (mysqli_query($conn, $sql)) {
            $success = "Category updated successfully!";
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
    $category_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $products = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    if (empty($category_name) || empty($products) || empty($price)) {
        $error = "All fields are required!";
    } else {
        $sql = "INSERT INTO categories (category_name, products, price) VALUES ('$category_name', '$products', '$price')";
        if (mysqli_query($conn, $sql)) {
            $success = "Product added successfully!";
            header("Location: seller_dashboard.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch Products
$result = mysqli_query($conn, "SELECT * FROM categories");
if (!$result) {
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE 1=0"); // Empty result
}

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
                <li class="navlist"><?php if(isset($_COOKIE['remember_user'])) { echo '<a href="../../../Admin/Control/index.php">Home</a>'; } else { echo 'Home'; } ?></li>
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
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { 
                                $formatted_id = str_pad($row['id'], 3, '0', STR_PAD_LEFT);
                                echo '<tr>';
                                echo '<td>#' . $formatted_id . '</td>';
                                echo '<td>' . $row['category_name'] . '</td>';
                                echo '<td>' . $row['products'] . '</td>';
                                echo '<td>$' . $row['price'] . '</td>';
                                echo '<td><span class="status-badge status-active">Active</span></td>';
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
    <div id="profileModal" class="modal show">
        <div class="modal-content">
            <div class="modal-header">
                <h2>My Profile</h2>
                <a href="seller_dashboard.php" style="text-decoration: none;">
                    <span class="close">&times;</span>
                </a>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="seller_name">Seller Name:</label>
                        <input type="text" id="seller_name" name="username" value="<?php echo htmlspecialchars($profile['username'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="seller_dashboard.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <button type="submit" name="update_profile" class="btn-submit">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($show_edit_form && $edit_product): ?>
    <!-- Edit Product Form -->
    <div id="categoryModal" class="modal show">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Category</h2>
                <a href="seller_dashboard.php" style="text-decoration: none;">
                    <span class="close">&times;</span>
                </a>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="<?php echo $edit_product['id']; ?>">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" id="category_name" name="product_name" value="<?php echo htmlspecialchars($edit_product['category_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="products">Products:</label>
                        <input type="text" id="products" name="category" value="<?php echo htmlspecialchars($edit_product['products']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" step="0.01" id="price" name="price" value="<?php echo $edit_product['price']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="seller_dashboard.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <button type="submit" name="update_product" class="btn-submit">Update Category</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($show_add_form): ?>
    <!-- Add Product Form -->
    <div id="categoryModal" class="modal show">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Category</h2>
                <a href="seller_dashboard.php" style="text-decoration: none;">
                    <span class="close">&times;</span>
                </a>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" id="category_name" name="product_name" placeholder="Enter category name" required>
                    </div>
                    <div class="form-group">
                        <label for="products">Products:</label>
                        <input type="text" id="products" name="category" placeholder="Enter products" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" step="0.01" id="price" name="price" placeholder="Enter price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="seller_dashboard.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <button type="submit" name="add_product" class="btn-submit">Add Category</button>
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



