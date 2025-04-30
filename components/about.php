<?php
include('database.php');

$sql = "
    SELECT o.customer_name, o.created_at, oi.review
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE oi.review IS NOT NULL AND oi.review != ''
    ORDER BY o.created_at DESC
    LIMIT 5
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sweet Treats</title>
    <link rel="stylesheet" href="../css/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

    <header>
        <nav>
            <img class="logo" src="../images/logice.png" alt="Sweet Treats Logo">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_orders.php">My Orders</a></li>
                <li><a href="about.php" class="active">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <h1>About Us</h1>
    </header>

    <section class="about">
        <div class="about-content">
            <h2>Welcome to Sweet Temptation!</h2>
            <p>At <strong>Sweet Temptation</strong>, we bring you the most delightful <strong>milkshakes, desserts, and ice creams</strong> made with love. Our mission is to provide a <strong>heavenly dessert experience</strong> with high-quality ingredients and creative flavors.</p>
            
            <p>From <strong>classic vanilla shakes</strong> to <strong>exotic sundaes</strong> and <strong>mouth-watering waffles</strong>, we craft every treat with passion and care. Whether you're a chocolate lover or a fruit enthusiast, we have something to satisfy your sweet cravings! 🍦🍩🍫</p>
        </div>
        <div class="about-image">
            <img class="imgshk" src="../images/desmilice.png" alt="Delicious Desserts">
        </div>
    </section>

    <section class="why-choose-us">
        <h2>Why Choose Us?</h2>
        <div class="features">
            <div class="feature">
                <i class="fas fa-ice-cream"></i>
                <h3>Premium Quality</h3>
                <p>We use fresh, natural ingredients to create our rich and flavorful desserts.</p>
            </div>
            <div class="feature">
                <i class="fas fa-heart"></i>
                <h3>Made with Love</h3>
                <p>Each product is crafted with care, ensuring the best experience in every bite.</p>
            </div>
            <div class="feature">
                <i class="fas fa-star"></i>
                <h3>Customer Satisfaction</h3>
                <p>We prioritize your happiness and guarantee top-notch service with every order.</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2>What Our Customers Say</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="testimonial">
                    <p>"<?php echo htmlspecialchars($row['review']); ?>"</p>
                    <h4>- <?php echo htmlspecialchars($row['customer_name']); ?> on <?php echo date("F j, Y", strtotime($row['created_at'])); ?></h4>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="testimonial">
                <p>No reviews available yet. Be the first to leave one!</p>
            </div>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Sweet Treats. All Rights Reserved.</p>
        <div class="social-icons">
            <a href="https://facebook.com/yourpage" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/yourprofile" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com/yourprofile" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

</body>
</html>
