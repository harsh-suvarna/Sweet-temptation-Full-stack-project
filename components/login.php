<?php
session_start();
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];            // ✅ Added line
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Highway Ice Creams</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fce4ec;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background: #fff;
        padding: 30px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        width: 350px;
        text-align: center;
    }

    h2 {
        color:rgb(240, 125, 221);
        margin-bottom: 20px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn {
        background-color:rgb(247, 145, 225);
        color: white;
        padding: 10px;
        border: none;
        width: 100%;
        font-size: 18px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
    }

    .btn:hover {
        background-color:rgb(241, 225, 231);
    }
    /*.login-container a{
        margin-top:30px;
    }*/

    .error {
        color: red;
        font-size: 14px;
    }
   
</style>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button style="margin-bottom:5px" type="submit" class="btn">Login</button>
            <a style="margin-bottom:5px" class="reg" href="registration.php">new user?register now</a></br>
            <a  class="forpas" href="forgot_password.php">Forgot password?</a>
        </form>
    </div>

</body>
</html>
