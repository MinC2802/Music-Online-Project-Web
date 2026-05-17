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
$sql = "SELECT vinyls.*, users.username AS uploaded_by 
        FROM vinyls 
        LEFT JOIN users ON vinyls.updated_by = users.id";
$result = $conn->query($sql);
?>

<!-- Part 2: HTML -->
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- 2.0 HTML : import stylesheet (dashStyleSheet), javascript(Script2), set title -->
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
    <title>Search - MusicOnline.com</title>
</head>

<!-- 2.1 HTML : Define Page Contents -->
<body>

    <!-- 2.1.1 HTML : Navigation Bar -->
    <div class="topnav">
        <a href="index.php"> Home </a> <!-- Set Active: Dashboard -->
        <a class="active" href="search.php"> Search Vinyls </a>
        <a href="manageUsers.php">Manage Users</a>
        <a href="contact.php"> Contact Responses </a>
        <a href="#" onclick="openLogoutModal()">Logout</a>
        
        <!-- 2.1.1.1 HTML: Search Bar -->
        <input type="text" id="mySearch" onkeyup="combinedFilter()" placeholder="Search for Vinyl...">
    </div>

    <!-- 2.2 HTML: About Section -->
    <div class="aboutSection">
        <h1> Search your favourite Vinyls! </h1>
        <p>
            This is the search Vinyl page.
        <br>
            The search function is on top and you may filter by artist, album and title as well below. The dropdown menu is for artists, genres and extended play (EP) or normal play (NP).
        </p>
        <!-- 2.2.1 HTML : Dropdown Filter (About Section) -->
        <select class="filters" id="searchMode" onchange="combinedFilter()">
            <option value="all">All</option>
            <option value="title">Title</option>
            <option value="artist">Artist</option>
            <option value="genre">Genre</option>
            <option value="uploaded_by">Uploaded By</option>
        </select>
    </div>

    <!-- 2.3 HTML: Search functions -->
    <div id="myMenu">
        
        <div class="itemStock2">
            <h2> New Item </h2>
            <center><button class="pinkButton" onclick="location.href='newItem.php'">New Vinyl</button></center>
        
        </div>

        <!-- 2.3.1 PHP : Fetching information from database (select all) -->
        <?php while ($row = $result->fetch_assoc()): ?>

        <!-- 2.3.2 PHP : Fetch item (artist, genre, type, image)-->
        <div class="itemStock" 
            data-artist="<?= htmlspecialchars($row['artist']) ?>" 
            data-genre="<?= htmlspecialchars($row['genre']) ?>" 
            data-type="<?= htmlspecialchars($row['type']) ?>"
            data-uploaded-by="<?= htmlspecialchars($row['uploaded_by']) ?>">

            <!-- 2.3.3 PHP :Image and Description (title, image, artist, price, genre) -->
            <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="album">
            <h2><?= htmlspecialchars($row['title']) ?></h2>
            <p>Artist: <?= htmlspecialchars($row['artist']) ?></p>
            <hr>
            <p class="price">RM <?= htmlspecialchars($row['price']) ?></p>
            <p>Genre: <?= htmlspecialchars($row['genre']) ?></p>
            <p>Uploaded By: <?= htmlspecialchars($row['uploaded_by']) ?></p>
            <button class="pinkButton" onclick="location.href='itemDetails.php?id=<?= $row['id'] ?>'">Item Details</button>
        </div>

        <?php endwhile; ?>
    </div>

    <!-- 2.3.3 HTML: results  -->
        <div id="results">
        </div>
    
    <!-- 2.4 HTML : Logout -->
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

<!-- 2.7 HTML : Copyright Information -->
<footer>
    <p>Contact us: 
    <br> support@musicOnline.com </p>    
    <hr>
    <p>&copy; 2025 musicOnline. All rights reserved.</p>
</footer>

</html>