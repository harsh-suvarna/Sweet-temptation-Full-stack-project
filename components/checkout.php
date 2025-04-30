<?php
session_start();
include('database.php');

// Check if user is logged in
$user_id = $_SESSION['id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

// ---------- PROCESS ORDER IF POST (AJAX) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_name'])) {
    $name = $_POST['customer_name'];
    $phone = $_POST['customer_phone'];
    $address = $_POST['customer_address'];
    $pincode = $_POST['pincode'];
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];

    // Check pincode
    $checkPin = $conn->prepare("SELECT * FROM allowed_pincodes WHERE pincode = ?");
    $checkPin->bind_param("s", $pincode);
    $checkPin->execute();
    $pinResult = $checkPin->get_result();

    if ($pinResult->num_rows == 0) {
        header('Content-Type: text/plain');
        echo "Sorry, we don't deliver to this pincode.";
        exit();
    }
    

    // Insert order
    $orderStmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, phone,address, payment_method, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $orderStmt->bind_param("issssd", $user_id, $name, $phone, $address, $payment_method, $total_amount);
    $orderStmt->execute();
    $order_id = $orderStmt->insert_id;

    // Insert order items
    $cartItems = $conn->prepare("SELECT name, price, quantity, image FROM cart WHERE user_id = ?");
    $cartItems->bind_param("i", $user_id);
    $cartItems->execute();
    $itemsResult = $cartItems->get_result();

    while ($item = $itemsResult->fetch_assoc()) {
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $subtotal = $price * $quantity;
    
        $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, name, price, quantity, image, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        $itemStmt->bind_param("isdiss", $order_id, $item['name'], $price, $quantity, $item['image'], $subtotal);
        $itemStmt->execute();
    }
    

    // Clear cart
    $clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear->bind_param("i", $user_id);
    $clear->execute();

    echo "OK";
    exit;
}

// ---------- CONTINUE TO PAGE RENDERING (GET only) ----------

// Fetch user details
$user_name = $user_phone = $user_address = "";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT name, phone, address FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_name, $user_phone, $user_address);
    $stmt->fetch();
    $stmt->close();
}
?>

<!-- YOUR HTML STARTS HERE (AFTER PHP LOGIC) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <style>
         <>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(240, 240, 240);
            padding: 20px;
        }

        h2 {
            font-size: 40px;
            margin-bottom: 20px;
            text-align: center;
        }

        .checkout-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .item-row {
            margin-bottom: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 6px;
        }

        .submit-btn {
            background-color: black;
            color: white;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            margin-bottom:20px;
        }

        .submit-btn:hover {
            background-color: #444;
        }

        .total-amount {
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }
        .editDetails{
            margin-bottom:30px;

        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            text-align: center;
            border-radius: 6px;
            font-size: 18px;
            display: none;
            margin-top: 20px;
        }
        .small-btn {
    background-color: #007BFF;
    color: white;
    padding: 6px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.small-btn:hover {
    background-color: #0056b3;
}

    
    </style>
</head>
<body>
<div id="floatingError" style="display:none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
 background: #f44336; color: white; padding: 12px 20px; border-radius: 5px; z-index: 999;">
</div>
<h2>Checkout</h2>

<div class="checkout-container">
    <h3>Products</h3>

    <?php
    $total = 0;
    $items = [];

    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($item = $result->fetch_assoc()):
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $subtotal = $price * $quantity;
        $total += $subtotal;
        $imagePath = isset($item['image']) ? $item['image'] : 'default.jpg';
    ?>
        <div class="item-row" style="display: flex; align-items: center;">
            <img src="../<?php echo htmlspecialchars($imagePath); ?>" alt="Product Image" style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px; margin-right: 15px;">
            <div>
                <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                Price: ₹<?php echo number_format($price, 2); ?><br>
                Quantity: <?php echo $quantity; ?><br>
                Subtotal: ₹<?php echo number_format($subtotal, 2); ?><br>

            </div>
        </div>
    <?php endwhile; ?>

    <form id="orderForm">
 <div id="viewDetails">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="form-group">
        <div>
            <label>Name:</label>
            <div id="staticName"><?php echo htmlspecialchars($user_name); ?></div>
        </div>
        <button type="button" onclick="toggleEdit(true)" class="small-btn">Change</button>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center;" class="form-group">
        <div>
            <label>Phone:</label>
            <div id="staticPhone"><?php echo htmlspecialchars($user_phone); ?></div>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: flex-start;" class="form-group">
        <div>
            <label>Address:</label>
            <div id="staticAddress"><?php echo htmlspecialchars($user_address); ?></div>
        </div>
    </div>
 </div>


<div id="editDetails" style="display: none;">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" name="customer_name" required value="<?php echo htmlspecialchars($user_name); ?>">
    </div>

    <div class="form-group">
        <label>Phone:</label>
        <input type="text" name="customer_phone" pattern="\d{10}" title="10-digit number" required value="<?php echo htmlspecialchars($user_phone); ?>">
    </div>

    <div class="form-group">
        <label>Address:</label>
        <textarea name="customer_address" required><?php echo htmlspecialchars($user_address); ?></textarea>
    </div>

    <button type="button" onclick="toggleEdit(false)" class="submit-btn" style="background-color: gray;">Cancel</button>
</div>


        <div class="form-group">
            <label>Pincode:</label>
            <input type="text" name="pincode" id="pincode" required pattern="\d{6}">
        </div>

        <div class="form-group">
            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option value="Cash on Delivery">Cash on Delivery</option>
                
            </select>
        </div>

        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">

        <div class="total-amount">Total: ₹<?php echo number_format($total, 2); ?></div>

        <button type="submit" class="submit-btn">Place Order</button>
    </form>

    <div class="success-message" id="successMessage">
        Thank you for ordering! We will deliver your item shortly.
    </div>
    <div class="success-message" id="errorMessage" style="background-color: #f8d7da; color: #721c24; display: none;">
</div>

</div>

<script>
document.getElementById('orderForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch('checkout.php', {
    method: 'POST',
    body: formData
})
.then(response => response.text())
.then(res => {
    console.log("Server response:", res); // 🔍 Debug log
    const trimmed = res.trim();

    if (trimmed === "OK") {
        document.getElementById("successMessage").style.display = "block";
        document.getElementById("orderForm").style.display = "none";

        setTimeout(() => {
            window.location.href = "my_orders.php";
        }, 2000);
    } else {
        const floatErr = document.getElementById("floatingError");
        floatErr.innerText = trimmed;
        floatErr.style.display = "block";

        setTimeout(() => {
            floatErr.style.display = "none";
        }, 3000);
    }
});

});
</script>
<script>
function toggleEdit(showEdit) {
    document.getElementById("viewDetails").style.display = showEdit ? "none" : "block";
    document.getElementById("editDetails").style.display = showEdit ? "block" : "none";
}
</script>

</body>
</html>
