<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Home</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="scripts.js" defer></script>
</head>
<body>
<header>
<nav>
        <img class="logimg" src="../images/logice.png" alt="">
        <ul class="unlist">
            <div class="first">
                <li class="home"><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="my_orders.php">My Orders</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </div>
            <div class="second">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="login"><i class="fa-solid fa-user"></i></a>
                    <div class="dropdown-content">
                        <a class="lgt" href="intro.html">Logout</a>
                    </div>
                </li>
                <li class="cart"><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </div>
        </ul>
    </nav>
    </header>
    <style>
        
        .checkout{
           font-size: 20px;
           font-weight:bold;
           margin-top:25px;
           color: #333;
           padding: 10px;
           border: 1px solid #333;
           border-radius: 5px;
           background-color: rgb(177, 172, 172); 
           cursor:pointer;
        }
        .checkout:hover{
            background-color:rgb(46, 45, 45); 
            color:rgb(216, 215, 215); 

        }
        .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-content {
        font-size:20px;
        font-weight:bold;
        display: none;
        position: absolute;
        background-color:rgb(238, 208, 238);
        border-radius:5px ;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        color: black;
        padding: 10px 10px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        border-radius:8px ;
        background-color:rgb(252, 138, 242);
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    h1
    {
        color:rgb(71, 70, 71);;
        font-family: "Times New Roman", Times, serif;

    }
    .fav
    {
        color:rgb(71, 70, 71);;
        font-family: "Times New Roman", Times, serif;



    }

    </style>

    <section class="hero">
        <h1>Thank you For loging in</h1>
        <p class="fav">Your favorite ice cream is just a click away.</p>
        <div class="categories">
                <div id="catgry1" class="category">
                <img src="../images/milkshake.jpg" alt="Milkshakes">
                <h3>Milkshakes</h3>
                <p>Refreshing, creamy, and packed with flavors. Try our signature milkshakes!</p>
                <a href="milkshakes.php">
                    <button class="checkout">Explore Now!</button>
                 </a>
            </div>
            <div id="catgry2" class="category">
                <img src="../images/icecream.jpg" alt="Ice Creams">
                <h3>Ice Creams</h3>
                <p>Classic and unique flavors that melt in your mouth. Find your favorite scoop!</p>
                <a href="icecreams.php">
                    <button class="checkout">Explore Now!</button>
                 </a>
            </div>
            <div id="catgry3" class="category">
                <img src="../images/deserts.jpg" alt="Desserts">
                <h3>Snacks</h3>
                <p>From sundaes to waffles, our desserts are the perfect sweet treat!</p>
                <a href="desserts.php">
                    <button class="checkout">Explore Now!</button>
                 </a>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; Sweet Temptation Ice Creams 2025. All rights reserved.</p>
    </footer>
</body>
</html>
