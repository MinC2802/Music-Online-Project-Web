<?php
// Force errors to display so we can debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$charset = 'utf8mb4'; // FIXED: Defined the charset variable at the top

// Check if the website is running locally (XAMPP) or online (InfinityFree)
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    // 1. Local XAMPP Configuration
    $host = 'localhost';
    $db   = 'vinyl_store'; 
    $user = 'root';
    $pass = '';
} else {
    // 2. InfinityFree Configuration 
    $host = 'sql302.infinityfree.com';  
    $user = 'if0_41946538';             
    $pass = 'VZvpkrWXyznb6';  
    $db   = 'if0_41946538_vinyl_store'; 
}

// Connect to database with preset variables (MySQLi)
$dsn  = "mysql:host=$host;dbname=$db;charset=$charset"; // FIXED: Cleaned up spacing
$conn = new mysqli($host, $user, $pass, $db);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC        // data fetching methods
];

// Try... catch loop for database connection error (PDO)
try { 
    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e) {
    exit("Database connection failed: " . $e->getMessage());
}
?>
