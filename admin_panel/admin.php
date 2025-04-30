<?php
include '../db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

   
    $targetDir = __DIR__ . "/../uploads/";  
    
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $imageName; 
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    
    $allowedTypes = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            
            $relativePath = "uploads/" . time() . "_" . $imageName; 
            $sql = "INSERT INTO products (name, price, category, image) 
                    VALUES ('$name', '$price', '$category', '$relativePath')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Product added successfully!</p>";
            } else {
                echo "<p class='error'>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error'>Error uploading image.</p>";
        }
    } else {
        echo "<p class='error'>Invalid file type. Only JPG, JPEG, PNG & GIF are allowed.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Add Product</title>
</head>
<style>
    
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}


body {
    background-color: #f8f9fa;
    display: flex;
    flex-direction:column;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


.container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
}


h2 {
    color: #333;
    margin-bottom: 15px;
}


label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
    text-align: left;
}


input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}


input[type="file"] {
    padding: 5px;
    background-color: #fff;
    border: none;
}


button {
    width: 100%;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    margin-top: 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}


button:hover {
    background-color: #0056b3;
}


.success {
    color: green;
    font-weight: bold;
}

.error {
    color: red;
    font-weight: bold;
}

</style>
<body>
    <h2>Add a Product</h2>
    <form class="container" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Category:</label>
        <select name="category">
            <option value="icecream">Ice Cream</option>
            <option value="dessert">Dessert</option>
            <option value="milkshake">Milkshake</option>
        </select><br><br>

        <label>Image:</label>
        <input type="file" name="image" required><br><br>

        <button type="submit">Add Product</button>
        <a href="admin_dashboard.php">Go Back</a>
    </form>
    
</body>
</html>
