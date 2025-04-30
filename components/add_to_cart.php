<?php
include '../db.php';
session_start();

$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_POST['product_image'];
$redirect = $_POST['redirect'];

// Check if item already exists
$check_stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$check_stmt->bind_param("ii", $user_id, $product_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity
    $update_stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $update_stmt->bind_param("ii", $user_id, $product_id);
    $update_stmt->execute();
} else {
    // Insert new item
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, name, price, image, quantity) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("iisds", $user_id, $product_id, $product_name, $product_price, $product_image);
    $stmt->execute();
}

header("Location: $redirect?success=1");
exit();
?>
