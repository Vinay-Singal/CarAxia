<?php
// DB credentials.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'carrental');

try {
    // Establish database connection.
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

    // Set PDO to throw exceptions on error.
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected successfully!";
    // You can add more code here to perform database operations

} catch (PDOException $e) {
    // Print error message and exit if connection fails
    exit("Error: " . $e->getMessage());
}
?>
