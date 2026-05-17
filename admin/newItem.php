<!-- Part 1: PHP -->
<?php

// 1.0 PHP : Check user role(user/admin)
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
     // 1.0.1 PHP: Redirects to login page
    header("Location: ../login.php");
    exit();
}

// 1.1 PHP : Import Vinyls table from database 
include '../db.php';

// 1.2 PHP : Handle insert
if (isset($_POST['insert'])) {
    $stmt = $conn->prepare("INSERT INTO vinyls (title, artist, genre, price, stock, image_url, description, type, updated_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdissss", $_POST['title'], $_POST['artist'], $_POST['genre'], $_POST['price'], $_POST['stock'], $_POST['image_url'], $_POST['description'], $_POST['type'], $_SESSION['user_id']);
    $stmt->execute();
}

// Fetch all vinyls
$result = $conn->query("SELECT * FROM vinyls ORDER BY updated_at DESC");
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Vinyl Dashboard</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
</head>
<body>
    <!-- 2.1.1 HTML : Navigation Bar  -->
    <div class="topnav">
        <a href="index.php"> Home </a> <!-- Set Active: Dashboard -->
        <a href="search.php"> Search Vinyls </a>
        <a class="active" href="record.php">All Vinyl</a>
        <a href="manageUsers.php">Manage Users</a>
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


    

    <!-- Insert New Record Form -->
    <h2>Add New Vinyl</h2>
    <form id="new-form" method="POST">
        <form>
  <div class="form-group">
    <label id="new-label" for="title">Title<span>*</span></label>
    <input id="new-input" type="text" name="title" id="title" required>
  </div>

  <div class="form-group">
    <label id="new-label" for="artist">Artist</label>
    <input id="new-input"type="text" name="artist" id="artist">
  </div>

  <div class="form-group">
    <label id="new-label" for="genre">Genre</label>
    <input id="new-input" type="text" name="genre" id="genre">
  </div>

  <div class="form-group">
    <label id="new-label" for="price">Price<span>*</span></label>
    <input id="new-input" type="number" name="price" id="price" step="0.01" required>
  </div>

  <div class="form-group">
    <label id="new-label" for="stock">Stock<span>*</span></label>
    <input id="new-input" type="number" name="stock" id="stock" required>
  </div>

  <div class="form-group">
    <label id="new-label" for="image_url">Image URL</label>
    <input id="new-input" type="text" name="image_url" id="image_url">
  </div>

  <div class="form-group">
    <label id="new-label" for="type">Type</label>
    <input id="new-input" type="text" name="type" id="type">
  </div>

  <div class="form-group">
    <label id="new-label" for="description">Description</label>
    <textarea id="new-textarea" name="description" id="description"></textarea>
  </div>

  <div class="form-group center">
    <button class="pinkButton" type="submit">Submit</button>
  </div>
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

</body>
</html>
