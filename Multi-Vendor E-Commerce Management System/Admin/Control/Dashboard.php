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
$showSellerModal = false;
$showCustomerModal = false;

/* ADD SELLER */
if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    if (empty($username) || empty($password) || empty($email)) {
        $error = "All fields are required!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, role) 
                VALUES ('$username', '$hashedPassword', '$email', '$role')";
        if (mysqli_query($conn, $sql)) {
            $success = "Seller added successfully!";
        } else {
            $error = mysqli_error($conn);
        }
    }
}

/* UPDATE SELLER */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $success = "Seller updated successfully!";
    } else {
        $error = mysqli_error($conn);
    }
}

/* DELETE SELLER */
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    $success = "Seller deleted successfully!";
}

/* FETCH SELLER FOR EDIT */
$editSeller = null;
if (isset($_POST['edit'])) {
    $id = $_POST['edit'];
    $result_edit = mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='Seller'");
    $editSeller = mysqli_fetch_assoc($result_edit);
    $showSellerModal = true;
}

/* CHECK IF ADD SELLER BUTTON CLICKED */
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $showSellerModal = true;
}

/* ADD CUSTOMER */
if (isset($_POST['addcustomer'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    if (empty($username) || empty($password) || empty($email)) {
        $error = "All fields are required!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, role) 
                VALUES ('$username', '$hashedPassword', '$email', '$role')";
        if (mysqli_query($conn, $sql)) {
            $success = "Customer added successfully!";
        } else {
            $error = mysqli_error($conn);
        }
    }
}

/* UPDATE CUSTOMER */
if (isset($_POST['updatecustomer'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $success = "Customer updated successfully!";
    } else {
        $error = mysqli_error($conn);
    }
}

/* DELETE CUSTOMER */
if (isset($_POST['deletecustomer'])) {
    $id = $_POST['deletecustomer'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    $success = "Customer deleted successfully!";
}

/* FETCH CUSTOMER FOR EDIT */
$editCustomer = null;
if (isset($_POST['editcustomer'])) {
    $id = $_POST['editcustomer'];
    $result_edit_customer = mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='Customer'");
    $editCustomer = mysqli_fetch_assoc($result_edit_customer);
    $showCustomerModal = true;
}

/* CHECK IF ADD CUSTOMER BUTTON CLICKED */
if (isset($_POST['actioncustomer']) && $_POST['actioncustomer'] == 'add') {
    $showCustomerModal = true;
}

/* FETCH SELLERS */
$result = mysqli_query($conn, "SELECT * FROM users WHERE role='Seller'");

/* FETCH CUSTOMERS */
$customerResult = mysqli_query($conn, "SELECT * FROM users WHERE role='Customer'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="stylesheet" href="../CSS/add_seller.css">
    <title>Admin dashboard</title>
</head>
<body>
    <div class="maindiv">
        <div class="adminNav">
            <h1>🛒 Multi-Vendor E-Commerce</h1>
            <ul class="nav">
                <li class="navlist">Home</li>
                <li class="navlist">View Order</li>
                <li class="navlist">Sales Report</li>
                <li><a href="../View/logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>

        <div class="adminBody">
            <h1 style="text-align:center;">Admin dashboard</h1>
            
            <?php 
            if ($success) {
                echo '<div class="alert alert-success">' . $success . '</div>';
            }
            ?>
            
            <?php 
            if ($error) {
                echo '<div class="alert alert-error">' . $error . '</div>';
            }
            ?>
            
            <h2 style="margin-top: 40px;">Manage Sellers</h2>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Add New Seller</button>
            </form>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Products</th>
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
                                echo '<td>' . $row['username'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>0</td>';
                                echo '<td><span class="status-badge status-delivered">Active</span></td>';
                                echo '<td>';
                                echo '<form method="POST" style="display: inline;">';
                                echo '<input type="hidden" name="edit" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="action-btn edit-btn">Edit</button>';
                                echo '</form>';
                                echo '<form method="POST" style="display: inline;" onsubmit="return confirm(\'Are you sure you want to delete this seller?\')">';
                                echo '<input type="hidden" name="delete" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="action-btn delete-btn">Delete</button>';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <h2 style="margin-top: 40px;">Product Categories</h2>
            <button class="btn btn-primary" style="margin-bottom: 20px;">Add New Category</button>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Electronics</td>
                            <td>234</td>
                            <td>
                                <button class="action-btn edit-btn">Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Fashion</td>
                            <td>456</td>
                            <td>
                                <button class="action-btn edit-btn">Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 style="margin-top: 40px;">Manage Customer</h2>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="actioncustomer" value="add">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Add New Customer</button>
            </form>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Orders</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($customerResult) > 0) {
                            while ($row = mysqli_fetch_assoc($customerResult)) { 
                                $formatted_id = str_pad($row['id'], 3, '0', STR_PAD_LEFT);
                                echo '<tr>';
                                echo '<td>#' . $formatted_id . '</td>';
                                echo '<td>' . $row['username'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>0</td>';
                                echo '<td>';
                                echo '<form method="POST" style="display: inline;">';
                                echo '<input type="hidden" name="editcustomer" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="action-btn edit-btn">Edit</button>';
                                echo '</form>';
                                echo '<form method="POST" style="display: inline;" onsubmit="return confirm(\'Are you sure you want to delete this customer?\')">';
                                echo '<input type="hidden" name="deletecustomer" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="action-btn delete-btn">Delete</button>';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Seller Modal -->
    <?php 
    if ($showSellerModal) {
        $modalClass = "modal show";
    } else {
        $modalClass = "modal";
    }
    ?>
    <div id="sellerModal" class="<?php echo $modalClass; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if ($editSeller) {
                    echo '<h2>Edit Seller</h2>';
                } else {
                    echo '<h2>Add New Seller</h2>';
                }
                ?>
                <a href="Dashboard.php" style="text-decoration: none;">
                    <span class="close">&times;</span>
                </a>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <?php 
                    if ($editSeller) {
                        echo '<input type="hidden" name="id" value="' . $editSeller['id'] . '">';
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <?php 
                        if ($editSeller) {
                            $username_value = $editSeller['username'];
                        } else {
                            $username_value = '';
                        }
                        ?>
                        <input type="text" id="username" name="username" placeholder="Enter seller username" value="<?php echo $username_value; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <?php 
                        if ($editSeller) {
                            $email_value = $editSeller['email'];
                        } else {
                            $email_value = '';
                        }
                        ?>
                        <input type="email" id="email" name="email" placeholder="Enter seller email" value="<?php echo $email_value; ?>" required>
                    </div>
                    
                    <?php 
                    if (!$editSeller) {
                        echo '<div class="form-group">';
                        echo '<label for="password">Password:</label>';
                        echo '<input type="password" id="password" name="password" placeholder="Enter password" required>';
                        echo '</div>';
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <input type="text" id="role" name="role" value="Seller" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="Dashboard.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <?php 
                    if ($editSeller) {
                        echo '<button type="submit" name="update" class="btn-submit">Update Seller</button>';
                    } else {
                        echo '<button type="submit" name="add" class="btn-submit">Add Seller</button>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Add/Edit Customer Modal -->
    <?php 
    if ($showCustomerModal) {
        $customerModalClass = "modal show";
    } else {
        $customerModalClass = "modal";
    }
    ?>
    <div id="customerModal" class="<?php echo $customerModalClass; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if ($editCustomer) {
                    echo '<h2>Edit Customer</h2>';
                } else {
                    echo '<h2>Add New Customer</h2>';
                }
                ?>
                <a href="Dashboard.php" style="text-decoration: none;">
                    <span class="close">&times;</span>
                </a>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <?php 
                    if ($editCustomer) {
                        echo '<input type="hidden" name="id" value="' . $editCustomer['id'] . '">';
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="customer_username">Username:</label>
                        <?php 
                        if ($editCustomer) {
                            $customer_username_value = $editCustomer['username'];
                        } else {
                            $customer_username_value = '';
                        }
                        ?>
                        <input type="text" id="customer_username" name="username" placeholder="Enter customer username" value="<?php echo $customer_username_value; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email:</label>
                        <?php 
                        if ($editCustomer) {
                            $customer_email_value = $editCustomer['email'];
                        } else {
                            $customer_email_value = '';
                        }
                        ?>
                        <input type="email" id="customer_email" name="email" placeholder="Enter customer email" value="<?php echo $customer_email_value; ?>" required>
                    </div>
                    
                    <?php 
                    if (!$editCustomer) {
                        echo '<div class="form-group">';
                        echo '<label for="customer_password">Password:</label>';
                        echo '<input type="password" id="customer_password" name="password" placeholder="Enter password" required>';
                        echo '</div>';
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="customer_role">Role:</label>
                        <input type="text" id="customer_role" name="role" value="Customer" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="Dashboard.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <?php 
                    if ($editCustomer) {
                        echo '<button type="submit" name="updatecustomer" class="btn-submit">Update Customer</button>';
                    } else {
                        echo '<button type="submit" name="addcustomer" class="btn-submit">Add Customer</button>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

<?php
mysqli_close($conn);
?>