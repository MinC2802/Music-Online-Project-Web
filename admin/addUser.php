<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $role, $password);
    $stmt->execute();

    // 1.0 PHP : Check user role(user/admin) 
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        // 1.0.1 PHP: Redirects to login page
        header("Location: ../login.php");
        exit();
    }
    header("Location: manage_users.php");
    exit();
}
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
    <title>Manage User - Music Online </title>
</head>
<body>
    <div class="topnav">
        <a href="index.php"> Home </a> <!-- Set Active: Dashboard -->
        <a href="search.php"> Search Vinyls </a>
        <a class="active"  href="manageUsers.php">Manage Users</a>
        <a href="contact.php"> Contact Responses </a>
        <a href="#" onclick="openLogoutModal()">Logout</a>
        

        <!-- 2.1.1.1 HTML: Search Bar -->
        <input type="text" id="mySearch" 
               onclick="location.href='search.php'" 
               placeholder="Search for Vinyl...">
    </div>
    
    
<a href="javascript:history.back()" class="back-button">&larr; Back</a>
     <!-- 2.2 HTML: About Section -->
    <div class="aboutSection">
       
    </div>

<br>   
<form id="new-form" method="post">
    Username: <input id="new-input" type="text" name="username" required><br><br>
    Email:    <input id="new-input" type="email" name="email"><br><br>
    Role:     <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select><br><br>
    Password: <input id="new-input" type="password" name="password" required><br><br>
    <button class="pinkButton" type="submit">Add User</button>
</form>


<div id="logoutModal" class="modal">
    <div class="modalContent">
      <h2>Confirm Logout</h2>
      <p>Are you sure you want to logout?</p>
      <div class="modalButtons">
        <button class="logout" onclick="confirmLogout()">Yes, Logout</button>
        <button class="cancel" onclick="closeLogoutModal()">Cancel</button>
      </div>
    </div>
</div>
</body>
</html>
