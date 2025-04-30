<?php
session_start();
include('database.php');

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update the status of the order to "Cancelled"
    $sql = "UPDATE order_items SET status = 'Cancelled' WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order Cancelled";  // Success message
    } else {
        echo "Unable to cancel the order. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
