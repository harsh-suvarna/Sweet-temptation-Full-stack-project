<?php
session_start();
include '../db.php';

$user_id = $_SESSION['id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Handle quantity update via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = max(1, intval($_POST['quantity']));

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
    $stmt->execute();

    $item_total = 0;
    $grand_total = 0;

    $result = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $result->bind_param("i", $user_id);
    $result->execute();
    $cart_result = $result->get_result();

    while ($item = $cart_result->fetch_assoc()) {
        if ($item['product_id'] == $product_id) {
            $item_total = $item['price'] * $item['quantity'];
        }
        $grand_total += $item['price'] * $item['quantity'];
    }

    echo json_encode([
        'item_total' => $item_total,
        'grand_total' => $grand_total
    ]);
    exit;
}

// Handle item removal
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $del = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $del->bind_param("ii", $user_id, $remove_id);
    $del->execute();
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <style>
body {
    font-size:20px;
    font-family: 'Times New Roman', Times, serif;
    font-weight:bold;
    margin: 0;
    padding: 20px;
    background-color: #f7f7f7;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.navbar {
    height: 40px;
    border-radius: 5px;
    background-color: rgb(238, 148, 215);
    padding: 10px 20px;
    text-align: left;
    color: white;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    margin: 0 15px;
    font-size: 18px;
    display: inline-block;
}

.nav-links a:hover {
    color: rgb(216, 215, 215);
}

h2 {
    font-size: 2.5em;
    color: #333;
    text-align: center;
    margin-top: 30px;
}

.cart-wrapper {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    flex-grow: 1;
}

.cart-container {
    width: 70%;
    margin-right: 20px;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.cart-item-header,
.cart-item.unified {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr 1fr 1fr 1fr;
    align-items: center;
    padding: 10px 15px;
    border-bottom: 1px solid #ddd;
}

.cart-item-header {
    font-weight: bold;
    background-color: #f7c1e0;
    color: #333;
    border-radius: 8px 8px 0 0;
}

.cart-item.unified img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.quantity-input {
    width: 60px;
    padding: 5px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.item-total {
    font-weight: bold;
    color: #ff4081;
}

.remove-btn {
    text-decoration: none;
    color: rgb(223, 218, 221);
    font-weight: bold;
    padding: 5px 10px;
    background-color: #fff;
    border: 2px solid rgb(240, 133, 231);
    border-radius: 5px;
    font-size: 14px;
}

.remove-btn:hover {
    background-color: rgb(255, 64, 245);
    color: white;
}

.summary {
    height: 40%;
    width: 25%;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    margin-top: 20px;
    margin-left: 70%;
}

.summary h3 {
    font-size: 2em;
    color: #333;
}

.summary p {
    font-size: 1.5em;
    color: #555;
    margin-bottom: 20px;
}

.place-order {
    width: 100%;
    padding: 15px;
    font-size: 1.2em;
    color: white;
    background-color: rgb(233, 159, 223);
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.place-order:hover {
    background-color: rgb(245, 152, 222);
}

@media (max-width: 768px) {
    .cart-wrapper {
        flex-direction: column;
    }

    .cart-container {
        width: 100%;
    }

    .summary {
        width: 100%;
        position: relative;
        margin-left: 0;
    }

    .cart-item-header,
    .cart-item.unified {
        grid-template-columns: 1fr 2fr 1fr;
        grid-template-rows: auto auto;
    }
}
    </style>
</head>
<body>

<div class="navbar">
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="my_orders.php">My Orders</a>
    </div>
</div>

<h2>Your Cart</h2>

<div class="cart-wrapper">
    <div class="cart-container">
        <?php
        $grand_total = 0;
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="cart-item-header">
                    <div>Image</div>
                    <div>Name</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Total</div>
                    <div>Action</div>
                  </div>';

            while ($item = $result->fetch_assoc()) {
                $item_total = $item['price'] * $item['quantity'];
                $grand_total += $item_total;
        ?>
            <div class="cart-item unified">
                <div><img src="../<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>"></div>
                <div><?php echo $item['name']; ?></div>
                <div>₹<?php echo $item['price']; ?></div>
                <div>
                    <input type="number"
                           class="quantity-input"
                           data-id="<?php echo $item['product_id']; ?>"
                           value="<?php echo $item['quantity']; ?>"
                           min="1">
                </div>
                <div>₹<span class="item-total" id="item-total-<?php echo $item['product_id']; ?>"><?php echo $item_total; ?></span></div>
                <div><a href="cart.php?remove=<?php echo $item['product_id']; ?>" class="remove-btn">Remove</a></div>
            </div>
        <?php
            }
        } else {
            echo "<p style='padding: 20px;'>Your cart is empty.</p>";
        }
        ?>
    </div>

    <?php if ($grand_total > 0) { ?>
    <div class="summary">
        <h3>Order Summary</h3>
        <p>Grand Total: ₹<span id="grand-total"><?php echo $grand_total; ?></span></p>
        <form action="checkout.php" method="GET">
            <button type="submit" class="place-order">Place your order</button>
        </form>
    </div>
    <?php } ?>
</div>

<script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function () {
        const productId = this.dataset.id;
        const newQty = parseInt(this.value);
        const xhr = new XMLHttpRequest();

        xhr.open("POST", "cart.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                document.getElementById(`item-total-${productId}`).innerText = response.item_total;
                document.getElementById("grand-total").innerText = response.grand_total;
            }
        };

        xhr.send(`update_quantity=1&product_id=${productId}&quantity=${newQty}`);
    });
});
</script>

</body>
</html>
