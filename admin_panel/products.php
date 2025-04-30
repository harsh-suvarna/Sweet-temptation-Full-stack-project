<?php
include '../db.php'; // your DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f4f4f4;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        img {
            height: 60px;
            border-radius: 4px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<h2>All Products (Admin Table View)</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price (₹)</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td><img src='../{$row['image']}' alt='{$row['name']}'></td>
                        <td>{$row['name']}</td>
                        <td>₹{$row['price']}</td>
                        <td>{$row['category']}</td>
                        <td>
                            <form action='delete_product.php' method='POST' onsubmit=\"return confirm('Are you sure you want to delete this product?');\">
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' class='delete-btn'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products available</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
