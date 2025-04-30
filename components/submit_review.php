<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_id = $_POST['item_id'];
    $review = trim($_POST['review']);

    if (!empty($item_id) && !empty($review)) {
        $stmt = $conn->prepare("UPDATE order_items SET review = ? WHERE id = ?");
        $stmt->bind_param("si", $review, $item_id);
        $stmt->execute();
    }
}

header("Location: my_orders.php");
exit;
