<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include '../Model/logindb.php';

$success = $error = "";
$showCategoryModal = false;

/* ADD CATEGORY */
if (isset($_POST['addcategory'])) {
    $category_name = $_POST['category_name'];
    $products = $_POST['products'];
    $price = $_POST['price'];
    
    if (empty($category_name) || empty($products) || empty($price)) {
        $error = "All fields are required!";
    } else {
        $sql = "INSERT INTO categories (category_name, products, price) VALUES ('$category_name', '$products', '$price')";
        if (mysqli_query($conn, $sql)) {
            $success = "Category added successfully!";
        } else {
            $error = mysqli_error($conn);
        }
    }
}

/* UPDATE CATEGORY */
if (isset($_POST['updatecategory'])) {
    $id = $_POST['id'];
    $category_name = $_POST['category_name'];
    $products = $_POST['products'];
    $price = $_POST['price'];
    
    $sql = "UPDATE categories SET category_name='$category_name', products='$products', price='$price' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $success = "Category updated successfully!";
    } else {
        $error = mysqli_error($conn);
    }
}

/* DELETE CATEGORY */
if (isset($_POST['deletecategory'])) {
    $id = $_POST['deletecategory'];
    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    $success = "Category deleted successfully!";
}

/* FETCH CATEGORY FOR EDIT */
$editCategory = null;
if (isset($_POST['editcategory'])) {
    $id = $_POST['editcategory'];
    $result_edit_category = mysqli_query($conn, "SELECT * FROM categories WHERE id=$id");
    $editCategory = mysqli_fetch_assoc($result_edit_category);
    $showCategoryModal = true;
}

/* CHECK IF ADD CATEGORY BUTTON CLICKED */
if (isset($_POST['actioncategory']) && $_POST['actioncategory'] == 'add') {
    $showCategoryModal = true;
}

$categoryResult = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/category.css">
    <title>Product Categories</title>
</head>
<body>
    <div class="maindiv">
        <div class="adminNav">
            <h1>🛒 Multi-Vendor E-Commerce</h1>
            <ul class="nav">
                <li class="navlist"><a href="Dashboard.php">Dashboard</a></li>
                <li class="navlist">View Order</li>
                <li class="navlist">Sales Report</li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>

        <div class="adminBody">
            <h1 style="text-align:center;">Product Categories</h1>
            
            <?php 
            if ($success) {
                echo '<div class="alert alert-success">' . $success . '</div>';
            }
            if ($error) {
                echo '<div class="alert alert-error">' . $error . '</div>';
            }
            ?>
            
            <form method="POST" style="display: inline;">
                <input type="hidden" name="actioncategory" value="add">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Add New Category</button>
            </form>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                            while ($row = mysqli_fetch_assoc($categoryResult)) { 
                                echo '<tr>';
                                echo '<td>' . $row['category_name'] . '</td>';
                                echo '<td>' . $row['products'] . '</td>';
                                echo '<td>$' . $row['price'] . '</td>';
                                echo '<td>';
                                echo '<form method="POST" style="display: inline;">';
                                echo '<input type="hidden" name="editcategory" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="action-btn edit-btn">Edit</button>';
                                echo '</form>';
                                echo '<form method="POST" style="display: inline;" onsubmit="return confirm(\'Are you sure you want to delete this category?\')">';
                                echo '<input type="hidden" name="deletecategory" value="' . $row['id'] . '">';
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

    <!-- Add/Edit Category Modal -->
    <?php 
    if ($showCategoryModal) {
        $categoryModalClass = "modal show";
    } else {
        $categoryModalClass = "modal";
    }
    ?>
    <div id="categoryModal" class="<?php echo $categoryModalClass; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if ($editCategory) {
                    echo '<h2>Edit Category</h2>';
                } else {
                    echo '<h2>Add New Category</h2>';
                }
                ?>
                <a href="category.php" style="text-decoration: none;">
                    <span class="close">&times;</span>
                </a>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <?php 
                    if ($editCategory) {
                        echo '<input type="hidden" name="id" value="' . $editCategory['id'] . '">';
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <?php 
                        if ($editCategory) {
                            $category_name_value = $editCategory['category_name'];
                        } else {
                            $category_name_value = '';
                        }
                        ?>
                        <input type="text" id="category_name" name="category_name" placeholder="Enter category name" value="<?php echo $category_name_value; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="products">Products:</label>
                        <?php 
                        if ($editCategory) {
                            $products_value = $editCategory['products'];
                        } else {
                            $products_value = '';
                        }
                        ?>
                        <input type="number" id="products" name="products" placeholder="Enter number of products" value="<?php echo $products_value; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <?php 
                        if ($editCategory) {
                            $price_value = $editCategory['price'];
                        } else {
                            $price_value = '';
                        }
                        ?>
                        <input type="number" step="0.01" id="price" name="price" placeholder="Enter price" value="<?php echo $price_value; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="category.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <?php 
                    if ($editCategory) {
                        echo '<button type="submit" name="updatecategory" class="btn-submit">Update Category</button>';
                    } else {
                        echo '<button type="submit" name="addcategory" class="btn-submit">Add Category</button>';
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
