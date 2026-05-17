<!-- Part 1: PHP -->
<?php
// 1.0 PHP : Session start & check user role
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    // 1.0.1 PHP: Redirects unauthorized users
    header("Location: ../logout.php");
    exit();
}

// 1.1 PHP : Include database connection
include '../db.php';

// 1.2 PHP : Handle Add Vinyl
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $image_url = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../img/';
    $originalName = basename($_FILES['image']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $newFileName = uniqid('vinyl_', true) . '.' . $ext;
    $targetPath = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $image_url = 'img/' . $newFileName; // relative path to save in DB
    } else {
        die("Image upload failed.");
    }
} else {
    die("No image uploaded.");
}

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO vinyls (title, artist, genre, type, price, image_url, updated_at, updated_by) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("ssssdsi", $title, $artist, $genre, $type, $price, $image_url, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>Insert successful!</p>";
    } else {
        echo "<p>Insert failed.</p>";
    }
    $stmt->close();
}

// 1.3 PHP : Handle Update Vinyl
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];

    // 1.3.1 PHP : Check ownership
    $check = $conn->prepare("SELECT updated_by FROM vinyls WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        die("Record not found.");
    }
    $check->bind_result($owner_id);
    $check->fetch();

    if ($owner_id !== $user_id) {
        die("Unauthorized: You can only edit your own listings.");
    }

    // 1.3.2 PHP : Perform update
    $stmt = $conn->prepare("UPDATE vinyls SET title=?, artist=?, genre=?, type=?, price=?, updated_at=NOW(), updated_by=? WHERE id=?");
    $stmt->bind_param("ssssdii", $title, $artist, $genre, $type, $price, $user_id, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>Update successful!</p>";
    } else {
        echo "<p>Update failed or no changes made.</p>";
    }
    $stmt->close();
}

// 1.4 PHP : Handle Delete Vinyl
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $vinyl_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    // 1.4.1 PHP : Check ownership
    $check = $conn->prepare("SELECT updated_by FROM vinyls WHERE id = ?");
    $check->bind_param("i", $vinyl_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        die("Vinyl not found.");
    }
    $check->bind_result($owner_id);
    $check->fetch();

    if ($owner_id !== $user_id) {
        die("Unauthorized: You can only delete your own vinyls.");
    }

    // 1.4.2 PHP : Perform deletion
    $stmt = $conn->prepare("DELETE FROM vinyls WHERE id = ?");
    $stmt->bind_param("i", $vinyl_id);
    $stmt->execute();

    // 1.4.3 PHP : Redirect to avoid resubmission
    header("Location: record.php?deleted=1");
    exit();
}

// 1.5 PHP : Fetch user vinyls
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM vinyls WHERE updated_by = $user_id");
?>

<!-- Part 2: HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sell / Listings - musicOnline</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
</head>

<body>

<!-- 2.0 HTML : Navigation bar -->
<div class="topnav">
    <a href="index.php">Home</a>
    <a href="search.php">Search Vinyls</a>
    <a class="active" href="record.php">Sell/My Listings</a>
    <a href="contact.php">Contact Us</a>
    <a href="#" onclick="openLogoutModal()">Logout</a>
    <input type="text" id="mySearch" onkeyup="search()" placeholder="Search for Vinyl...">
</div>

<!-- 2.1 HTML : Page header -->
<div class="aboutSection">
    <h1>Sell / My Listings</h1>
    <p>Manage your vinyl listings here. You can add new vinyls or update existing ones.</p>
</div>

<br>
<!-- 2.2 HTML : Add Vinyl Form -->
<form id="new-form" method="POST" enctype="multipart/form-data">

    <div class="form-row">
        <input id="new-input" type="text" name="title" placeholder="Title" required>
        <input id="new-input" type="text" name="artist" placeholder="Artist" required>
        <input id="new-input" type="text" name="genre" placeholder="Genre" required>
        <input id="new-input" type="text" name="type" placeholder="Type (EP/NP)" required>
        <input id="new-input" type="number" step="0.01" name="price" placeholder="Price (RM)" required>
        <input id="new-input" type="file" name="image" accept="image/*" required>
 <br><br>
        <button class="beigeButton" type="submit" name="add">Add Vinyl</button>
    </div>
</form>

<!-- 2.3 HTML : Listings Table -->

<!-- 2.3 HTML : Vinyl Listings Grid -->
<div id="myMenu">

    <!-- 2.3.2 Loop through existing vinyls -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="itemStock">
            <form method="POST">
                    
                <!-- 2.3.3 PHP :Image and Description (title, image, artist, price, genre) -->
                <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="album">
                <h4><?= htmlspecialchars($row['title']) ?></h4>
                <p><strong>Artist:<input id="new-input" type="text" name="artist" value="<?= htmlspecialchars($row['artist']) ?>"></strong></p>
                <p><strong>Genre: <input id="new-input" type="text" name="genre" value="<?= htmlspecialchars($row['genre']) ?>"></strong></p>
                <p><strong>Type: <input id="new-input" type="text" name="type" value="<?= htmlspecialchars($row['type']) ?>"></strong></p>
                <p><strong>Price: <input id="new-input" type="number" step="0.01" name="price" value="<?= htmlspecialchars($row['price']) ?>"></p>
                <p><small>Updated: <?= $row['updated_at'] ?></small></p>
                <input id="new-input" type="hidden" name="id" value="<?= $row['id'] ?>">
                <button class="pinkButton" type="submit" name="update">Update</button>
                <button class="beigeButton" type="submit" name="delete" onclick="return confirm('Delete this vinyl?');">Delete</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>



<!-- 2.4 HTML : Logout Modal -->
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

