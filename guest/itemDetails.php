<?php
session_start();

// 2. Check if ID is passed
if (!isset($_GET['id'])) {
    die("No item selected.");
}

include '../db.php';



// 3. Fetch vinyl info
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT vinyls.*, users.username 
    FROM vinyls 
    LEFT JOIN users ON vinyls.uploaded_by = users.id 
    WHERE vinyls.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Vinyl not found.");
}

$vinyl = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vinyl Details</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
</head>
<body>

<!-- Nav Bar -->
<div class="topnav">
    <a href="index.php">Home</a>
    <a class="active" href="search.php">Search Vinyls</a>
    <a href="#" onclick="openAccountModal()">Sell/My Listings</a>
    <a href="contact.php">Contact Us</a>
    <a href="#" onclick="openAccountModal()">Logout</a>
    <input type="text" id="mySearch" onkeyup=search() placeholder="Search for Vinyl...">
</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-button">&larr; Back</a>

<!-- Vinyl Details Layout -->
<div class="detailContainer">
    <div class="detailsLeft">
        <h2><?= htmlspecialchars($vinyl['title']) ?></h2>
        <p><strong>Artist:</strong> <?= htmlspecialchars($vinyl['artist']) ?></p>
        <p><strong>Genre:</strong> <?= htmlspecialchars($vinyl['genre']) ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($vinyl['type']) ?></p>
        <p><strong>Price:</strong> RM <?= number_format($vinyl['price'], 2) ?></p>
        <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($vinyl['description'])) ?></p>
        <p><strong>Updated at:</strong><br><?= nl2br(htmlspecialchars($vinyl['updated_at'])) ?></p>
        
        <p><strong>Uploaded by:</strong><br><?= nl2br(htmlspecialchars($vinyl['username'])) ?></p>
        


        <button class="beigeButton">Confirm Purchase</button>
    </div>
    <div class="detailsRight">
        <img src="../<?= htmlspecialchars($vinyl['image_url']) ?>" alt="Album Cover">
    </div>
</div>

<!-- Logout Modal -->
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
<!-- 2.6 HTML : The Account Confirmation Modal -->
  <div id="accountModal" class="modal">
    <div class="modalContent">
      <h2>Account Required</h2>
      <p>An account is required to access this page.</p>
      <div class="modalButtons">
        <button class="logout" onclick="location.href='../login.php'">Yes, Login</button>
        <button class="cancel" onclick="closeAccountModal()">Cancel</button>
      </div>
    </div>
  </div>


</body>
</html>