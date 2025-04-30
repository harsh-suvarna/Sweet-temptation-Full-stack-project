<?php
include('../components/ordconn.php'); 
session_start();

// Optional: Admin login check
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: admin_login.php');
//     exit();
// }

// Handle delete action
if (isset($_GET['delete_review_id'])) {
    $review_id = (int)$_GET['delete_review_id'];
    $stmt = $conn->prepare("UPDATE order_items SET review = NULL WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $message = "Review deleted successfully.";
}

// Fetch reviews
$sql = "
    SELECT oi.id, oi.review, o.customer_name, o.created_at
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    WHERE oi.review IS NOT NULL AND oi.review != ''
    ORDER BY o.created_at DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .review-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            width: 70%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .review-card h4 {
            margin: 0 0 8px;
        }

        .review-card p {
            font-size: 17px;
            margin-bottom: 12px;
        }

        .delete-btn {
            background: crimson;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: darkred;
        }

        .message {
            color: green;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Manage Customer Reviews</h2>

    <?php if (isset($message)): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <?php while($row = $result->fetch_assoc()): ?>
        <div class="review-card">
            <h4><?= htmlspecialchars($row['customer_name']) ?> — <?= date("F j, Y", strtotime($row['created_at'])) ?></h4>
            <p><?= htmlspecialchars($row['review']) ?></p>
            <a href="?delete_review_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this review?')">Delete Review</a>
        </div>
    <?php endwhile; ?>

</body>
</html>
