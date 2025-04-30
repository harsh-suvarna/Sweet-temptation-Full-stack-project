<?php
session_start();
include '../db.php';

$result = $conn->query("SELECT * FROM products WHERE category = 'dessert'");

// Check user login
$user_id = $_SESSION['id'] ?? null;
$user_email = $_SESSION['email'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ice Creams</title>
    <style>
        body {
            background-image: url('../images/ice-bg.jpg'); 
            font-family: Arial, sans-serif;
            background-color: rgb(245, 174, 235);
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .navbar {
            border-radius: 40px;
            margin-bottom: 20px;
            height: 60px;
            background-color: rgba(243, 121, 206, 0.84);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
        }

        .navbar a:hover {
            color: rgba(90, 86, 86, 0.74);
            background-color: rgba(243, 217, 234, 0.8);
            border-radius: 5px;
        }

        .navbar h2 {
            flex: 1;
            text-align: center;
            margin: 0;
            font-size: 50px;
            color: rgba(76, 71, 71, 0.97);
        }

        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product {
            background-color: rgba(216, 207, 207, 0.8);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .product img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product p {
            font-family: 'Times New Roman', Times, serif;
            font-size: 30px;
            color: rgb(34, 33, 33);
            margin: 20px 0;
        }

        .price {
            font-weight: bold;
            color: #ff5733;
        }

        .cart {
            background-color: rgb(211, 102, 102);
            cursor: pointer;
            font-weight: bold;
            margin-top: 9px;
            padding: 5px;
            font-size: 20px;
            border-radius: 8px;
            border: none;
            color: white;
        }

        .cart:hover {
            background-color: rgb(160, 127, 149);
        }

        .back-arrow {
            font-weight: bold;
            text-decoration: none;
            font-size: 20px;
            color: white;
            padding: 7px;
            border: 1px solid white;
            border-radius: 9px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .back-arrow:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }

        /* Toast Message */
        .msg {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #d4edda;
            color: #155724;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            font-weight: bold;
            font-size: 18px;
            animation: fadeOut 1s ease-in-out 1s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="index.php" class="back-arrow">&larr; Back</a>
        <h2>Taste our Icecreams now</h2>
        <a href="cart.php">Cart 🛒</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div id="cart-msg" class="msg">Item added to cart!</div>
    <?php endif; ?>

    <div class="container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product">
                <img src="../<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <p class="price"><?php echo $row['name'] . " - ₹" . $row['price']; ?></p>

                <?php if ($user_id): ?>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="redirect" value="desserts.php">
                        <button type="submit" class="cart">Add to Cart</button>
                    </form>
                <?php else: ?>
                    <p style="color:red;">Please <a href="login.php">login</a> to add items to cart.</p>
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>

    <script>
        // Remove message from DOM after 2 seconds
        setTimeout(() => {
            const msg = document.getElementById('cart-msg');
            if (msg) {
                msg.remove();
            }
        }, 2000);
    </script>

</body>
</html>
