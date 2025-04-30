<?php
include('database.php');

$error_message = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = trim($_POST['name']); 
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validation
    if (empty($name)) {
        $error_message = "Name is required!";
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        $error_message = "Only letters and spaces are allowed in the name.";
    } elseif (strlen($name) < 3 || strlen($name) > 50) {
        $error_message = "Name must be between 3 and 50 characters.";
    } elseif (empty($email) || empty($password) || empty($confirm_password) || empty($phone) || empty($address)) {
        $error_message = "All fields are required!";
    } elseif (!preg_match("/^\d{10}$/", $phone)) {
        $error_message = "Phone number must be exactly 10 digits.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $sql_check_email = "SELECT * FROM users WHERE email = ?";
        if ($stmt_check = $conn->prepare($sql_check_email)) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                $error_message = "This email is already registered!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql_insert = "INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);

                    if ($stmt_insert->execute()) {
                        $error_message = "<span class='success'>Registration successful!</span>";
                    } else {
                        $error_message = "Error: " . $stmt_insert->error;
                    }
                    $stmt_insert->close();
                }
            }
            $stmt_check->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="../css/registation.css">
    <style>
        .reg{
           margin-left:17px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container"> 
        <h2>Register</h2>
        
        <?php if (!empty($error_message)) : ?>
            <p class="<?php echo strpos($error_message, 'success') !== false ? 'success' : 'error'; ?>">
                <?php echo $error_message; ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" placeholder="Enter your Full Name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" placeholder="Enter your email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" placeholder="Enter your phone number" name="phone" required pattern="\d{10}" >


            <label for="address">Address:</label>
            <input type="text" id="address" placeholder="Enter your address" name="address" required>

            <label for="password">Password:</label>
            <input type="password" id="password" placeholder="Enter your password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" placeholder="Confirm Password" name="confirm_password" required>

            <input class='reg' type="submit" value="Register">
        </form>
        <a href="login.php">Already have an account? Login now</a>
    </div>
</body>
</html>
