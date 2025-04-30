<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_item_id']) && isset($_POST['status'])) {
    $status = $_POST['status'];
    $item_id = (int)$_POST['order_item_id']; // Get single ID as integer

    $stmt = $conn->prepare("UPDATE order_items SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $item_id);
    $stmt->execute();
}

header("Location: orders.php");
exit;
