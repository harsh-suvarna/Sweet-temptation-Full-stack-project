<?php
session_start();
include('ordconn.php'); // Assumes $conn is a valid mysqli connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['customer_name'];
    $phone = $_POST['customer_phone'];
    $address = $_POST['customer_address'];
    $payment_method = $_POST['payment_method'];
    $status = 'Pending'; // Default status

    $total = 0;
    $order_summary = [];

    foreach ($_SESSION['cart'] as $item) {
        $quantity = isset($item['quantity']) ? max(1, (int)$item['quantity']) : 1;
        $subtotal = $item['price'] * $quantity;
        $total += $subtotal;

        $order_summary[] = [
            'product_id' => $item['id'],
            'name'       => $item['name'],
            'price'      => $item['price'],
            'quantity'   => $quantity,
            'subtotal'   => $subtotal
        ];
    }

    // Save order with status
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, payment_method, total_amount, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $phone, $address, $payment_method, $total, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Save each item
    foreach ($order_summary as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdid", $order_id, $item['product_id'], $item['name'], $item['price'], $item['quantity'], $item['subtotal']);
        $stmt->execute();
    }

    // Clear cart
    $_SESSION['cart'] = [];

    // Show confirmation
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Order Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                padding: 30px;
                text-align: center;
            }
            .summary {
                background: white;
                padding: 30px;
                border-radius: 10px;
                max-width: 600px;
                margin: auto;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .summary h2 {
                color: green;
            }
            ul {
                list-style: none;
                padding: 0;
                margin: 20px 0;
                text-align: left;
            }
            li {
                font-size: 18px;
                margin-bottom: 10px;
            }
            .back-btn {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 24px;
                background: black;
                color: white;
                text-decoration: none;
                border-radius: 6px;
            }
            .back-btn:hover {
                background-color: #333;
            }
        </style>
    </head>
    <body>
    <div class="summary">
        <h2>Thank you for your order, <?php echo htmlspecialchars($name); ?>!</h2>
        <p>We'll deliver your order to:</p>
        <p><?php echo nl2br(htmlspecialchars($address)); ?><br>Phone: <?php echo htmlspecialchars($phone); ?></p>

        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
        <p><strong>Order Status:</strong> <?php echo $status; ?></p>

        <h3>Order Summary:</h3>
        <ul>
            <?php foreach ($order_summary as $item): ?>
                <li><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?> = ₹<?php echo number_format($item['subtotal'], 2); ?></li>
            <?php endforeach; ?>
        </ul>
        <h3>Total Amount: ₹<?php echo number_format($total, 2); ?></h3>

        <a class="back-btn" href="index.php">Go to Home</a>
    </div>
    </body>
    </html><?php foreach ($_SESSION['cart'] as $item): ?>
        <li style="display: flex; align-items: center; margin-bottom: 15px;">
            <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 6px;">
            <span><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?> = ₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
        </li>
    <?php endforeach; ?>
    <?php
    exit;
}
?>