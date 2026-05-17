<!-- PHP Connection -->
<!-- Connection to the database -->
<?php
session_start();
require 'db.php';

$error = '';

// send login details to database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?"); // SQL query
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) { // verification
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['username'] = $user['username'];

        if ($user['role'] === 'admin') { // allocation of different homepages
            header("Location: admin/index.php"); // admin login
        } 
        else {
            header("Location: user/index.php"); // user login
        }
        exit(); //end function
    } 
    else { // error handling 
        $error = "Invalid email or password.";
    }
}
?>

<!-------------------------------------------------------------------------------------------->
<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Login - Music Online </title>
    <link rel="stylesheet" href="css/StyleSheet.css">
</head>

<body class="login-body">
<center>
<div class="login-box">
    <h2>Login</h2>

    <!-- displays database connection error -->
    <?php if ($error): ?>
        <p class="error"> <?= htmlspecialchars($error) ?> </p>
    <?php endif; ?>

    <!-- gather user details for login -->
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button class="pinkButton" type="submit">Log In</button>
    </form>

    <!-- link to register -->
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    <!-- browse as guest -->
    <button class="beigeButton" onclick="location.href='guest/index.php'">Browse as Guest</button>

</div>
<center>
</body>
</html>



