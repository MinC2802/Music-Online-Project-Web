<!-- Part 1: PHP -->
<?php


// 1.0.1 php : Connection to database
include '../db.php';

// 1.1 PHP : Import Vinyls table from database 
$sql = "SELECT * FROM vinyls";
$result = $conn->query("SELECT * FROM vinyls");

?>

<!-- Part 2: HTML -->
<!DOCTYPE html>
<html lang="en">

<!-- 2.0 HTML : import stylesheet (dashStyleSheet), javascript(Script2), set title -->
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <script src="../jscript/Script.js"></script>
    <title> MusicOnline.com </title>
</head>

<!-- 2.1 HTML : Define Page Contents -->
<body>
    <!-- 2.1.1 HTML : Navigation Bar  -->
    <div class="topnav">
         <a class="active" href="index.php">Home</a>
        <a href="search.php">Search Vinyls</a>
        <a href="#" onclick="openAccountModal()">Sell/My Listings</a>
        <a href="contact.php">Contact Us</a>
        <a href="#" onclick="openAccountModal()">Login</a>
   
        <!-- 2.1.1.1 HTML: Search Bar -->
        <input type="text" id="mySearch" 
               onclick="location.href='search.php'" 
               placeholder="Search for Vinyl...">
    </div>

    <!-- 2.2 HTML: About Section -->
    <div class="aboutSection">
        <h1> Welcome! </h1>
        <p>
            Hi User! Welcome to musicOnline [2025] ! This is a Malaysian business start up that was launched by
            quavers&quartets in June 2025.
        <br>
            This webpage allows users to search and sell Vinyl music (albums, extended plays, singles) that
            are available for sale. As of June 2025, the Vinyl collection is at 15 different music records and is
            expected to have at least 100 by the end of 2026. 67% of users have reported easier finds using this site.
            Your support is greatly appreciated!
        </p>
    </div>

     <!-- 2.2.1 HTML : Intro to Platform Features-->
    <div class="introduction">
    <h2> Hover to see page features </h2> 
         <div class="nav-grid">
    <a href="index.html" class="nav-card">
      <div class="nav-title">Home</div>
      <div class="nav-desc">
        Welcome to our vinyl community! Discover featured records and our mission.
      </div>
    </a>

    <a href="search.html" class="nav-card">
      <div class="nav-title">Search Vinyl</div>
      <div class="nav-desc">
        Browse vinyl by artist, genre, decade, or condition.
      </div>
    </a>

    <a href="sell.html" class="nav-card">
      <div class="nav-title">Sell / My Listings</div>
      <div class="nav-desc">
        List and manage your vinyl records for sale.
      </div>
    </a>

    <a href="contact.html" class="nav-card">
      <div class="nav-title">Contact Us</div>
      <div class="nav-desc">
        Questions or feedback? Reach out to our team.
      </div>
    </a>

    <a href="logout.html" class="nav-card">
      <div class="nav-title">Logout</div>
      <div class="nav-desc">
        Securely log out and return to the homepage.
      </div>
    </a>
  </div>    
    </div>


    <!-- 2.3 HTML : Featured Banner -->
    <div class="featuredBanner">
        <h2 class="featuredTitle"> Featured albums: </h2>
        <hr>
        <div class="featuredItems" id="featuredItems">
        
        <!-- 2.3.1 PHP : Fetching information from database (select all roles with price <100) -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php if ($row['price'] <= 100) continue; ?>

        <!-- 2.3.2 PHP : Fetch item (artist, genre, type)-->
            <div class="featuredItem" 
                data-artist="<?= htmlspecialchars($row['artist']) ?>" 
                data-genre="<?= htmlspecialchars($row['genre']) ?>" 
                data-type="<?= htmlspecialchars($row['type']) ?>">

            <!-- 2.3.3 PHP :Image and Description (title, genre, price) -->
                <div class="imageWrapper">
                <div class="ribbon">RARE &#128165;</div>
                    <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="album">
                </div>
            
                <div class="description">
                    <p><b><?= htmlspecialchars($row['title']) ?></b></p>
                    <p>Artist: <?= htmlspecialchars($row['artist']) ?></p>
                    <hr>
                    <p class="price">RM <?= htmlspecialchars($row['price']) ?></p>
                    <button class="pinkButton" onclick="location.href='itemDetails.php?id=<?= $row['id'] ?>'">Buy Now!</button>
                </div>
            </div>

            <?php endwhile; ?>
        </div>
        
        <!-- 2.3.4 HTML : Scroll Buttons -->
        <button class="leftButton" onclick="returnItem(-1,'featuredItems')">&#10094;</button>
        <button class="rightButton" onclick="returnItem(1,'featuredItems')">&#10095;</button>

    </div> <br>

    <!-- 2.3.5 HTML : The dots/circles (8 pages)-->
    <div style="text-align:center">
        <span class="dot" onclick="goToPage(0,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(1,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(2,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(3,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(4,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(5,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(6,'featuredItems')"></span>
        <span class="dot" onclick="goToPage(7,'featuredItems')"></span>
    </div><br>
       

    <!-- 2.4 HTML : Motto Section -->
    <div class="mottoSection">
        <h2>Our Motto</h2>
        <p>"Quality in every note. Passion in every product."</p>
    </div>

    <!-- 2.5 HTML : Mission Section -->
    <div class="missionSection">
        <h2>Our Mission</h2>
        <p>
            We aim to revolutionize how music lovers experience sound. By offering
            top-tier audio gear, we empower artists and listeners with tools that
            combine innovation, style, and unbeatable performance.
        </p>
    </div>

    
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

<!-- 2.7 HTML : Copyright Information -->
<footer>
    <p>Contact us: 
    <br> support@musicOnline.com </p>    
    <hr>
    <p>&copy; 2025 musicOnline. All rights reserved.</p>
</footer>


</html>
