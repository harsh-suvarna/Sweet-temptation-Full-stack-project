<?php
include ('../components/ordconn.php'); // Make sure the database connection is correct

// Get total orders
$order_result = $conn->query("SELECT COUNT(id) AS total_orders FROM orders");
$order_data = $order_result->fetch_assoc();
$total_orders = $order_data['total_orders'];

// Get total revenue
$revenue_result = $conn->query("SELECT SUM(total_amount) AS total_revenue FROM orders");
$revenue_data = $revenue_result->fetch_assoc();
$total_revenue = $revenue_data['total_revenue'];

// Get total customers (distinct names)
$customer_result = $conn->query("SELECT COUNT(DISTINCT customer_name) AS total_customers FROM orders");
$customer_data = $customer_result->fetch_assoc();
$total_customers = $customer_data['total_customers'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ice Cream Shop</title>
    
    <link rel="stylesheet" href="../css/admin.css">
    <style>
    .stats {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 60px;
}

.card {
    font-weight: bold;
    font-family: 'Times New Roman', Times, serif;
    background-color:rgba(236, 236, 236, 0.92); ;
    padding: 60px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-size: 40px;
    text-align: center;
}

.card strong {
    display: block;
    font-size: 45px;
    margin-top: 8px;
    color: #333;
}

.half-width {
    flex: 1 1 calc(50% - 10px);
}

.full-width {
    flex: 1 1 100%;
}
.pincode{
    text-decoration:none;
    text-size:20px;
}

    </style>
</head>
<script>
    function logout() {
        alert("You have been logged out!");
        window.location.href = "../components/intro.html"; 
    }
</script>

<body>
    <div class="sidebar">
        <h2 style="color: rgb(26, 26, 27);">Admin Dashboard</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="http://localhost/highway_shop/admin_panel/admin.php">Add Products</a></li>
            <li><a href="products.php">Remove Product</a></li>
            <li><a href="view_messages.php">Customer Query</a></li>
            <li><a href="http://localhost/highway_shop/admin_panel/admin_users.php">Users</a></li>
            <li><a href="#" onclick="logout()">Logout</a></li>
           
        </ul>
    </div>

    <div class="main-content">
        <h1>Welcome, Admin</h1>
        <div class="stats">
    <div class="card">Total Orders: <strong><?php echo $total_orders; ?></strong></div>
    <div class="card">Revenue: <strong>₹<?php echo number_format($total_revenue, 2); ?></strong></div>
    <div class="card">Total Customers: <strong><?php echo $total_customers; ?></strong></div>
</div>

<!-- Manage Pincode Button Below Stats -->
<div style="margin-top: 40px;">
    <a href="manage_pincodes.php" 
       style="color: #0b5394; font-weight: bold; background-color: #e6f0ff; padding: 10px 18px; border-radius: 8px; display: inline-block; font-size: 24px; text-decoration: none;">
       Manage Pincodes
    </a>
</div>

    </div>
</body>
</html>
