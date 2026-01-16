

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
