<!-- Part 1: PHP -->
<?php

// 1.1 PHP : Connection to database
include '../db.php';

// 1.2 PHP : Store username from session
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$_SESSION['username'] = $username;
$stmt->close();

// 1.3 PHP : Handle contact form submission
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1.3.1 PHP : Sanitize input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // 1.3.2 PHP : Insert query
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Message sent successfully!";
    } else {
        $successMessage = "Error: " . $conn->error;
    }
}
?>

<!-- Part 2: HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
    <title>Contact - Music Online </title>
    
</head>

<body>
    <!-- 2.1 HTML : Navigation bar -->
    <div class="topnav">
        <a href="index.php"> Home </a>
        <a href="search.php"> Search Vinyls </a>
        <a href="record.php"> Sell/My Listings </a>
        <a class="active" href="contact.php"> Contact Us </a>
        <a href="#" onclick="openLogoutModal()">Logout</a>
        <input type="text" id="mySearch" onclick="location.href='search.php'" placeholder="Search for Vinyl...">
    </div>

    <!-- 2.2 HTML : About section -->
    <div class="aboutSection">
        <h1>Contact Us!</h1>
        <p>This is the contact page! Any feedback is greatly appreciated :3</p>
    </div>

    
   <br>
    <!-- 2.3 HTML : Contact form and info -->
    <div class="contactContent">
        <div class="contactForm">
                <form method="POST" action="contact.php">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="<?= htmlspecialchars($_SESSION['username']) ?>" required>
                <br><br>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your email" required>
                <br><br>
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Type your message..." required></textarea>   
    
                <button type="submit" class="pinkButton">Send Message</button>
            </form>
        </div>

        <div class="contactInfo">
            <h2>Reach us at</h2>
            <p><b>Email:</b> support@musicOnline.com</p>
            <p><b>Phone:</b> +60 123-456 789</p>
            <p><b>Address:</b> 123 Vinyl Street, KL, Malaysia</p>
        </div>
    </div>


    <!-- 2.4 HTML : Google Map -->
    <div class="mapContainer">
        <iframe src="https://www.google.com/maps/embed?pb=..."
            width="100%" height="300" style="border:0;" allowfullscreen=""
            loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    
    <!-- 2.5 HTML : Logout Modal -->
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

    <!-- 2.6 HTML : Success Popup -->
    <div id="popup" class="popup"><?php echo $successMessage; ?></div>

</body>

<!-- 2.7 HTML : Copyright Information -->
<footer>
    <p>Contact us: 
    <br> support@musicOnline.com </p>    
    <hr>
    <p>&copy; 2025 musicOnline. All rights reserved.</p>
</footer>

</html>
