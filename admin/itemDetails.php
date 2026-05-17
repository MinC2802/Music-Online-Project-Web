
<!-- Part 1: PHP -->
<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("No item selected.");
}

include '../db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM vinyls WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Vinyl not found.");
}

$vinyl = $result->fetch_assoc();
?>

<!-- Part 2: HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Vinyl Details</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
</head>
<body>

<!-- Nav Bar -->
<div class="topnav">
   <a href="index.php"> Home </a>
   <a class="active" href="search.php"> Search Vinyls </a>
   <a href="manageUsers.php">Manage Users</a>
   <a href="contact.php"> Contact Responses </a>
   <a href="#" onclick="openLogoutModal()">Logout</a>
   <input type="text" id="mySearch" onkeyup="search()" placeholder="Search for Vinyl...">
</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-button">&larr; Back</a>

<!-- Editable Form -->
<form action="update_record.php" method="POST" enctype="multipart/form-data">
<div class="detailContainer">
    <div class="detailsLeft">
        <input type="hidden" name="id" value="<?= $vinyl['id'] ?>">

        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($vinyl['title']) ?>" required>

        <label>Artist</label>
        <input type="text" name="artist" value="<?= htmlspecialchars($vinyl['artist']) ?>" required>

        <label>Genre</label>
        <input type="text" name="genre" value="<?= htmlspecialchars($vinyl['genre']) ?>" required>

        <label>Type</label>
        <input type="text" name="type" value="<?= htmlspecialchars($vinyl['type']) ?>" required>

        <label>Price (RM)</label>
        <input type="number" name="price" step="0.01" value="<?= $vinyl['price'] ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($vinyl['description']) ?></textarea>

        <label>Update Image</label>
        <input type="file" name="image">

        <button type="submit" class="beigeButton">Save Changes</button>
    </div>
    <div class="detailsRight">
        <img src="../<?= htmlspecialchars($vinyl['image_url']) ?>" alt="Album Cover">
    </div>
</div>
</form>

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

</body>
</html>

