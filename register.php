<!-- PHP Connection -->
<!-- Connection to the database -->
<?php
session_start();
require 'db.php'; 

$error = '';

// send login details to database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username     = trim($_POST['username']);
    $email        = trim($_POST['email']);
    $password     = $_POST['password'];
    $confirm      = $_POST['confirm_password'];
    $isRetailer   = isset($_POST['is_retailer']) ? 1 : 0;

    // Validation (all fields, email and password)
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } 
    elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } 
    else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            // Insert user
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, is_retailer) VALUES (?, ?, ?, 'user', ?)");
            if ($stmt->execute([$username, $email, $hashed, $isRetailer])) {
                $success = "Registration successful! <a href='login.php'>Login here</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!-------------------------------------------------------------------------------------------------------------------------------->
<!-- HTML -->
<head>
    <title>Register - Vinyl Store</title>
    <link rel="stylesheet" href="css/StyleSheet.css">
</head>
<body class= "login-body">

<!-- Login Box -->
<div class="login-box">
    <h2>Register</h2>
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
    <div class="checkbox-wrapper">
        <label class="checkbox-label">
        <input type="checkbox" name="is_retailer" value="1">
        I am a retailer
        </label>
    </div>
    <button class="beigeButton" type="submit">Register</button>
</form>  
<p>Already have an account? <a href="login.php">Log in here</a>.</p>
</div>

</body>
</html>
