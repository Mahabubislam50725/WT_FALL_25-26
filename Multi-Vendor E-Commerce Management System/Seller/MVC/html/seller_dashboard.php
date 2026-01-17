

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
                        } else {
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
