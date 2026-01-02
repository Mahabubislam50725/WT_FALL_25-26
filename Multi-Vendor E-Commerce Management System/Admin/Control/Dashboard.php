<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/dashboard.css">
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
           <h1 style="text-align:center;git ">Admin dashboard</h1>
            <h2 style="margin-top: 40px;">Manage Sellers</h2>
            <button class="btn btn-primary" style="margin-bottom: 20px;">Add New Seller</button>
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
                        <tr>
                            <td>#001</td>
                            <td>Tech Store BD</td>
                            <td>techstore@example.com</td>
                            <td>45</td>
                            <td><span class="status-badge status-delivered">Active</span></td>
                            <td>
                                <button class="action-btn edit-btn">Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Fashion Hub</td>
                            <td>fashion@example.com</td>
                            <td>78</td>
                            <td><span class="status-badge status-delivered">Active</span></td>
                            <td>
                                <button class="action-btn edit-btn">Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

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
         </div>
            </div>
            <h2 style="margin-top: 40px;">Manage Customer</h2>
            <button class="btn btn-primary" style="margin-bottom: 20px;">Add New Customer</button>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Tech Store BD</td>
                            <td>techstore@example.com</td>
                            <td>45</td>
                            <td>
                                <button class="action-btn edit-btn">Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Fashion Hub</td>
                            <td>fashion@example.com</td>
                            <td>78</td>
                            <td>
                                <button class="action-btn edit-btn">Edit</button>
                                <button class="action-btn delete-btn">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

    </div>
    </div>
</body>
</html>