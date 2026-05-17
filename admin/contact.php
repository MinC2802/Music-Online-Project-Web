<?php
$conn = new mysqli("localhost", "root", "", "vinyl_store");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Contact Responses</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>

</head>
<body>
    <div class="topnav">
        <a href="index.php"> Home </a> <!-- Set Active: Dashboard -->
        <a href="search.php"> Search Vinyls </a>
        <a href="manageUsers.php">Manage Users</a>
        <a class="active" href="contact.php"> Contact Responses </a>
        <a href="#" onclick="openLogoutModal()">Logout</a>
        
        <!-- 2.1.1.1 HTML: Search Bar -->
        <input type="text" id="mySearch" 
               onclick="location.href='search.php'" 
               placeholder="Search for Vinyl...">
    </div>

     <!-- 2.2 HTML: About Section -->
    <div class="aboutSection">
        <h1> Contact </h1>
        <p>
            This page displays messges and queries from clients and their contact details from oldest to newest.
        </p>
    </div>

    <h2 class="new">Submitted Contact Messages</h2>

    <?php if ($result->num_rows > 0): ?>
    <center>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>
    </center>

    <?php $conn->close(); ?>
    
  <!-- 2.6 HTML : The Loguout Confirmation Modal -->
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
