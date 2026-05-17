<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $delete_id");
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$result = $conn->query("
    SELECT 
        users.id,
        users.username,
        users.email,
        users.role,
        users.created_at,
        users.is_retailer,
        COUNT(vinyls.id) AS vinyl_count
    FROM 
        users
    LEFT JOIN 
        vinyls ON vinyls.uploaded_by = users.id
    GROUP BY 
        users.id, users.username, users.email, users.role, users.created_at, users.is_retailer
    ORDER BY 
        users.id
;")
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
</head>
<body>
    <!-- 2.1.1 HTML : Navigation Bar  -->
    <div class="topnav">
        <a href="dashboard.php"> Home </a> <!-- Set Active: Dashboard -->
        <a href="search.php"> Search Vinyls </a>
        <a class="active" href="manage_users.php">Manage Users</a>
        <a href="contact.php"> Contact Responses </a>
        <a href="#" onclick="openLogoutModal()">Logout</a>
        
        <!-- 2.1.1.1 HTML: Search Bar -->
        <input type="text" id="mySearch" 
               onclick="location.href='search.php'" 
               placeholder="Search for Vinyl...">
    </div>

    <!-- 2.2 HTML: About Section -->
    <div class="aboutSection">
        <h1> Manage users </h1>
        <p>
            Hi admin! This is the manage users page.
        <br>
            You may edit, delete, update, and add user information as shown below.
        </p>
    </div>
    <br><br>

    <!-- 2.3 HTML: Table -->
    <center>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Retailer Status</th>
            <th>Vinyls uploaded</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td><?= $row['is_retailer'] ? 'Yes' : 'No' ?></td>
            <td><?= $row['vinyl_count'] ?></td>
            <td>
                <a href="editUser.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="manageUsers.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    

    <br>
    <a href="addUser.php"> <button class="pinkButton" onclick=""> Add New User </button></a>
    </center>

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

