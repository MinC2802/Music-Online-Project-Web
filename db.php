
<?php
	// define host, db, user, password and charset as variables
	if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
		// 1. Local XAMPP Configuration
		$host	 = 'localhost';
		$db		 = 'vinyl_store'; // your local database name
		$user	 = 'root';
		$pass	 = '';
	} else {
		// 2. InfinityFree Configuration (Replace these placeholder values with your live ones)
		$host	 = 'sql302.infinityfree.com';  // Your MySQL Hostname from InfinityFree panel
		$user	 = 'if0_41946538';             // Your MySQL Username from InfinityFree panel
		$pass	 = 'VZvpkrWXyznb6';  // Your InfinityFree Client Account Password
		$db		 = 'if0_34567890_vinyl_store'; // Your InfinityFree Database Name
	}

	// connect to database with preset variables
	$dsn  = "mysql:host=$host; dbname=$db; charset=$charset";
	$conn = new mysqli($host, $user, $pass, $db);

	$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // data fetching methods
];

//try... catch loop for database connetion error
try { 
	$pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e)	{
	 exit("Database connection failed: " . $e->getMessage());
}
?>
