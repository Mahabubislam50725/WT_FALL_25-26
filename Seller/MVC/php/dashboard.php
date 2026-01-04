<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
   
    
</head>
<body>
    <button class="logout" type="submit" name="logout">Logout</button>
     <!-- dashboard -->
    <div class="dashboard">

        <div class="header">
            <h2>Seller Dashboard</h2>
            <button class="Add-Products-btn"> +Add Product</button>
        
        </div>

     <!--cards-->
     <div class ="cards">
          <div class="card">
                <h4>Total Sales</h4>
                <p>$0</p>
            </div>

          <div class="card">  
                <h4>Active Products</h4>
                <p>0</p>
            </div>

           <div class="card"> 
                <h4>Pending Orders</h4>
                <p>0</p>
            </div>
    </div>
    <div class="click">
    <div>
    <button class="Add-My-Product-btn">My Product</button>
    <button class="Add-orders-btn">Orders</button>
    </div>
    </div>

<!--product info--> 



<div>  
  <div class="product-info">
    <div class="images-Box">
         <img width="500" src="../images/Watch.jpg">
    </div>
                    Smart Watches Price:
                    <span  class="price" >$100.00</span>
                    <div class="stock">Stock: 100</div>

                    <div class="actions">
                       <button type="submit"  name="edit">Edit</button>
                       <button type="submit"  name="save">Save</button>
                <button type="submit" name="delete">Delete</button>
                    </div>
    </div>     

    <div>

    <div class="product-info">
        <div class="images-Box">  
                <img width="300" src="../images/Denim.webp">
        </div>
                    Denim Jacket's Price:
                    <span  class="price" >$500.00</span>
                    <div class="stock">Stock: 50</div>

                    <div class="actions">
                        <button type="submit "  name="edit">Edit</button>
                       <button type="submit"  name="save">Save</button>
                <button type="submit" name="delete">Delete</button>
                    </div>
    </div>
    </div>

  

</body>
</html>