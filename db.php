
<?php
	// define host, db, user, password and charset as variables
	$host	 = 'localhost';
	$db		 = 'vinyl_store'; // database name
	$user	 = 'root';
	$pass	 = '';
	$charset = 'utf8mb4';

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