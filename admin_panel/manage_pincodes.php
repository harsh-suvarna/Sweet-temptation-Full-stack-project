<?php
include('../components/ordconn.php');

// Add pincode
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pincode'])) {
    $pincode = trim($_POST['pincode']);
    if (!empty($pincode)) {
        $stmt = $conn->prepare("INSERT INTO allowed_pincodes (pincode) VALUES (?)");
        $stmt->bind_param("s", $pincode);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete pincode
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM allowed_pincodes WHERE id = $delete_id");
}

// Fetch existing pincodes
$pincodes = $conn->query("SELECT * FROM allowed_pincodes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pincodes</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { margin-bottom: 20px; }
        form { margin-bottom: 30px; }
        input[type="text"] {
            padding: 8px;
            font-size: 16px;
            width: 200px;
            margin-right: 10px;
        }
        button {
            padding: 8px 12px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 4px;
        }
        table { border-collapse: collapse; width: 50%; }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        a.delete {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Manage Allowed Pincodes</h2>

<form method="POST">
    <input type="text" name="pincode" placeholder="Enter new pincode" required>
    <button type="submit">Add Pincode</button>
</form>

<table>
    <tr>
        <th>Pincode</th>
        <th>Action</th>
    </tr>
    <?php while($row = $pincodes->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['pincode']); ?></td>
        <td><a class="delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this pincode?')">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
