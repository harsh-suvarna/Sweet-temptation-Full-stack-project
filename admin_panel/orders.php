<?php
include('../components/ordconn.php'); 

// Handle review deletion
if (isset($_GET['delete_review_id'])) {
    $review_id = (int)$_GET['delete_review_id'];
    $stmt = $conn->prepare("UPDATE order_items SET review = NULL WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    header("Location: orders.php");
    exit;
}
$sql = "
    SELECT 
        o.id AS order_id,
        o.customer_name,
        o.phone,
        o.total_amount,
        o.created_at,
        oi.id AS order_item_id,
        oi.name AS product_name,
        oi.status,
        oi.review
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    ORDER BY o.created_at DESC
";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order List</title>
    <style>
        body { 
            font-size: 20px;
            background-image: url('../images/back-img.jpg'); 
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            background: rgb(238, 184, 229);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(236, 158, 213, 0.76);
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        td {
            color: rgba(57, 133, 60, 0.91);
        }

        th {
            background-color: rgba(231, 66, 184, 0.94);
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #222;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.2s ease;
        }

        .back-btn:hover {
            background-color: rgba(231, 66, 184, 0.94);
        }

        select {
            padding: 6px 10px;
            font-size: 16px;
            border-radius: 6px;
        }

        .review-box {
            display: flex;
            flex-direction: column;
            gap: 6px;
            max-width: 250px;
            word-wrap: break-word;
        }

        .review-text {
            font-style: italic;
            color: #444;
        }

        .delete-btn {
            background-color: crimson;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            align-self: flex-start;
            font-size: 14px;
            text-decoration: none;
        }

        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h2>All Orders</h2>
    <table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Product</th>
            <th>Total Amount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Review</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['order_id']; ?></td>
                    <td><?= htmlspecialchars($row['customer_name']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['product_name']); ?></td>
                    <td>₹<?= number_format($row['total_amount'], 2); ?></td>
                    <td><?= $row['created_at']; ?></td>
                    <td>
                        <form method="post" action="update_order_status.php">
                            <input type="hidden" name="order_item_id" value="<?= $row['order_item_id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <?php
                                $statuses = ['Pending', 'Preparing', 'Shipped', 'Delivered', 'Cancelled'];
                                foreach ($statuses as $status) {
                                    $selected = ($row['status'] === $status) ? 'selected' : '';
                                    echo "<option value=\"$status\" $selected>$status</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </td>
                    <td>
                        <?php if (!empty($row['review'])): ?>
                            <div class="review-box">
                                <div class="review-text"><?= htmlspecialchars($row['review']); ?></div>
                                <a href="?delete_review_id=<?= $row['order_item_id']; ?>" class="delete-btn" onclick="return confirm('Delete this review?')">Delete</a>
                            </div>
                        <?php else: ?>
                            <em>No review</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No orders found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html> 