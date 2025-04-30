<?php
include('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = (int)$_POST['order_id'];

    // Fetch all items and order details
    $sql = "
        SELECT oi.*, o.customer_name, o.phone, o.address, o.created_at, o.total_amount
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        WHERE oi.order_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    $order_info = null;

    while ($row = $result->fetch_assoc()) {
        if (!$order_info) {
            $order_info = [
                'customer_name' => $row['customer_name'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'created_at' => $row['created_at'],
                'total_amount' => $row['total_amount']
            ];
        }
        $items[] = $row;
    }

    if (empty($items)) {
        die("Invalid order.");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #fff;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 2px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,.15);
        }
        h2 {
            text-align: center;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .print-btn {
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            display: block;
            background: #28a745;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            width: fit-content;
        }
    </style>
</head>
<body>

<div class="invoice-box" id="invoice">
    <h2>Invoice - Order #<?= $order_id ?></h2>
    <div class="info">
        <p><strong>Customer:</strong> <?= htmlspecialchars($order_info['customer_name']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($order_info['phone']); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($order_info['address']); ?></p>
        <p><strong>Date:</strong> <?= date("d M Y", strtotime($order_info['created_at'])); ?></p>
    </div>

    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td>₹<?= number_format($item['price'], 2); ?></td>
                <td><?= $item['quantity']; ?></td>
                <td>₹<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="total">Total Amount</td>
            <td><strong>₹<?= number_format($order_info['total_amount'], 2); ?></strong></td>
        </tr>
    </table>
</div>

<button onclick="window.print()" class="print-btn">🖨️ Print / Save as PDF</button>

</body>
</html>
