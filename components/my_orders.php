<?php
session_start();
include('database.php');

$user_id = $_SESSION['id']; // assuming user_id is stored in session after login

$sql = "
    SELECT * 
    FROM order_items 
    WHERE order_id IN (
        SELECT id FROM orders WHERE user_id = ?
    )
    ORDER BY id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Group items by order_id
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['order_id']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-size: 25px;
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background: rgba(163, 159, 163, 0.59);
        }

        .sidebar {
            width: 250px;
            background-color: rgba(58, 56, 57, 0.66);
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 70%;
        }

        .sidebar a {
            display: block;
            color: white;
            margin-left:70px;
            padding: 12px;
            text-decoration: none;
            margin: 15px ;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color:rgb(253, 154, 220);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .order-card {
            margin: 0 auto 20px auto;
            width: 80%;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .order-details {
            flex: 1;
        }

        .order-details p {
            font-size: 18px;
            margin: 8px 0;
        }

        .product-item {
            display: flex;
            gap: 15px;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .product-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
        }

        .status {
            font-weight: bold;
            color: green;
        }

        .cancel-btn, .review-btn {
            margin-top: 10px;
            background: crimson;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .cancel-btn:hover {
            background: darkred;
        }

        .review-form {
            margin-top: 10px;
        }

        .review-form textarea {
            width: 80%;
            height: 60px;
            padding: 8px;
            border-radius: 6px;
        }

        .review-form button {
            margin-top: 5px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .review-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Menu</h2>
    <a href="index.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="cart.php">Cart</a>
    <a href="support.php">Support</a>
</div>

<div class="main-content">
    <h2>My Orders</h2>

    <?php foreach ($orders as $order_id => $items): ?>
        <div class="order-card">
            <div class="order-details">
                <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>

                <?php foreach ($items as $item): ?>
                    <div class="product-item">
                        <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image">
                        <div>
                            <p><strong>Product:</strong> <?php echo htmlspecialchars($item['name']); ?></p>
                            <p><strong>Price:</strong> ₹<?php echo number_format($item['price'], 2); ?></p>
                            <p><strong>Status:</strong> <span class="status"><?php echo htmlspecialchars($item['status']); ?></span></p>
                            <p><strong>Subtotal:</strong> ₹<?php echo number_format($item['subtotal'], 2); ?></p>

                            <?php if ($item['status'] === 'Delivered'): ?>
                                <?php if (empty($item['review'])): ?>
                                    <form method="POST" action="submit_review.php" class="review-form">
                                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                        <textarea name="review" placeholder="Write your review..." required></textarea>
                                        <button type="submit">Submit Review</button>
                                    </form>
                                <?php else: ?>
                                    <p><strong>Your Review:</strong> <?php echo htmlspecialchars($item['review']); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php
                    $hasDeliveredItem = false;
                    foreach ($items as $itm) {
                        if ($itm['status'] === 'Delivered') {
                            $hasDeliveredItem = true;
                            break;
                        }
                    }
                ?>
                <?php if ($hasDeliveredItem): ?>
                    <form method="POST" action="download_invoice.php" target="_blank" style="margin-top: 10px;">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <button type="submit" class="review-btn" style="background-color:#007bff;">Download Invoice</button>
                    </form>
                <?php endif; ?>

                <?php
                    $isCancellable = false;
                    foreach ($items as $itm) {
                        if ($itm['status'] !== 'Delivered' && $itm['status'] !== 'Cancelled') {
                            $isCancellable = true;
                            break;
                        }
                    }
                ?>

                <?php if ($isCancellable): ?>
                    <div id="cancel-container-<?php echo $order_id; ?>">
                        <form onsubmit="cancelOrder(event, <?php echo $order_id; ?>)">

                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <button type="submit" class="cancel-btn">Cancel Order</button>
                        </form>
                        <p id="timer-<?php echo $order_id; ?>" style="color:red; font-size:18px;">
                            Time left to cancel: <span id="count-<?php echo $order_id; ?>">120</span> seconds
                        </p>
                    </div>

                    <script>
                      (function() {
    const orderId = "<?php echo $order_id; ?>";
    const key = "cancel_timer_" + orderId; // unique key for this order's timer
    const cancelContainer = document.getElementById("cancel-container-" + orderId);
    const countSpan = document.getElementById("count-" + orderId);
    const now = Math.floor(Date.now() / 1000);  // current timestamp in seconds

    let endTime = localStorage.getItem(key);
    
    // If no end time is found, set it to 120 seconds from now
    if (!endTime) {
        endTime = now + 120;
        localStorage.setItem(key, endTime);
    }

    const interval = setInterval(() => {
        const currentTime = Math.floor(Date.now() / 1000);
        const timeLeft = endTime - currentTime;

        if (timeLeft <= 0) {
            clearInterval(interval); // stop the timer

            // Update the message in the cancel container
            cancelContainer.innerHTML = `
                <p style="color:red; font-size:18px;">
                    Order can no longer be cancelled. If you still wish to cancel, please 
                    <a href='support.php' style='color:blue; text-decoration:underline;'>contact customer care</a>.
                </p>
            `;
            // Optionally, you can disable the cancel button if desired:
            // cancelContainer.querySelector('button').disabled = true;
        } else {
            countSpan.textContent = timeLeft; // Update the countdown timer
        }
    }, 1000);  // Update the timer every second
})();


                    </script>
                    <script>
function cancelOrder(event, orderId) {
    event.preventDefault(); // stop form from submitting normally

    if (confirm("Are you sure you want to cancel this order?")) {
        fetch('cancel_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'order_id=' + encodeURIComponent(orderId)
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show popup
            location.reload(); // Reload to update status visually
        })
        .catch(error => {
            alert("An error occurred: " + error);
        });
    }
}
</script>

                    
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
