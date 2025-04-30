<?php
include('database.php');
$message_sent = false;

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $message = htmlspecialchars($_POST["message"]);

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($stmt->execute()) {
        $message_sent = true;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link rel="stylesheet" href="../css/contact.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</head>
<style>
    textarea{
        width:90%;
    }
    input{
        width:90%;
    }
    .contact-info
    {
        margin-left:10px;
    }

</style>
<body>
  <header>
    <nav>
      <img class="logimg" src="../images/logice.png" alt="Logo"/>
      <ul class="unlist">
        <div class="first">
          <li class="home"><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="my_orders.php">My Orders</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </div>
        <div class="second">
          
          <li class="cart"><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
        </div>
      </ul>
    </nav>
    <h1>Contact Us</h1>
    <p>We’d love to hear from you! Send us a message.</p>
  </header>

  <section class="contact-container">
    <?php if ($message_sent): ?>
      <p class="success-message">Your message has been sent successfully! 🎉</p>
    <?php else: ?>
      <div class="contact-form">
        <h2>Get in Touch</h2>
        <form action="contact.php" method="POST">
          <label for="name">Your Name</label>
          <input type="text" id="name" name="name" required/>

          <label for="email">Your Email</label>
          <input type="email" id="email" name="email" required/>

          <label for="phone">Your Phone</label>
          <input type="text" id="phone" name="phone" required pattern="[0-9]{10}" title="Enter 10 digit phone number"/>

          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit">Send Message</button>
        </form>
      </div>
    <?php endif; ?>

    <div class="contact-info">
      <h2>Contact Information</h2>
      <p><strong>Email:</strong> contact@yourwebsite.com</p>
      <p><strong>Phone:</strong> 9090909090</p>
      <p><strong>Address:</strong> Urwa Store, Mangaluru</p>
      <div class="social-links">
        <a href="https://facebook.com/yourpage" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com/yourprofile" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://instagram.com/yourprofile" target="_blank"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </section>
</body>
</html>
