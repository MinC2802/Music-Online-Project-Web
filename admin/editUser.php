<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("No user selected.");
}

include '../db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User Details</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
</head>
<body>

<!-- Nav Bar -->
<div class="topnav">
   <a href="index.php"> Home </a>
   <a href="search.php"> Search Vinyls </a>
   <a class="active" href="manageUsers.php">Manage Users</a>
   <a href="contact.php"> Contact Responses </a>
   <a href="#" onclick="openLogoutModal()">Logout</a>
   <input type="text" id="mySearch" onkeyup="search()" placeholder="Search for Vinyl...">
</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-button">&larr; Back</a>

<!-- Editable Form -->
<form action="update_user.php" method="POST">
<div class="detailContainer">
    <div class="detailsLeft">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Role</label>
        <select name="role" required>
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <br><br>

        <label>Retailer</label> 
        <select name="is_retailer" required>
            <option value="1" <?= $user['is_retailer'] ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= !$user['is_retailer'] ? 'selected' : '' ?>>No</option>
        </select> <br> <br>

        <label>Created At</label>
        <input type="text" value="<?= $user['created_at'] ?>" disabled>

        <button type="submit" class="beigeButton">Save Changes</button>
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
